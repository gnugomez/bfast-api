<?php

namespace App\Application\Controllers\Organization\Workspace;

use App\Application\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Delete (
 *     path="/organizations/{organization_id}/workspaces/{workspace_id}",
 *     summary="Delete workspace, only for organization owner",
 *     tags={"organizations"},
 *     security={{"passport":{}}},
 *     @OA\Parameter(
 *          name="organiztion_id",
 *          in="path",
 *          required=true,
 *     ),
 *     @OA\Parameter(
 *          name="workspace_id",
 *          in="path",
 *          required=true,
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="Workspace deleted"
 *     )
 * )
 */
class Delete extends Controller
{
    public function __invoke(Request $request, $organization, $workspace): JsonResponse
    {

        $workspace = $request->user()->organizations()->findOrFail($organization)->workspaces()->findOrFail($workspace);

        $workspace->delete();

        return $this->respondWithSuccess('Workspace deleted successfully');

    }
}
