<?php

namespace App\Application\Controllers\Organization\Workspace;

use App\Application\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/organizations/{organization_id}/workspaces",
 *     tags={"organizations"},
 *     summary="List all workspaces from organization",
 *     security={{"passport":{}}},
 *     @OA\Response(
 *         response="200",
 *         description="Return a list of workspaces",
 *     ),
 * )
 */
final class GetSelf extends Controller
{
    public function __invoke(Request $request, $organization): JsonResponse
    {
        return new JsonResponse($request->user()->workspaces($organization)->get());
    }
}
