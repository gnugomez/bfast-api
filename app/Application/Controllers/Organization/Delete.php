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
                'id' => 'required|integer',
            ]);
        } catch (ValidationException $e) {
            $this->respondWithValidationError("Invalid organization id", $e->errors(), 400);
        }

        $org = Auth::User()->organizations()->get()->find($id);

        if (!$org) {
            return $this->respondWithError("Organization not found", 404);
        }

        if ($org->pivot->role !== 'owner') {
            return $this->respondWithError("You are not the owner of this organization", 403);
        }

        $org->delete();

        return $this->respondWithSuccess( "Organization $id deleted.");
    }

}
