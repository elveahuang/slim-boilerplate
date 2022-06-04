<?php
declare(strict_types=1);

use App\Core\Libraries\Database\DatabaseManagerFactory;
use App\Core\Libraries\Sequence\SequenceManagerFactory;
use Slim\App;

return function (App $app) {
    // 序列化工厂
    SequenceManagerFactory::start($app->getContainer());
    // 数据库工厂
    DatabaseManagerFactory::start($app->getContainer());
};
