<?php

namespace App\Infrastructure\Http\Controllers\Auth;

use App\Infrastructure\Http\Controllers\Controller;
use App\Domain\Contracts\UserRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Post(
 *     path="/auth/validate",
 *     tags={"auth"},
 *     summary="Validate credentials to get a token",
 *     @OA\Parameter (
 *         name="username",
 *         in="query",
 *         description="New user username",
 *         required=true,
 *     ),
 *     @OA\Parameter (
 *          name="password",
 *          in="query",
 *          description="New user password",
 *          required=true,
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Successful returns token with expiration time",
 *     ),
 *     @OA\Response(
 *         response="401",
 *         description="Unauthorized",
 *     ),
 * )
 */
final class ValidateUser extends Controller
{
    private UserRepositoryContract $repository;

    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function __invoke(Request $request): Response
    {
        try {
            $this->validate($request, [
                'username' => 'required|string',
                'password' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return new Response(["error" => $e->errors()], 400);
        }

        $credentials = $request->only(['username', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return new Response(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
}
