<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\Core\Exceptions\AccessDeniedException;
use App\Core\Settings\SettingsInterface;
use App\Core\Types\Principal;
use App\Core\Utils\WebUtils;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;

class AuthenticationMiddleware extends AbstractMiddleware
{

    /**
     * @param Request $request
     * @param RequestHandler $handler
     * @return Response
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws AccessDeniedException
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        /**
         * 用户信息
         * @var Principal $user
         */
        $user = WebUtils::getCurrentUser($request);

        /**
         * 获取访问控制配置
         * @var SettingsInterface $settings
         */
        $settings = $this->container->get(SettingsInterface::class);
        $rbac = $settings->get('rbac');

        /**
         * 获取路由信息
         */
        $route = RouteContext::fromRequest($request)->getRoute();

        /**
         * 权限检查
         */
        $pass = true;
        if (isset($rbac['resources']) && isset($rbac['resources'][$route->getPattern()])) {
            $acl = $rbac['resources'][$route->getPattern()];

            // 当前路由是否要求用户已经登录
            if (isset($acl['authenticated']) && $acl['authenticated'] == true) {
                $pass = $this->isAuthenticated($request, $user);
            }

            // 当前路由是否要求用户拥有指定的任意角色
            if (isset($acl['roles']) && is_array($acl['roles']) && count($acl['roles']) > 0) {
                $roles = [];
                if ($this->isAuthenticated($request, $user)) {
                    $roles = array_intersect(
                        array_map('strtolower', $user->roles),
                        array_map('strtolower', $acl['roles'])
                    );
                }
                $pass = count($roles) > 0;
            }

            // 当前路由是否要求用户拥有指定的任意权限
            if (isset($acl['authorities']) && is_array($acl['authorities']) && count($acl['authorities']) > 0) {
                $authorities = [];
                if ($this->isAuthenticated($request, $user)) {
                    $authorities = array_intersect(
                        array_map('strtolower', $user->authorities),
                        array_map('strtolower', $acl['authorities'])
                    );
                }
                $pass = count($authorities) > 0;
            }
        }
        $context = [
            'pattern' => $route->getPattern(),
            'name' => $route->getName(),
            'pass' => $pass
        ];
        $this->logger->info('route name - [{name}]. pattern - [{pattern}] - pass [{pass}]', $context);

        if ($pass) {
            return $handler->handle($request);
        }
        throw new AccessDeniedException($request);
    }

    /**
     * 检查当前是否已经登录
     * @param Request $request
     * @param Principal|null $user
     * @return bool
     */
    private function isAuthenticated(Request $request, ?Principal $user): bool
    {
        return ($user != null || WebUtils::getCurrentUser($request) != null);
    }

}
