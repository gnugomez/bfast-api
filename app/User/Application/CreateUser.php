<?php

namespace App\User\Application;

use App\User\Domain\Contracts\UserRepositoryContract;
use App\User\Domain\Exceptions\DomainException;
use App\User\Domain\Exceptions\InvalidEmailException;
use App\User\Domain\Exceptions\InvalidPasswordException;
use App\User\Domain\Exceptions\InvalidUsernameException;
use App\User\Domain\User;
use App\User\Domain\ValueObjects\UserEmail;
use App\User\Domain\ValueObjects\UserName;
use App\User\Domain\ValueObjects\UserPassword;

class CreateUser
{
    private UserRepositoryContract $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws DomainException
     */
    public function __invoke(string $username = null, string $email = null, string $password = null): User | bool
    {
        $newUser = new User(null);
        $domainException = new DomainException();

        try {
            $newUser->username = new UserName($username);
        } catch (InvalidUsernameException $e) {
            $domainException->addError('username', $e->getMessage());
        }
        try {
            $newUser->setPassword(new UserPassword($password));
        } catch (InvalidPasswordException $e) {
            $domainException->addError('password', $e->getMessage());
        }
        try {
            $newUser->email = new UserEmail($email);

            if ($this->repository->findByEmail($email)) {
                throw new InvalidEmailException('already taken');
            }

        } catch (InvalidEmailException $e) {
            $domainException->addError('email', $e->getMessage());
        }

        if ($domainException->hasErrors()) {
            throw $domainException;
        }

        if ($this->repository->create($newUser)) {
            return $newUser;
        } else {
            return false;
        }
    }

}
