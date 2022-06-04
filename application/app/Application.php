<?php
declare(strict_types=1);

namespace App;

use App\Core\Http\Handlers\ExceptionHandler;
use App\Core\Http\Handlers\ShutdownHandler;
use App\Core\Http\ResponseEmitter\ResponseEmitter;
use App\Core\Settings\SettingsInterface;
use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface as Container;
use Psr\Container\NotFoundExceptionInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

class Application
{

    /**
     *
     * @var Container
     */
    public Container $container;

    /**
     *
     * @var App
     */
    public App $app;

    /**
     * Bootstrap constructor.
     * @throws Exception
     */
    public function __construct()
    {
        // Instantiate PHP-DI ContainerBuilder
        $builder = new ContainerBuilder();

        // Set up settings
        $settings = require __DIR__ . '/../config/settings.php';
        $settings($builder);

        // Set up dependencies
        $dependencies = require __DIR__ . '/../config/dependencies.php';
        $dependencies($builder);

        // Set up services
        $services = require __DIR__ . '/../config/services.php';
        $services($builder);

        // Create PHP-DI Container instance
        $this->container = $builder->build();

        // Instantiate the app
        AppFactory::setContainer($this->container);
        $this->app = AppFactory::create();

        // Setup Database
        $database = require __DIR__ . '/../config/database.php';
        $database($this->app);

        // Register Middleware
        $middleware = require __DIR__ . '/../config/middleware.php';
        $middleware($this->app);

        // Register Routes
        $routes = require __DIR__ . '/../config/routes.php';
        $routes($this->app);
    }

    /**
     * 应用初始化
     * @return void
     * @throws ContainerExceptionInterface
     * @throws DependencyException
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function initialize(): void
    {
        /**
         * @var SettingsInterface $settings
         */
        $settings = $this->container->get(SettingsInterface::class);

        // 设置时区
        try {
            ini_set('date.timezone', $settings['timezone']);
        } catch (Exception $e) {
        }
    }

    /**
     * Bootstrap constructor.
     * @throws Exception
     * @throws DependencyException
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function start(): void
    {
        /**
         * @var SettingsInterface $settings
         */
        $settings = $this->container->get(SettingsInterface::class);

        $displayErrorDetails = $settings->get('displayErrorDetails');
        $logError = $settings->get('logError');
        $logErrorDetails = $settings->get('logErrorDetails');

        $request = ServerRequestCreatorFactory::create()->createServerRequestFromGlobals();

        // Create Error Handler
        $responseFactory = $this->app->getResponseFactory();
        $errorHandler = new ExceptionHandler($this->app->getCallableResolver(), $responseFactory);

        // Create Shutdown Handler
        $shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
        register_shutdown_function($shutdownHandler);

        // Add Official Middleware
        $this->app->addRoutingMiddleware();
        $this->app->addBodyParsingMiddleware();

        // Add Error Middleware
        $errorMiddleware = $this->app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        // Run App & Emit Response
        $response = $this->app->handle($request);
        $responseEmitter = new ResponseEmitter();
        $responseEmitter->emit($response);
    }

}
