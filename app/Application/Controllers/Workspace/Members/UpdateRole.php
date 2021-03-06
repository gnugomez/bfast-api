<?php

namespace App\Application\Controllers\Workspace\Members;

use App\Application\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @OA\Patch(
 *     path="/organizations/{organization_id}/{workspace_id}/members/{user_id}",
 *     tags={"workspaces"},
 *     summary="Update user role in workspace",
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
final class UpdateRole extends Controller
{
    public function __invoke(Request $request, $user_id): JsonResponse
    {
        try {
            $this->validate($request, [
                'role' => 'required',
            ]);
        } catch (ValidationException $e) {
            return $this->respondWithValidationError(
                "Unable to update user role",
                $e->errors(),
                ResponseAlias::HTTP_BAD_REQUEST
            );
        }

        $userToUpdate = $request->workspace->users()->find($user_id);

        if (!$userToUpdate) {
            return $this->respondWithValidationError(
                "Unable to update user role",
                [
                    'user_id' => 'User not found',
                ],
                ResponseAlias::HTTP_BAD_REQUEST
            );
        }

        if (!$request->workspace->changeUserRole($userToUpdate, $request->input('role'))) {
            return $this->respondWithValidationError(
                "Unable to update user role",
                [
                    'role' => 'Role not found',
                ],
                ResponseAlias::HTTP_BAD_REQUEST
            );
        }

        return $this->respondWithSuccess('User rank updated', 200);
    }
}
