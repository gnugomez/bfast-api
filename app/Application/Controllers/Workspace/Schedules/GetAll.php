<?php

namespace App\Application\Controllers\Workspace\Schedules;

use App\Application\Controllers\Controller;
use App\Domain\Models\Workspace;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/organizations/{organization_id}/workspaces/schedules",
 *     tags={"organizations"},
 *     summary="List all schedules of a given workspace from logged user",
 *     security={{"passport":{}}},
 *     @OA\Response(
 *         response="200",
 *         description="Return a list of schedules of a given workspace",
 *     ),
 * )
 */
final class GetAll extends Controller
{

	public function __invoke(Request $request): JsonResponse
	{
		return new JsonResponse($request->workspace->schedules()->orderBy("id")->get());
	}
}
