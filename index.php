<?php
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Selective\BasePath\BasePathMiddleware;

require_once __DIR__ . '/vendor/autoload.php';

$definitionsContainer = [
    'settings' => function () {
        return require __DIR__ . '/config/settings.php';
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },

    BasePathMiddleware::class => function (ContainerInterface $container) {
        return new BasePathMiddleware($container->get(App::class));
    },
];

$containerBuilder = new ContainerBuilder();

// Set up settings
$containerBuilder->addDefinitions($definitionsContainer);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Create App instance
$app = $container->get(App::class);

//Rotas
(require __DIR__ . '/config/routes.php')($app);

//Middleware
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->add(BasePathMiddleware::class);
$app->add(ErrorMiddleware::class);

$app->run();
