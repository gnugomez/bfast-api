<?php

namespace App\Application\Controllers\User;

use App\Application\Controllers\Controller;
use App\Domain\Models\User;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\Request;

/**
 * @OA\Delete (
 *     path="/users/{id}",
 *     summary="Delete user",
 *     tags={"users"},
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

    public function __invoke(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            $this->validate($request, [
                'id' => 'required|integer|exists:users,id',
            ]);
        } catch (ValidationException $e) {
            $this->respondWithValidationError("User does not exist failed", $e->errors(), 400);
        }

        User::destroy($id);

        return response()->json(["success" => "User $id deleted."]);
    }

}
