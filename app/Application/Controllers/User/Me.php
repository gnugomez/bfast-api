<?php

namespace App\Application\Controllers\User;

use App\Application\Controllers\Controller;
use App\Domain\Contracts\UserRepositoryContract;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Http\Request;


/**
 * @OA\Get(
 *     path="/users/me",
 *     tags={"users"},
 *     security={{"passport":{}}},
 *     summary="Get current user",
 *     @OA\Response(
 *         response="200",
 *         description="Successful returns current user",
 *     ),
 * )
 */
final class Me extends Controller
{

    public function __construct()
    {
    }

    public function __invoke(Request $request): Response
    {
        return new Response(Auth::user());
    }
}
