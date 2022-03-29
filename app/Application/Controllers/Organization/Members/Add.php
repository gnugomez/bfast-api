<?php

namespace App\Application\Controllers\Organization\Members;

use App\Application\Controllers\Controller;
use App\Domain\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @OA\Put(
 *     path="/organizations/{organization_id}",
 *     tags={"organizations"},
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
 *     @OA\Response(
 *         response="200",
 *         description="Success message",
 *     ),
 * )
 */
final class Add extends Controller
{
    public function __invoke(Request $request, $organization): JsonResponse
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

        $organization = $request->user()->organizations()->find($organization);

        $userToAdd = User::where('email', $request->input('user_email'))->first();

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
