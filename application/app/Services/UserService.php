<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Exceptions\ServiceException;
use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\EntityService;
use App\Core\Types\Principal;
use App\Core\Utils\JwtUtils;
use App\Core\Utils\Utils;
use App\Models\User;
use App\Models\UserSession;
use App\Repositories\RoleAuthorityRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRoleRepository;
use App\Repositories\UserSessionRepository;
use DateInterval;
use DateTime;
use Exception;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Psr\Container\ContainerInterface as Container;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\Translation\Translator;

/**
 * @extends EntityService<User, UserRepository>
 */
class UserService extends EntityService
{

    /**
     * @var RoleRepository
     */
    protected RoleRepository $roleRepository;

    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * @var UserRoleRepository
     */
    protected UserRoleRepository $userRoleRepository;

    /**
     * @var UserSessionRepository
     */
    protected UserSessionRepository $userSessionRepository;

    /**
     * @var RoleAuthorityRepository
     */
    protected RoleAuthorityRepository $roleAuthorityRepository;

    /**
     * @param Container $container
     * @param Logger $logger
     * @param Translator $translator
     * @param UserRepository $userRepository
     * @param UserRoleRepository $userRoleRepository
     * @param UserSessionRepository $userSessionRepository
     * @param RoleRepository $roleRepository
     * @param RoleAuthorityRepository $roleAuthorityRepository
     */
    #[Pure]
    public function __construct(
        Container               $container,
        Logger                  $logger,
        Translator              $translator,
        UserRepository          $userRepository,
        UserRoleRepository      $userRoleRepository,
        UserSessionRepository   $userSessionRepository,
        RoleRepository          $roleRepository,
        RoleAuthorityRepository $roleAuthorityRepository
    )
    {
        parent::__construct($container, $logger, $translator);

        $this->roleAuthorityRepository = $roleAuthorityRepository;
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->userSessionRepository = $userSessionRepository;
    }

    /**
     * @return EntityRepository|UserRepository
     */
    protected function getRepository(): EntityRepository|UserRepository
    {
        return $this->userRepository;
    }

    /**
     * 用户注册
     *
     * @param array $user
     * @return array
     * @throws ServiceException
     */
    #[ArrayShape([
        'username' => "string",
        'password' => "string",
        'email' => "string"
    ])]
    public function register(array $user): array
    {
        $this->save($user);
        return $user;
    }

    /**
     * 密码登录
     *
     * @param array $credentials
     * @param Request $request
     * @return array
     * @throws Exception
     * @throws ServiceException
     */
    #[ArrayShape(['access_token' => "string", 'refresh_token' => "string"])]
    public function login(array $credentials, Request $request): array
    {
        $user = $this->findUserByUserName($credentials['username']);
        // 用户是否禁用
        if (!$user->active) {
            throw new ServiceException('messages.auth_error_001');
        }
        // 检查密码是否匹配
        if (!Utils::check($credentials['password'], $user->password)) {
            throw new ServiceException('messages.auth_error_001');
        }

        // 生成用户登录记录
        $sessionId = Utils::uuid();
        $now = new DateTime();

        $session = new UserSession();
        $session->session_id = $sessionId;
        $session->user_id = $user->id;
        $session->start_datetime = $now;
        $session->last_access_datetime = $now;
        $this->userSessionRepository->createUserSession($session);

        // 生成新的访问凭证
        return $this->generateJwtToken($sessionId, $user);
    }

    /**
     * 刷新凭证
     *
     * @param array $credentials
     * @return array
     * @throws ServiceException
     * @throws Exception
     */
    #[ArrayShape(['access_token' => "string", 'refresh_token' => "string"])]
    public function refresh(array $credentials): array
    {
        $payload = JwtUtils::parseRefreshToken($credentials['refresh_token']);
        // 获取用户信息
        $user = $this->findUserByUserName($payload->username);
        // 用户是否禁用
        if ($user['active'] == 0) {
            throw new ServiceException('messages.auth_error_001');
        }
        $sessionId = $payload->id;
        // 检查会话记录是否已经过期
        $session = $this->userSessionRepository->findBySessionId($sessionId);
        if ($session->end_datetime != null) {
            throw new ServiceException('messages.auth_error_001');
        }
        // 更新用户登录记录
        $this->userSessionRepository->updateUserSession($sessionId, $user);
        // 生成新的访问凭证
        return $this->generateJwtToken($sessionId, $user, false);
    }

    /**
     * 退出登录
     *
     * @param array $params
     * @throws Exception
     */
    public function logout(array $params): void
    {
        $sessionId = '';
        if (isset($params['refresh_token'])) {
            $payload = JwtUtils::parseRefreshToken($params['refresh_token']);
            $sessionId = $payload->id;
        } else if (isset($params['access_token'])) {
            $payload = JwtUtils::parseAccessToken($params['access_token']);
            $sessionId = $payload->id;
        }
        if (strlen($sessionId) > 0) {
            $this->userSessionRepository->removeUserSession($sessionId);
        }
    }

    /**
     * Generate Jwt Token
     *
     * @param string $sessionId
     * @param array|User $user
     * @param bool $withRefreshToken
     * @return array
     * @throws Exception
     */
    #[ArrayShape(['access_token' => "string", 'refresh_token' => "string"])]
    public static function generateJwtToken(string $sessionId, array|User $user, bool $withRefreshToken = true): array
    {
        // 获取当前时间
        $now = new DateTime();
        // 访问凭证，1天有效期
        $accessTokenPayload['type'] = '1';
        $accessTokenPayload['id'] = $sessionId;
        $accessTokenPayload['uid'] = $user->id;
        $accessTokenPayload['username'] = $user->username;
        $accessTokenPayload['exp'] = $now->add(new DateInterval('P1D'))->getTimestamp();

        if ($withRefreshToken) {
            // 刷新凭证，14天有效期
            $refreshTokenPayload['type'] = '2';
            $refreshTokenPayload['id'] = $sessionId;
            $refreshTokenPayload['uid'] = $user->id;
            $refreshTokenPayload['username'] = $user->username;
            $refreshTokenPayload['exp'] = $now->add(new DateInterval('P14D'))->getTimestamp();

            return [
                'access_token' => JwtUtils::createJwtToken($accessTokenPayload),
                'refresh_token' => JwtUtils::createJwtToken($refreshTokenPayload),
            ];
        } else {
            return [
                'access_token' => JwtUtils::createJwtToken($accessTokenPayload),
            ];
        }
    }

    /**
     * 解析访问凭证，获取用户登录信息。
     *
     * @param object $payload
     * @return Principal
     * @throws ServiceException
     */
    public function auth(object $payload): Principal
    {
        $user = $this->findUserByUserName($payload->username);
        return $this->getPrincipal($user);
    }

    /**
     * 获取用户凭证
     *
     * @param User $user
     * @return Principal
     */
    #[Pure]
    public function getPrincipal(User $user): Principal
    {
        $roles = [];
        $authorities = [];

        foreach ($user->getRoles() as $r) {
            $roles[] = $r->code;
            foreach ($r->authorities as $authority) {
                $authorities[] = $authority->code;
            }
        }

        $principal = new Principal();
        $principal->id = $user->id;
        $principal->username = $user->username;
        $principal->displayName = $user->display_name;
        $principal->name = $user->name;
        $principal->roles = $roles;
        $principal->authorities = $authorities;
        return $principal;
    }

    /**
     * 根据用户名查找用户
     *
     * @param string $username
     * @return User
     * @throws ServiceException
     */
    public function findUserByUserName(string $username): User
    {
        $user = $this->getRepository()->findByUsername($username);
        if ($user) {
            $this->getExtra($user);
        }
        return $user;
    }

    /**
     * 根据用户ID查找用户
     *
     * @param int $id
     * @return User
     * @throws ServiceException
     */
    public function findUserById(int $id): User
    {
        $user = $this->getRepository()->findById($id);
        $this->getExtra($user);
        return $user;
    }

    public function getExtra(User $user): void
    {
    }

}
