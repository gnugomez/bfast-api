<?php

namespace App\Infrastructure\Http\Controllers\User;

use App\Infrastructure\Http\Controllers\Controller;
use App\Domain\Contracts\UserRepositoryContract;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Http\Request;


class Me extends Controller
{
    private UserRepositoryContract $userRepository;

    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(Request $request)
    {
        return new Response(Auth::user());
    }
}
