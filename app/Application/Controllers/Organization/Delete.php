<?php

namespace App\Application\Controllers\Organization;

use App\Application\Controllers\Controller;
use App\Domain\Models\Organization;
use App\Domain\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\Request;

/**
 * @OA\Delete (
 *     path="/organizations/{id}",
 *     summary="Delete user",
 *     tags={"organizations"},
 *     security={{"passport":{}}},
 *     @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="User deleted"
 *     )
 * )
 */
final class Delete extends Controller
{


    public function __construct()
    {
    }

    public function __invoke(Request $request, $id): JsonResponse
    {
        try {
            $this->validate($request, [
                'id' => 'required|integer|exists:organizations,id',
            ]);
        } catch (ValidationException $e) {
            $this->respondWithValidationError("Organization does not exist failed", $e->errors(), 400);
        }

        $user = Auth::User();

        $user->organizations()->detach($id);

        Organization::destroy($id);

        return $this->respondWithSuccess( "Organization $id deleted.");
    }

}
