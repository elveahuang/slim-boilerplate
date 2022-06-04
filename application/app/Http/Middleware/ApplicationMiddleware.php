<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\Core\Context;
use App\Core\Utils\Utils;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class ApplicationMiddleware extends AbstractMiddleware
{

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
