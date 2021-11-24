<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User\Application\UseCases\CreateUser;
use App\User\Application\UseCases\FindByEmail;
use App\User\Domain\Interfaces\UserRepositoryInterface;
use App\User\Domain\Exceptions\DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Post(
 *     path="/users",
 *     tags={"users"},
 *     summary="Create a new user",
 *     @OA\Parameter (
 *         name="username",
 *         in="query",
 *         description="New user username",
 *         required=true,
 *     ),
 *     @OA\Parameter (
 *          name="email",
 *          in="query",
 *          description="New user email",
 *          required=true,
 *     ),
 *     @OA\Parameter (
 *          name="password",
 *          in="query",
 *          description="New user password",
 *          required=true,
 *     ),
 *     @OA\Response(
 *         response="400",
 *         description="Bad request",
 *     ),
 *     @OA\Response(
 *          response="201",
 *          description="User added",
 *          @OA\JsonContent(ref="#/components/schemas/User"),
 *     )
 * )
 */
final class Add extends Controller
{

    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request): Response | JsonResponse
    {
        try {
            $user = (new CreateUser($this->repository))->__invoke(
                $request->get('username'),
                $request->get('email'),
                $request->get('password')
            );
        } catch (DomainException $exception) {
            return response()->json(["error" => $exception->errors()], 400);
        }

        return response()->json((new FindByEmail($this->repository))->__invoke($user->email->value), 201);
    }
}
