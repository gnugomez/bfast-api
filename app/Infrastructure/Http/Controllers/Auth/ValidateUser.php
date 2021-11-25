<?php

namespace App\Infrastructure\Http\Controllers\Auth;

use App\Infrastructure\Http\Controllers\Controller;
use App\Domain\Contracts\UserRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
            return new Response($request->get('username'), 400);
        }

        $credentials = $request->only(['username', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return new Response(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
}
