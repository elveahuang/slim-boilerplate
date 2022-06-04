<?php
declare(strict_types=1);

use App\Core\Settings\Settings;
use App\Core\Settings\SettingsInterface;
use DI\ContainerBuilder;

return function (ContainerBuilder $builder) {
    $builder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings(require __DIR__ . "/config.php");
        }
    ]);
};
