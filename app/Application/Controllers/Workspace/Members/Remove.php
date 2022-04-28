<?php

namespace App\Application\Controllers\Workspace\Members;

use App\Application\Controllers\Controller;
use App\Domain\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @OA\Delete(
 *     path="/organizations/{organization_id}/{workspace_id}/members/{user_id}",
 *     tags={"workspaces"},
 *     summary="Remove user from workspace",
 *     security={{"passport":{}}},
 *     @OA\Parameter (
 *         name="user_id",
 *         in="path",
 *         description="user id",
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
final class Remove extends Controller
{
    public function __invoke(Request $request, $user_id): JsonResponse
    {

        $userToUpdate = $request->workspace->users()->find($user_id);

        if (!$userToUpdate) {
            return $this->respondWithValidationError(
                "Unable to remove user",
                [
                    'user_id' => 'User not found',
                ],
                ResponseAlias::HTTP_BAD_REQUEST
            );
        }

        $request->workspace->users()->detach($userToUpdate);

        return $this->respondWithSuccess('User removed from workspace', 200);
    }
}
