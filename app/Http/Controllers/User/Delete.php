<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User\Application\Exceptions\ApplicationException;
use App\User\Application\DeleteUser;
use App\User\Domain\Contracts\UserRepositoryContract;
use Laravel\Lumen\Http\Request;

class Delete extends Controller
{

    private UserRepositoryContract $repository;

    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function __invoke(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $deleteUser = new DeleteUser($this->repository);
        try {
            $deleteUser($id);
        } catch (ApplicationException $e) {
            return response()->json(["error" => $e->errors()], 404);
        }
        return response()->json(["success" => "User $id deleted."]);
    }

}
