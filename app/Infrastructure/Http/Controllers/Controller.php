<?php

namespace App\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Bpoint API",
 *     description="This api will be consumed by the bpoint app, all endpoints are documented right here.",
 *     version="0.0.1",
 *     @OA\Contact(
 *          name="Jordi Gómez Hidalgo",
 *          email="gnugomez@gmail.com",
 *          url="https://github.com/gnugomez/",
 *     ),
 *     @OA\License(
 *          name="MIT",
 *          url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */
class Controller extends BaseController
{
    //
    protected function respondWithToken($token): Response
    {
        return new Response([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
