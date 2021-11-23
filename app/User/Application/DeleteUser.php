<?php

namespace App\User\Application;

use App\User\Application\Exceptions\ApplicationException;
use App\User\Domain\Contracts\UserRepositoryContract;

class DeleteUser
{
    private UserRepositoryContract $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws ApplicationException
     */
    public function __invoke(int $id): void
    {
        if (!$this->repository->find($id)) {
            throw new ApplicationException(['User not found']);
        }
        $this->repository->delete($id);
    }

}
