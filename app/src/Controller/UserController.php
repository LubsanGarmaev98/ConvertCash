<?php
namespace App\Controller;

use Ramsey\Uuid\Uuid;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Controller\WithAuthorizationController;
use Slim\Views\PhpRenderer;

class UserController extends WithAuthorizationController
{
    private UserRepository $userRepository;
    private PhpRenderer $phpRenderer;

    public function __construct(PhpRenderer $phpRenderer, UserRepository $userRepository)
    {
        $this->phpRenderer      = $phpRenderer;
        $this->userRepository   = $userRepository;
    }

    //Регистрация пользователя
    public function signUp (Request $request, Response $response, array $args)
    {
        if($request->getMethod() === "POST")
        {
            $params = $request->getParsedBody();
            $errors = $this->validateSign($params);

            if (!empty($errors))
            {
                $args = ['error' => $errors];
                return $this->phpRenderer->render($response, "signup.php", $args);
            }

            $token = Uuid::uuid4()->toString();
            $user = new User
            (
                $params['login'],
                password_hash($params['password'], PASSWORD_DEFAULT),
                $token
            );

            $this->userRepository->add($user, true);

            setcookie("Token", $user->getToken());

            return $response
                ->withHeader('Location', 'http://localhost/convert')
                ->withStatus(302);
        }

        return $this->phpRenderer->render($response, "signup.php", $args);
    }
    #Проверка на валидацию
    private function validateSign(array $params): array
    {
        $messages = [];

        $emailError = $this->validateLogin($params);
        if(!empty($emailError))
        {
            $messages['login']  = $emailError;
        }

        $passwordError = $this->validatePassword($params);
        if(!empty($passwordError))
        {
            $messages['password']  = $passwordError;
        }

        return $messages;
    }

    private function validateLogin(array $params): ?string
    {
        $message = null;

        if(empty($params['login']))
        {
            $message = "Login not be empty or null!";
        } else
        {
            if(!filter_var($params['login'], FILTER_VALIDATE_EMAIL))
            {
                $message = "The email address specified is not correct";
            }
        }
        return $message;
    }

    private function validatePassword(array $params): ?string
    {
        $message = null;
        if(empty($params['password']))
        {
            $message = 'Password not be empty';
        }

        return $message;
    }

    #Вход в систему, в свой аккаунт
    public function signIn (Request $request, Response $response, array $args)
    {
        if($request->getMethod() === "POST")
        {
            //создать пользователя, cookie использовать вместо токена

            $params['login'] = $_POST["login"];
            $params['password'] = $_POST["password"];

            $errors = $this->validateSign($params);
            if (!empty($errors))
            {
                return $this->phpRenderer->render($response, "error.php", $errors);
            }
            $user = $this->userRepository->findOneByLogin($params['login']);
            if($user instanceof User)
            {
                $result = password_verify($params['password'], $user->getPassword());
                if($result)
                {
                    setcookie("Token", $user->getToken());
                    return $response
                        ->withStatus(302)
                        ->withHeader('Location', 'http://localhost/convert');
                }
                else {
                    return $this->phpRenderer->render($response, "error.php", $errors);
                }
            }
        }
        return $this->phpRenderer->render($response, "signin.php", $args);
    }

    //Выход из профиля
    public function signOut(Request $request, Response $response)
    {
        setcookie("Token", "", time()-3600);
       return $response
            ->withHeader('Location', 'http://localhost/signin')
            ->withStatus(302);
    }

    protected function getUserRepository(): UserRepository
    {
        return $this->userRepository;
    }
}