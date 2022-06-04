<?php
declare(strict_types=1);

use App\Application;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

require __DIR__ . '/../vendor/autoload.php';

$application = new Application();

try {
    $application->start();
} catch (Exception|NotFoundExceptionInterface|ContainerExceptionInterface $e) {
}
