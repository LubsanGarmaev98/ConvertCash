<?php

namespace App\Controller;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use App\Service\ValClient;
use DateTime;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Repository\UserRepository;
use Slim\Views\PhpRenderer;

class CurrencyController extends WithAuthorizationController
{
    private CurrencyRepository $currencyRepository;

    private UserRepository $userRepository;

    private PhpRenderer $phpRenderer;


    public function __construct(CurrencyRepository $CurrencyRepository,
                                UserRepository $userRepository,
                                PhpRenderer $phpRenderer)
    {
        $this->currencyRepository   = $CurrencyRepository;
        $this->userRepository       = $userRepository;
        $this->phpRenderer          = $phpRenderer;
    }

    #Регистрация пользователя
    public function convert(Request $request, Response $response, array $args)
    {
        $user = $this->authorization($request);
        if(empty($user))
        {
            return $response
                ->withHeader('Location', 'http://localhost/signin')
                ->withStatus(302);
        }
        $result = null;
        if($request->getMethod() === "POST")
        {
            $params = $request->getParsedBody();
            $charCodeL = $params["charCodeL"];
            $charCodeR = $params["charCodeR"];
            $value     = $params["value"];

            $valuteL = $this->currencyRepository->findOneByCharCode($charCodeL);
            $valuteR = $this->currencyRepository->findOneByCharCode($charCodeR);

            $result = $value * ($valuteL->getValue() / $valuteR->getValue());
        }

        $valutes = $this->currencyRepository->findAll();

        return $this->phpRenderer->render($response, "convert.php", ['valutes' => $valutes, 'result' => $result]);
    }

    protected function getUserRepository(): UserRepository
    {
        return $this->userRepository;
    }
}