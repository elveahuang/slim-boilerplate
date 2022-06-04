<?php
declare(strict_types=1);

use App\Core\Libraries\Sequence\SequenceInterface;
use App\Core\Libraries\Sequence\SequenceManagerFactory;
use App\Core\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\PsrLogMessageProcessor;
use Monolog\Processor\UidProcessor;
use Monolog\Processor\WebProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Translation\Loader\JsonFileLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

return function (ContainerBuilder $builder) {
    $builder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $container) {
            $settings = $container->get(SettingsInterface::class);
            $loggerSettings = $settings->get('logger');

            $logger = new Logger($loggerSettings['name']);
            $logger->pushProcessor(new UidProcessor());
            $logger->pushProcessor(new WebProcessor());
            $logger->pushProcessor(new IntrospectionProcessor());
            $logger->pushProcessor(new PsrLogMessageProcessor());
            $logger->pushHandler(new StreamHandler($loggerSettings['path'], $loggerSettings['level']));
            $logger->pushHandler(new FirePHPHandler());
            return $logger;
        },
        Translator::class => function (ContainerInterface $container) {
            $settings = $container->get(SettingsInterface::class);
            $i18nSettings = $settings->get('i18n');
            $translator = new Translator($i18nSettings['locale']);
            if (isset($i18nSettings['resources'])) {
                $translator->addLoader('json', new JsonFileLoader());
                $resources = $i18nSettings['resources'];
                foreach ($resources as $local => $file) {
                    $translator->addResource('json', $file, $local);
                }
            }
            return $translator;
        },
        SequenceInterface::class => function (ContainerInterface $container) {
            return SequenceManagerFactory::getInstance();
        },
        ValidatorInterface::class => function (ContainerInterface $container) {
            return Validation::createValidator();
        },
    ]);
};
