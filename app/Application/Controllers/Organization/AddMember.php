<?php

namespace App\Application\Controllers\Organization;

use App\Application\Controllers\Controller;
use App\Domain\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Put(
 *     path="/organizations/{organization_id}/members",
 *     tags={"organizations"},
 *     summary="Add user to a given organization",
 *     security={{"passport":{}}},
 *     @OA\Parameter (
 *         name="user_email",
 *         in="query",
 *         description="Email of the user to add",
 *         required=true,
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success message",
 *     ),
 * )
 */
final class AddMember extends Controller
{
    public function __invoke(Request $request, $id): JsonResponse
    {
        $this->validate($request, [
            'user_email' => 'required|email',
        ]);

        $user = Auth::user();

        $organization = $user->organizations()->findOrFail($id);

        if ($organization->pivot->role !== 'owner') {
            return $this->respondWithError('You are not the owner of this organization', 403);
        }

        $userToAdd = User::where('email', $request->user_email)->first();

        if (!$userToAdd) {
            return $this->respondWithError('User not found', 404);
        }

        if ($organization->users()->find($userToAdd->id)) {
            return $this->respondWithError('User already in organization', 409);
        }

        $organization->users()->attach($userToAdd->id, ['role' => 'member']);

        return $this->respondWithSuccess('User added to organization');
    }
}
