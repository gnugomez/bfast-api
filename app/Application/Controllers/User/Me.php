<?php

namespace App\Application\Controllers\User;

use App\Application\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


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
    public function __invoke(Request $request): Response
    {
        return new Response($request->user());
    }
}
