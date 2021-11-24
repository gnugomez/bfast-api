<?php

namespace App\User\Application\UseCases;

use App\Models\User;
use App\User\Domain\Interfaces\UserRepositoryInterface;

class FindByEmail
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $email)
    {
        return $this->repository->where('email', "=", $email)->first();
    }

}
