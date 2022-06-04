<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\Core\Exceptions\ExpiredAccessTokenException;
use App\Core\Exceptions\ServiceException;
use App\Core\Utils\JwtUtils;
use Exception;
use Firebase\JWT\ExpiredException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuthorizationMiddleware extends AbstractMiddleware
{

    /**
     * @param Request $request
     * @param RequestHandler $handler
     * @return Response
     * @throws ExpiredAccessTokenException
     * @throws ServiceException
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        if ($request->hasHeader('Authorization')) {
            $authorization = $request->getHeaderLine('Authorization');;
            try {
                $payload = JwtUtils::parseAccessToken(substr($authorization, 7));
                $user = $this->userService->auth($payload);
                $request = $request->withAttribute("user", $user);
            } catch (ExpiredException $e) {
                $this->logger->error($e);
                throw new ExpiredAccessTokenException($request);
            } catch (Exception $e) {
                $this->logger->error($e);
                throw new ServiceException('');
            }
        }
        return $handler->handle($request);
    }

}
