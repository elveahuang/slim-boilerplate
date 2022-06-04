<?php
declare(strict_types=1);

namespace App\Core\Exceptions;

use Slim\Exception\HttpSpecializedException;

class AccessDeniedException extends HttpSpecializedException
{

    /**
     * @var string
     */
    protected $code = 403;
    /**
     * @var string
     */
    protected $message = 'AccessDeniedException.';
    /**
     * @var string
     */
    protected $title = 'AccessDeniedException';
    /**
     * @var string
     */
    protected $description = 'AccessDeniedException.';

}
