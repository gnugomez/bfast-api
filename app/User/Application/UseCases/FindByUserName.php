<?php

namespace App\User\Application\UseCases;

use App\Models\User;
use App\User\Domain\Interfaces\UserRepositoryInterface;

class FindByUserName
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $userName)
    {
        return $this->repository->where('username', "=", $userName)->first();
    }

}
