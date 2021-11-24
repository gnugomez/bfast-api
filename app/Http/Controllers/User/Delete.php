<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User\Application\Exceptions\ApplicationException;
use App\User\Application\UseCases\DeleteUser;
use App\User\Domain\Interfaces\UserRepositoryInterface;
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

    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $userRepository)
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
