<?php

namespace App\Application\User;

use App\Domain\Contracts\UserRepositoryContract;

class ListUsers
{
    private UserRepositoryContract $userRepository;

    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke()
    {
        return $this->userRepository->all();
    }
}
