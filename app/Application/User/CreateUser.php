<?php

namespace App\Application\User;

use App\Domain\Contracts\UserRepositoryContract;
use App\Domain\Entities\User\User;
use App\Domain\Entities\User\UserEmail;
use App\Domain\Entities\User\UserName;
use App\Domain\Entities\User\UserPassword;
use App\Domain\Entities\User\UserSurname;
use App\Domain\Exceptions\User\DomainException;
use App\Domain\Exceptions\User\InvalidEmailException;
use App\Domain\Exceptions\User\InvalidNameException;
use App\Domain\Exceptions\User\InvalidPasswordException;
use App\Domain\Exceptions\User\InvalidSurnameException;

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
    public function __invoke(?string $email, ?string $password, ?string $name, ?string $surname): User|bool
    {
        $newUser = new User(null);
        $domainException = new DomainException();

        try {
            $newUser->name = new UserName($name);
        } catch (InvalidNameException $e) {
            $domainException->addError('username', $e->getMessage());
        }
        try {
            $newUser->surname = new UserSurname($surname);
        } catch (InvalidSurnameException $e) {
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
