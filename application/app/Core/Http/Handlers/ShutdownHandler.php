<?php
declare(strict_types=1);

namespace App\Core\Http\Handlers;

use App\Core\Http\ResponseEmitter\ResponseEmitter;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpInternalServerErrorException;

class ShutdownHandler
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var ExceptionHandler
     */
    private ExceptionHandler $handler;

    /**
     * @var bool
     */
    private bool $displayErrorDetails;

    /**
     * ShutdownHandler constructor.
     *
     * @param Request $request
     * @param ExceptionHandler $handler
     * @param bool $displayErrorDetails
     */
    public function __construct(Request $request, ExceptionHandler $handler, bool $displayErrorDetails)
    {
        $this->request = $request;
        $this->handler = $handler;
        $this->displayErrorDetails = $displayErrorDetails;
    }

    public function __invoke()
    {
        $error = error_get_last();
        if ($error) {
            $errorFile = $error['file'];
            $errorLine = $error['line'];
            $errorMessage = $error['message'];
            $errorType = $error['type'];
            $message = 'An error while processing your request. Please try again later.';

            if ($this->displayErrorDetails) {
                switch ($errorType) {
                    case E_USER_ERROR:
                        $message = "FATAL ERROR: {$errorMessage}. ";
                        $message .= " on line {$errorLine} in file {$errorFile}.";
                        break;

                    case E_USER_WARNING:
                        $message = "WARNING: {$errorMessage}";
                        break;

                    case E_USER_NOTICE:
                        $message = "NOTICE: {$errorMessage}";
                        break;

                    default:
                        $message = "ERROR: {$errorMessage}";
                        $message .= " on line {$errorLine} in file {$errorFile}.";
                        break;
                }
            }

            $exception = new HttpInternalServerErrorException($this->request, $message);
            $response = $this->handler->__invoke($this->request, $exception, $this->displayErrorDetails, false, false);
            $responseEmitter = new ResponseEmitter();
            $responseEmitter->emit($response);
        }
    }
}
