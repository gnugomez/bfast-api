<?php

namespace App\User\Application\UseCases;

use App\User\Domain\Interfaces\UserRepositoryInterface;

class ListUsers
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke()
    {
        return $this->userRepository->all();
    }
}
