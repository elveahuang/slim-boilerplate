<?php
declare(strict_types=1);

namespace App\Core\Exceptions;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpSpecializedException;
use Throwable;

/**
 * 参数验证异常
 */
class ValidationException extends HttpSpecializedException
{
    /**
     * @var string
     */
    protected $code = 200;

    /**
     * @var string|array|null|object
     */
    protected string|array|null|object $error;

    /**
     * @param ServerRequestInterface $request
     * @param array|null $errors
     * @param string|null $message
     * @param Throwable|null $previous
     */
    public function __construct(
        ServerRequestInterface $request,
        ?array                 $errors = null,
        ?string                $message = null,
        ?Throwable             $previous = null)
    {
        if (!is_null($errors) && count($errors) > 0) {
            $this->error = $errors;
        }
        if ($message == null) {
            $this->message = 'Validation Exception.';
        }
        parent::__construct($request, $this->message, $previous);
    }

    /**
     * @return  string|array|null|object
     */
    public function getError(): string|array|null|object
    {
        return $this->error;
    }

}
