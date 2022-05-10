<?php

namespace App\Application\Controllers\Workspace;

use App\Application\Controllers\Controller;
use App\Domain\Models\Workspace;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

final class GetSingle extends Controller
{
	public function __invoke(Request $request, $organization, $workspace_slug): JsonResponse
	{
		$user = $request->user();
		$organization = $request->organization;
		$workspace = $organization->workspaces()->with(['users', 'schedules'])->where('slug', $workspace_slug)->first();

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

		$users = array_map(function ($member) {
			$member['role'] = $member['pivot']['role'];
			$member['privileged'] = in_array($member['role'], Workspace::getPrivilegedRoles());
			return $member;
		}, $workspace->users()->orderBy('pivot_id')->get()->toArray());

		$workspace = $workspace->toArray();
		$workspace['users'] = $users;

		return new JsonResponse($workspace);
	}
}
