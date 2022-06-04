<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Utils\WebUtils;
use App\Http\Controllers\Commons\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * AdminController
 */
class AdminController extends AbstractController
{

    public function dashboard(Request $request, Response $response, array $args): Response
    {
        return WebUtils::success($response, WebUtils::getCurrentUser($request));
    }

}
