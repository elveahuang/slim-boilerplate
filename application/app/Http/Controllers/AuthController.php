<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Exceptions\ExpiredRefreshTokenException;
use App\Core\Exceptions\ServiceException;
use App\Core\Utils\WebUtils;
use App\Http\Controllers\Commons\AbstractController;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * 认证授权控制器
 */
class AuthController extends AbstractController
{

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws ExpiredRefreshTokenException
     * @throws ServiceException
     */
    public function token(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParsedBody();
        if (isset($params['grant_type'])) {
            $grantType = $params['grant_type'];
            switch ($grantType) {
                case 'password':
                    // 密码模式
                    $credentials = [
                        'username' => $params['username'],
                        'password' => $params['password']
                    ];
                    return WebUtils::success($response, $this->getUserService()->login($credentials, $request));
                case 'refresh_token':
                    // 刷新模式
                    try {
                        $credentials = [
                            'refresh_token' => $params['refresh_token'],
                        ];
                        return WebUtils::success($response, $this->getUserService()->refresh($credentials));
                    } catch (Exception $e) {
                        $this->logger->error($e);
                        throw new ExpiredRefreshTokenException($request);
                    }
            }
        }
        return WebUtils::error($response);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws ServiceException
     * @throws Exception
     */
    public function logout(Request $request, Response $response, array $args): Response
    {
        $this->getUserService()->logout($request->getParsedBody());
        return WebUtils::success($response);
    }

}
