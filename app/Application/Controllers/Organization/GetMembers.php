<?php

namespace App\Application\Controllers\Organization;

use App\Application\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Http\Request;

/**
 * @OA\Get(
 *     path="/organizations/{organization_id}/members",
 *     tags={"organizations"},
 *     summary="List all users of a given organization from logged user",
 *     security={{"passport":{}}},
 *     @OA\Response(
 *         response="200",
 *         description="Return a list of users of a given organization",
 *     ),
 * )
 */
final class GetMembers extends Controller
{


    public function __construct()
    {
    }

    public function __invoke(Request $request, $id): JsonResponse
    {
        $organization = Auth::user()->organizations()->findOrFail($id);

        if (!$organization) {
            return response()->json([
                'message' => 'Organization not found'
            ], 404);
        }

        if ($organization->pivot->role !== 'owner') {
            return response()->json([
                'message' => 'You are not authorized to access this resource'
            ], 403);
        }
        return new JsonResponse($organization->users()->get());
    }
}
