<?php
declare(strict_types=1);

namespace App\Core\Libraries\Database;

use App\Core\Settings\SettingsInterface;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class DatabaseManagerFactory
{

    /**
     * @param ContainerInterface $container
     * @return DatabaseManager
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function start(ContainerInterface $container): DatabaseManager
    {
        $settings = $container->get(SettingsInterface::class);
        $manager = new DatabaseManager;
        $manager->addConnection($settings->get('database'));
        $manager->getConnection()->enableQueryLog();
        $manager->setEventDispatcher(new Dispatcher(new Container()));
        $manager->setAsGlobal();
        $manager->bootEloquent();
        return $manager;
    }

}
