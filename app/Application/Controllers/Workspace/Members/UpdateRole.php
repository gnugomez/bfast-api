<?php

namespace App\Application\Controllers\Workspace\Members;

use App\Application\Controllers\Controller;
use App\Domain\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @OA\Patch(
 *     path="/organizations/{organization_id}/{workspace_id}/members/{user_id}",
 *     tags={"workspaces"},
 *     summary="Add user to a given organization",
 *     security={{"passport":{}}},
 *     @OA\Parameter (
 *         name="user_id",
 *         in="path",
 *         description="organization id",
 *         required=true,
 *     ),
 *     @OA\Parameter (
 *         name="organization_id",
 *         in="path",
 *         description="organization id",
 *         required=true,
 *     ),
 *     @OA\Parameter (
 *         name="workspace_id",
 *         in="path",
 *         description="workspace id",
 *         required=true,
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success message",
 *     ),
 * )
 */
final class UpdateRole extends Controller
{
    public function __invoke(Request $request, $organization, $workspace, $user_id): JsonResponse
    {
        $currentUser = $request->user();

        return $this->respondWithSuccess('User rank updated', 200, $request->workspace);
    }
}
