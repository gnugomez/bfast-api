<?php

namespace App\Application\Controllers\Organization;

use App\Application\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/organizations/{organization_id}/members",
 *     tags={"organizations"},
 *     summary="List all users of a given organization from logged user",
 *     security={{"passport":{}}},
 *     @OA\Response(
 *         response="200",
 *         description="Return a list of users of a given organization",
 *     ),
 * )
 */
final class GetMembers extends Controller
{

    public function __invoke(Request $request, $organization): JsonResponse
    {
        return new JsonResponse($request->user()->organizations()->find($organization)->users()->get());
    }
}
