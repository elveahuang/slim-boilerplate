<?php
declare(strict_types=1);

namespace App\Core\Utils;

use App\Core\Http\Result;
use App\Core\Types\Paginator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * WebUtils
 */
class WebUtils
{

    /**
     * 获取分页请求参数
     *
     * @param Request $request
     * @return Paginator
     */
    public static function getPaginator(Request $request): Paginator
    {
        $pageRequest = new Paginator();
        $params = $request->getParsedBody();
        if (isset($params['page'])) {
            $pageRequest->page = (int)$params['page'];
        }
        if (isset($params['limit'])) {
            $pageRequest->limit = (int)$params['limit'];
        }
        $pageRequest->params = $params;
        return $pageRequest;
    }

    /**
     * 是否是异步请求
     *
     * @param Request $request
     * @return bool
     */
    public static function isAjaxRequest(Request $request): bool
    {
        return $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest';
    }

    /**
     * 获取当前请求内容类型
     *
     * @param Request $request
     * @return string
     */
    public static function getContentType(Request $request): string
    {
        return $request->getHeaderLine('Content-Type');
    }

    /**
     * 获取当前请求内容长度
     *
     * @param Request $request
     * @return string
     */
    public static function getContentLength(Request $request): string
    {
        return $request->getHeaderLine('Content-Length');
    }

    /**
     * 获取当前用户
     *
     * @param Request $request
     * @return object|null
     */
    public static function getCurrentUser(Request $request): object|null
    {
        return $request->getAttribute("user");
    }

    /**
     * 渲染响应结果
     *
     * @param Response $response
     * @param array|string|object $data
     * @param int $status
     * @return Response
     */
    public static function render(Response $response, array|string|object $data, int $status = 200): Response
    {
        $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }

    /**
     * 渲染响应成功结果
     *
     * @param Response $response
     * @param array|string|object $data
     * @param int $status
     * @return Response
     */
    public static function success(Response $response, array|string|object $data = [], int $status = 200): Response
    {
        $result = new Result(Result::$CODE_SUCCESS, $data);
        return self::render($response, $result, $status);
    }

    /**
     * 渲染响应错误结果
     *
     * @param Response $response
     * @param array|string|object $data
     * @param int $status
     * @return Response
     */
    public static function error(Response $response, array|string|object $data = [], int $status = 200): Response
    {
        $result = new Result(Result::$CODE_ERROR, $data, 'ERROR');
        return self::render($response, $result, $status);
    }

}
