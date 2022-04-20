<?php

namespace App\Application\Controllers\Workspace;

use App\Application\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @OA\Post(
 *     path="/organizations/{organization_id}/workspaces",
 *     tags={"workspaces"},
 *     summary="Create work space",
 *     security={{"passport":{}}},
 *     @OA\Parameter (
 *         name="name",
 *         in="query",
 *         description="Name of the new work space",
 *         required=true,
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success message",
 *     ),
 * )
 */
class Create extends Controller
{

    public function __invoke(Request $request, $organization): JsonResponse
    {

        try {
            $this->validate($request, [
                'name' => 'required|string|max:255',
            ]);
        } catch (ValidationException $e) {
            return $this->respondWithValidationError(
                "Unable to add user",
                $e->errors(),
                ResponseAlias::HTTP_BAD_REQUEST
            );
        }

        $organization = $request->user()->organizations()->find($organization);

        $organization->workspaces()->create([
            'name' => $request->input('name'),
        ]);

        return $this->respondWithSuccess(
            "Work space created successfully",
            ResponseAlias::HTTP_CREATED
        );
    }
}
