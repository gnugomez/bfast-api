<?php

namespace App\Application\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="bfast API",
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

    protected function respondWithSuccess($message = null, $code = 200, $data = null): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($data) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    protected function respondWithError($message, $code): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $code);
    }

    protected function respondWithValidationError($message, $errors, $code): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}
