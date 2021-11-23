<?php

namespace App\User\Application;

use App\Models\User;
use App\User\Domain\Contracts\UserRepositoryContract;

class FindByUserName
{
    private UserRepositoryContract $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $userName)
    {
        return $this->repository->where('username', "=", $userName)->first();
    }

}
