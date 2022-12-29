<?php
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: UserRepository::class), Table(name: 'users')]
class User{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    protected int $id;
    #[Column(type: 'string', unique: true, nullable: false)]
    protected string $login;
    #[Column(type: 'string', nullable: false)]
    protected string $password;
    #[Column(type: 'string', unique: true, nullable: false)]
    protected ?string $token;

    public function __construct(
        string $login,
        string $password,
        string $token = null,
        )
    {
        $this->login            = $login;
        $this->password         = $password;
        $this->token            = $token;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }
}