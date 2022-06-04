<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Exceptions\ServiceException;
use App\Core\Exceptions\ValidationException;
use App\Core\Utils\WebUtils;
use App\Http\Controllers\Commons\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;

/**
 * 用户控制器
 */
class UserController extends AbstractController
{

    /**
     * 获取当前登录用户信息
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function user(Request $request, Response $response, array $args): Response
    {
        return WebUtils::success($response, WebUtils::getCurrentUser($request));
    }

    /**
     * 修改个人信息
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function account(Request $request, Response $response, array $args): Response
    {
        return WebUtils::success($response, WebUtils::getCurrentUser($request));
    }

    /**
     * 用户注册
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws ServiceException
     * @throws ValidationException
     */
    public function register(Request $request, Response $response, array $args): Response
    {
        $em = $this->getEntityManager();
        $params = $request->getParsedBody();
        $this->validate($request,
            [
                'username' => array_key_exists('username', $params) ? $params['username'] : '',
                'email' => array_key_exists('email', $params) ? $params['email'] : '',
                'password' => array_key_exists('password', $params) ? $params['password'] : '',
            ],
            new Collection([
                'username' => new Required([
                    new NotBlank([
                        'message' => 'validation_not_blank',
                    ]),
                    new Length(['min' => 5, 'max' => 100]),
                ]),
                'email' => [],
                'password' => [],
            ])
        );
        return WebUtils::success($response, $this->getUserService()->register($params));
    }

    /**
     * 忘记密码
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function forgotPassword(Request $request, Response $response, array $args): Response
    {
        return WebUtils::success($response, WebUtils::getCurrentUser($request));
    }

    /**
     * 用户重置密码
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function resetPassword(Request $request, Response $response, array $args): Response
    {
        return WebUtils::success($response, WebUtils::getCurrentUser($request));
    }

}
