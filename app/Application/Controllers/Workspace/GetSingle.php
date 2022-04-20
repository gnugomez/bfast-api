<?php

namespace App\Application\Controllers\Workspace;

use App\Application\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

final class GetSingle extends Controller
{
	public function __invoke(Request $request, $organization, $workspace_slug): JsonResponse
	{
		$user = $request->user();
		$organization = $user->organizations()->find($organization);
		$workspace = $organization->workspaces()->where('slug', $workspace_slug)->first();

		if (!$workspace) {
			return response()->json([
				'message' => 'Workspace not found in this organization',
			], ResponseAlias::HTTP_NOT_FOUND);
		}

		$isUserInWorkspace = $workspace->users()->find($user->id);

		if (!$isUserInWorkspace && !$organization->isUserPrivileged($user->id)) {
			return response()->json([
				'message' => 'You are not a member of this workspace',
			], ResponseAlias::HTTP_FORBIDDEN);
		}

		return new JsonResponse($workspace);
	}
}
