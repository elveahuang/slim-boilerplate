<?php
declare(strict_types=1);

namespace App\Core\Exceptions;

use Slim\Exception\HttpSpecializedException;

class ExpiredRefreshTokenException extends HttpSpecializedException
{
    /**
     * @var string
     */
    protected $code = 401;
    /**
     * @var string
     */
    protected $message = 'Expired Refresh Token.';
    /**
     * @var string
     */
    protected $title = 'Expired Refresh Token';
    /**
     * @var string
     */
    protected $description = 'Expired Refresh Token.';
}
