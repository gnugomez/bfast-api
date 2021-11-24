<?php

namespace App\User\Application\UseCases;

use App\User\Domain\Interfaces\UserRepositoryInterface;
use App\User\Domain\Exceptions\DomainException;
use App\User\Domain\Exceptions\InvalidEmailException;
use App\User\Domain\Exceptions\InvalidPasswordException;
use App\User\Domain\Exceptions\InvalidUsernameException;
use App\User\Domain\User;
use App\User\Domain\Objects\UserEmail;
use App\User\Domain\Objects\UserName;
use App\User\Domain\Objects\UserPassword;

class CreateUser
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws DomainException
     */
    public function __invoke(string $username, string $email, string $password): User|bool
    {
        $newUser = new User(null);
        $domainException = new DomainException();

        try {
            $newUser->username = new UserName($username);

            if ((new FindByUsername($this->repository))->__invoke($username)) {
                throw new InvalidUsernameException('username already taken');
            }
        } catch (InvalidUsernameException $e) {
            $domainException->addError('username', $e->getMessage());
        }
        try {
            $newUser->password = new UserPassword($password);
        } catch (InvalidPasswordException $e) {
            $domainException->addError('password', $e->getMessage());
        }
        try {
            $newUser->email = new UserEmail($email);

            if ((new FindByEmail($this->repository))->__invoke($email)) {
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
