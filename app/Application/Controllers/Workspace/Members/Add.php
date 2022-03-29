<?php

namespace App\Application\Controllers\Workspace\Members;

use App\Application\Controllers\Controller;
use App\Domain\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @OA\Put(
 *     path="/organizations/{organization_id}/{workspace_id}",
 *     tags={"workspaces"},
 *     summary="Add user to a given organization",
 *     security={{"passport":{}}},
 *     @OA\Parameter (
 *         name="user_email",
 *         in="query",
 *         description="Email of the user to add",
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
final class Add extends Controller
{
    public function __invoke(Request $request, $organization, $workspace): JsonResponse
    {
        try {
            $this->validate($request, [
                'user_email' => 'required|email',
            ]);
        } catch (ValidationException $e) {
            return $this->respondWithValidationError(
                "Unable to add user",
                $e->errors(),
                ResponseAlias::HTTP_BAD_REQUEST
            );
        }

        $userToAdd = User::where('email', $request->input('user_email'))->first();

        $org = $userToAdd->organizations()->find($organization);

        if (!$org) {
            return $this->respondWithError(
                "User is not a member of this organization",
                ResponseAlias::HTTP_BAD_REQUEST
            );
        }

        $workspaceObj = $org->workspaces()->find($workspace);

        if (!$userToAdd) {
            return $this->respondWithError('User not found', 404);
        }

        if ($workspaceObj->users()->find($userToAdd->id)) {
            return $this->respondWithError('User already in workspace', 409);
        }

        $workspaceObj->users()->attach($userToAdd->id, ['role' => 'member']);

        return $this->respondWithSuccess('User added to workspace');
    }
}
