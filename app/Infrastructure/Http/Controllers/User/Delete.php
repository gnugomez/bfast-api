<?php

namespace App\Infrastructure\Http\Controllers\User;

use App\Infrastructure\Http\Controllers\Controller;
use App\Application\Exceptions\ApplicationException;
use App\Application\User\DeleteUser;
use App\Domain\Contracts\UserRepositoryContract;
use Laravel\Lumen\Http\Request;

/**
 * @OA\Delete (
 *     path="/users/{id}",
 *     summary="Delete user",
 *     tags={"users"},
 *     @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="User deleted"
 *     )
 * )
 */
final class Delete extends Controller
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
