<?php

namespace App\User\Domain;

use App\User\Domain\Exceptions\DomainException;
use App\User\Domain\ValueObjects\UserEmail;
use App\User\Domain\ValueObjects\UserId;
use App\User\Domain\ValueObjects\UserName;
use App\User\Domain\ValueObjects\UserPassword;

class User
{

    public UserId $id;
    public UserName $username;
    public UserEmail $email;
    protected UserPassword $password;

    /**
     * @throws DomainException
     */
    public function __construct(?string $userId)
    {
        $this->id = new UserId($userId);
    }

    public function setPassword(UserPassword $param)
    {
        $this->password = $param;
    }

    public function getPassword(): UserPassword
    {
        return $this->password;
    }

}
