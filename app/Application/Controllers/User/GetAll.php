<?php

namespace App\Application\Controllers\User;

use App\Application\Controllers\Controller;
use App\Domain\Models\User;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Get(
 *     path="/users",
 *     tags={"users"},
 *     summary="List all users",
 *     security={{"passport":{}}},
 *     @OA\Response(
 *         response="200",
 *         description="Return a list of users",
 *     ),
 * )
 */
final class GetAll extends Controller
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(User::all());
    }
}
