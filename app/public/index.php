<?php

use App\Controller\CurrencyController;
use App\Controller\UserController;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;
use UMA\DIC\Container;

require __DIR__ . '/../vendor/autoload.php';

/** @var Container $container */
$container = require __DIR__ . '/../config/bootstrap.php';

AppFactory::setContainer($container);
$app = AppFactory::create();

$routes = require __DIR__ . '/../config/routes.php';
$routes($app);

$app->run();

