<?php

namespace App\Application\Controllers\Workspace\Members;

use App\Application\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/organizations/{organization_id}/workspaces/members",
 *     tags={"organizations"},
 *     summary="List all users of a given workspace from logged user, only for workspace admin",
 *     security={{"passport":{}}},
 *     @OA\Response(
 *         response="200",
 *         description="Return a list of users of a given workspace",
 *     ),
 * )
 */
final class GetAll extends Controller
{

	public function __invoke(Request $request, $organization, $workspace): JsonResponse
	{
		return new JsonResponse($request->user()->organizations()->find($organization)->workspaces()->find($workspace)->users()->get());
	}
}
