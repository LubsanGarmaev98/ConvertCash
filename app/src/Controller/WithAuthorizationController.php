<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Slim\Psr7\Request;

abstract class WithAuthorizationController
{
    abstract protected function getUserRepository(): UserRepository;
    protected function authorization(Request $request): ?User
    {
        $params = $request->getCookieParams();
        if(isset($params["Token"]))
        {
            return $this->getUserRepository()->findOneByToken($params["Token"]);
        }
        return null;
    }
}