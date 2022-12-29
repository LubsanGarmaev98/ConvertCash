<?php

use App\Controller\ConsoleController;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Container\ContainerInterface;

require __DIR__ . '/../../vendor/autoload.php';
try {
    /** @var ContainerInterface $container */
    $container = require __DIR__ . '/../../config/bootstrap.php';
    /** @var ConsoleController $consoleController */
    $consoleController = $container->get(ConsoleController::class);
    $consoleController->refreshValutes();
}catch (GuzzleException $e)
{
    print_r($e->getMessage());
}