<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User\Application\CreateUser;
use App\User\Domain\Contracts\UserRepositoryContract;
use App\User\Domain\Exceptions\DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Put(
 *     path="/users",
 *     operationId="/users",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="username",
 *         in="query",
 *         description="username",
 *      ),
 *     @OA\Parameter(
 *         name="password",
 *         in="query",
 *         description="password",
 *       ),
 *     @OA\Parameter(
 *         name="email",
 *         in="query",
 *         description="email",
 *       ),
 *     @OA\Response(
 *         response="200",
 *         description="User added",
 *     ),
 *     @OA\Response(
 *         response="400",
 *         description="Bad request",
 *     ),
 * )
 */
final class AddUser extends Controller
{

    private UserRepositoryContract $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request): JsonResponse
    {

        $createUser = new CreateUser($this->repository);
        try {
            $createUser(...$request->all());
        } catch (DomainException $e) {
            return response()->json([
                'error' => $e->errors(),
            ], 400);
        }

        return response()->json(["success" => "User added"]);
    }

}
