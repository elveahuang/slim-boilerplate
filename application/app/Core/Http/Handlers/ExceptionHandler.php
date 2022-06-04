<?php
declare(strict_types=1);

namespace App\Core\Http\Handlers;

use App\Core\Exceptions\ExpiredAccessTokenException;
use App\Core\Exceptions\ExpiredRefreshTokenException;
use App\Core\Exceptions\ValidationException;
use App\Core\Http\Result;
use App\Core\Utils\WebUtils;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpNotImplementedException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;
use Throwable;

/**
 * 异常处理器
 */
class ExceptionHandler extends SlimErrorHandler
{

    public const BAD_REQUEST = 'BAD_REQUEST';
    public const INSUFFICIENT_PRIVILEGES = 'INSUFFICIENT_PRIVILEGES';
    public const NOT_ALLOWED = 'NOT_ALLOWED';
    public const NOT_IMPLEMENTED = 'NOT_IMPLEMENTED';
    public const RESOURCE_NOT_FOUND = 'RESOURCE_NOT_FOUND';
    public const SERVER_ERROR = 'SERVER_ERROR';
    public const UNAUTHENTICATED = 'UNAUTHENTICATED';
    public const VALIDATION_ERROR = 'VALIDATION_ERROR';
    public const VERIFICATION_ERROR = 'VERIFICATION_ERROR';
    public const EXPIRED_ACCESS_TOKEN = 'EXPIRED_ACCESS_TOKEN';
    public const EXPIRED_REFRESH_TOKEN = 'EXPIRED_REFRESH_TOKEN';

    protected function respond(): Response
    {
        $status = 200;
        $message = 'Error';
        $type = '';
        $exception = $this->exception;
        if ($exception instanceof HttpException) {
            $status = $exception->getCode();
            $message = $exception->getMessage();
            if ($exception instanceof HttpNotFoundException) {
                $type = self::RESOURCE_NOT_FOUND;
            } elseif ($exception instanceof HttpMethodNotAllowedException) {
                $type = self::NOT_ALLOWED;
            } elseif ($exception instanceof HttpUnauthorizedException) {
                $type = self::UNAUTHENTICATED;
            } elseif ($exception instanceof HttpForbiddenException) {
                $type = self::INSUFFICIENT_PRIVILEGES;
            } elseif ($exception instanceof HttpBadRequestException) {
                $type = self::BAD_REQUEST;
            } elseif ($exception instanceof HttpNotImplementedException) {
                $type = self::NOT_IMPLEMENTED;
            } elseif ($exception instanceof ExpiredAccessTokenException) {
                $type = self::EXPIRED_ACCESS_TOKEN;
            } elseif ($exception instanceof ExpiredRefreshTokenException) {
                $type = self::EXPIRED_REFRESH_TOKEN;
            } elseif ($exception instanceof ValidationException) {
                $type = self::VALIDATION_ERROR;
            }
        }

        if (
            !($exception instanceof HttpException)
            && $exception instanceof Throwable
            && $this->displayErrorDetails
        ) {
            $message = $exception->getMessage();
        }

        $data = [];
        if ($exception instanceof ValidationException) {
            $data = $exception->getError();
        }

        $result = new Result(Result::$CODE_ERROR, $data, $message);
        $response = $this->responseFactory->createResponse();
        return WebUtils::render($response, $result, $status);
    }

}
