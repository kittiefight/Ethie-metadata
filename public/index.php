<?php
require __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use \Slim\Factory\AppFactory;
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;

$settings = require __DIR__ . '/../app/settings.php';

$logger = new Logger('app');
$logger->pushHandler(new StreamHandler($settings['logger']['file'], $settings['logger']['level']));

$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(
    $settings['errorHandler']['displayErrorDetails'], 
    $settings['errorHandler']['logErrors'], 
    $settings['errorHandler']['logErrorDetails'], 
    $logger
);

// Register services
require __DIR__ . '/../app/services.php';

// Register routes
require __DIR__ . '/../app/routes.php';


$app->run();


