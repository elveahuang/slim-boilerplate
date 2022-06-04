<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\Core\Context;
use App\Core\Utils\Utils;
use App\Services\UserService;
use Psr\Container\ContainerInterface as Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Log\LoggerInterface as Logger;

abstract class AbstractMiddleware implements Middleware
{

    /**
     * @var Container
     */
    protected Container $container;

    /**
     * @var Logger
     */
    protected Logger $logger;

    /**
     * @var UserService
     */
    protected UserService $userService;

    /**
     * @param Container $container
     * @param Logger $logger
     * @param UserService $userService
     */
    public function __construct(Container $container, Logger $logger, UserService $userService)
    {
        $this->container = $container;
        $this->logger = $logger;
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @param RequestHandler $handler
     * @return Response
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $locale = $request->getHeaderLine('locale');
        $context = new Context();
        $context->locale = Utils::getLangType($locale);
        $request = $request->withAttribute("context", $context);
        return $handler->handle($request);
    }

}
