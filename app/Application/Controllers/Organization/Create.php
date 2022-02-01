<?php

namespace App\Application\Controllers\Organization;

use App\Application\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @OA\Put(
 *     path="/organizations",
 *     tags={"organizations"},
 *     summary="Create a new user",
 *     security={{"passport":{}}},
 *     @OA\Parameter (
 *         name="name",
 *         in="query",
 *         description="New organization name",
 *         required=true,
 *     ),
 *     @OA\Response(
 *         response="400",
 *         description="Bad request",
 *     ),
 *     @OA\Response(
 *          response="201",
 *          description="Organization added",
 *     )
 * )
 */
final class Create extends Controller
{

    public function __contructor()
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->validate($request, [
                'name' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return $this->respondWithValidationError(
                "Unable to create user",
                $e->errors(),
                ResponseAlias::HTTP_BAD_REQUEST
            );
        }

        $user = Auth::User();

        $newOrganization = $user->organizations()->create([
            'name' => $request->name,
        ]);

        if ($newOrganization) {
            return $this->respondWithSuccess(
                "Organization created successfully",
                ResponseAlias::HTTP_CREATED
            );
        }

    }
}
