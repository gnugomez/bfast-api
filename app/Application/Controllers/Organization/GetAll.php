<?php

namespace App\Application\Controllers\Organization;

use App\Application\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/organizations",
 *     tags={"organizations"},
 *     summary="List all Organizations from logged user",
 *     security={{"passport":{}}},
 *     @OA\Response(
 *         response="200",
 *         description="Return a list of organizations",
 *     ),
 * )
 */
final class GetAll extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse($request->user()->organizations()->get());
    }
}
