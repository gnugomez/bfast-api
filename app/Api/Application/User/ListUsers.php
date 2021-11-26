<?php

namespace App\Api\Application\User;

use App\Api\Domain\Contracts\UserRepositoryContract;

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
