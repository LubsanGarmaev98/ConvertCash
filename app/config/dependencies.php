<?php

use App\Controller\ConsoleController;
use App\Controller\CurrencyController;
use App\Controller\UserController;
use App\Entity\Currency;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\ValClient;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Slim\Views\PhpRenderer;
use UMA\DIC\Container;

return [
    'logger' => function () {
        $logger = new Logger('my_logger');
        $file_handle = new Monolog\Handler\StreamHandler('../logs/app.log');
        $logger->pushHandler($file_handle);
        return $logger;
    },

    'db' => function (Container $c) {
        $db = $c->get('settings')['db'];
        $dsn = "pgsql:host={$db['host']};port=5432;dbname={$db['name']};";
        // make a database connection
        $pdo = new PDO(
            $dsn,
            $db['user'],
            $db['password']
        );

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    },

    UserController::class => function (ContainerInterface $container) {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);

        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(User::class);

        $phpRenderer = $container->get(PhpRenderer::class);

        return new UserController($phpRenderer, $userRepository);
    },

    CurrencyController::class => function (ContainerInterface $container) {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);

        /** @var CurrencyController $userRepository */
        $currencyRepository = $entityManager->getRepository(Currency::class);

        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(User::class);

        $phpRenderer = $container->get(PhpRenderer::class);

        return new CurrencyController($currencyRepository, $userRepository, $phpRenderer);
    },

    ValClient::class => function(){
        return new ValClient();
    },

    PhpRenderer::class => function(){
        return new PhpRenderer(dirname(__DIR__) . '/src/View');
    },

    ConsoleController::class => function(ContainerInterface $container){

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);

        /** @var CurrencyController $userRepository */
        $currencyRepository = $entityManager->getRepository(Currency::class);

        $valClient = $container->get(ValClient::class);

        return new ConsoleController($currencyRepository, $valClient);
    }
];