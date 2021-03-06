<?php

namespace App\Application\Controllers\User;

use App\Application\Controllers\Controller;
use App\Domain\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

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
 *     )
 * )
 */
final class Create extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'string', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/'],
            ]);
        } catch (ValidationException $e) {
            return $this->respondWithValidationError(
                "Unable to create user",
                $e->errors(),
                ResponseAlias::HTTP_BAD_REQUEST
            );
        }

        User::create([
            "name" => $request->get("name"),
            "surname" => $request->get("surname"),
            "email" => $request->get("email"),
            "password" => password_hash($request->get("password"), PASSWORD_DEFAULT),
        ])->save();

        return $this->respondWithSuccess("User created", ResponseAlias::HTTP_CREATED);
    }
}
