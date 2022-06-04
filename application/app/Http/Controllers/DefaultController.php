<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Constants;
use App\Core\Utils\DateTimeUtils;
use App\Core\Utils\WebUtils;
use App\Http\Controllers\Commons\AbstractController;
use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * 默认控制器
 */
class DefaultController extends AbstractController
{

    /**
     * 应用初始化
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function initialize(Request $request, Response $response, array $args): Response
    {
        $now = new DateTime();
        return WebUtils::success($response, [
            'version' => Constants::VERSION,
            'time' => DateTimeUtils::formatDateTime($now)
        ]);
    }

    public function home(Request $request, Response $response, array $args): Response
    {
        $now = new DateTime();
        return WebUtils::success($response, [
            'version' => Constants::VERSION,
            'time' => DateTimeUtils::formatDateTime($now)
        ]);
    }

    public function version(Request $request, Response $response, array $args): Response
    {
        $now = new DateTime();
        return WebUtils::success($response, [
            'version' => Constants::VERSION,
            'time' => DateTimeUtils::formatDateTime($now)
        ]);
    }

}
