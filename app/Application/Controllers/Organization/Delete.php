<?php

namespace App\Application\Controllers\Organization;

use App\Application\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Delete (
 *     path="/organizations/{id}",
 *     summary="Delete organization, only for organization owner",
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

    public function __invoke(Request $request, $organization): JsonResponse
    {
        try {
            $this->validate($request, [
                'id' => 'required|integer',
            ]);
        } catch (ValidationException $e) {
            $this->respondWithValidationError("Invalid organization id", $e->errors(), 400);
        }

        $request->user()->organizations()->find($organization)->delete();

        return $this->respondWithSuccess("Organization $organization deleted.");
    }
}
