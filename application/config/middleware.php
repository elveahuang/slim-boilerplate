<?php
declare(strict_types=1);

use App\Http\Middleware\ApplicationMiddleware;
use Slim\App;
use Slim\Middleware\ContentLengthMiddleware;

return function (App $app) {
    $app->add(ApplicationMiddleware::class);
    $app->add(ContentLengthMiddleware::class);
};
