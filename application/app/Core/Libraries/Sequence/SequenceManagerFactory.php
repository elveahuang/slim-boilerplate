<?php
declare(strict_types=1);

namespace App\Core\Libraries\Sequence;

use App\Core\Settings\SettingsInterface;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class SequenceManagerFactory
{

    /**
     * 当前实例
     *
     * @var SequenceInterface
     */
    private static SequenceInterface $instance;

    /**
     * @return SequenceInterface
     */
    public static function getInstance(): SequenceInterface
    {
        return self::$instance;
    }

    /**
     * @param SequenceInterface $instance
     */
    public static function setInstance(SequenceInterface $instance): void
    {
        self::$instance = $instance;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public static function start(ContainerInterface $container): void
    {
        $settings = $container->get(SettingsInterface::class);
        $idSettings = $settings->get('id');
        self::$instance = new Snowflake($idSettings['workerId'], $idSettings['datacenterId']);
    }

}