<?php
declare(strict_types=1);

namespace App\Core\Exceptions;

use Slim\Exception\HttpSpecializedException;

class ExpiredAccessTokenException extends HttpSpecializedException
{
    /**
     * @var string
     */
    protected $code = 401;
    /**
     * @var string
     */
    protected $message = 'Expired Access Token.';
    /**
     * @var string
     */
    protected $title = 'Expired Access Token';
    /**
     * @var string
     */
    protected $description = 'Expired Access Token.';
}
