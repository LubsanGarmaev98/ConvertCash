<?php

use App\Controller\ConsoleController;
use App\Controller\CurrencyController;
use App\Controller\UserController;
use Slim\App;
use Slim\Views\PhpRenderer;

return function (App $app) {

    $app->get('/signup', [UserController::class, "signUp"]);
    $app->post('/signup', [UserController::class, "signUp"]);

    $app->get('/signin', [UserController::class, "signIn"]);
    $app->post('/signin', [UserController::class, "signIn"]);

    $app->get('/convert', [CurrencyController::class, "convert"]);
    $app->post('/convert', [CurrencyController::class, "convert"]);

    $app->get('/signout', [UserController::class, "signOut"]);

    $app->get('/refresh', [ConsoleController::class, "refreshValutes"]);

    $app->get('/signup/style', function ($request, $response, $args)
    {
        $renderer = new PhpRenderer(__DIR__ . '/style');
        return $renderer->render($response, "sign.css", $args);
    });

};