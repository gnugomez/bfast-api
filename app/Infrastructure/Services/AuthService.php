<?php

namespace App\Infrastructure\Services;


class AuthService implements AuthServiceContract
{
    /**
     * @var \App\Infrastructure\Persistence\Eloquent\Repositories\UserRepository
     */
    private $userRepository;

    /**
     * @param \App\Infrastructure\Persistence\Eloquent\Repositories\UserRepository $userRepository
     */
    public function __construct(
        \App\Infrastructure\Persistence\Eloquent\Repositories\UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $email
     * @param string $password
     * @return \App\Domain\User\Entities\Models\User
     */
    public function authenticate(string $email, string $password): \App\Domain\User\Entities\Models\User
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            throw new \App\Domain\Exceptions\User\UserNotFoundException();
        }

        if (!$user->isPasswordValid($password)) {
            throw new \App\Domain\Exceptions\User\InvalidPasswordException();
        }

        return $user;
    }
}

{

}
