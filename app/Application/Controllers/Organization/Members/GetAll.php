<?php

namespace App\Application\Controllers\Organization\Members;

use App\Application\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Domain\Models\Organization;

/**
 * @OA\Get(
 *     path="/organizations/{organization_id}/members",
 *     tags={"organizations"},
 *     summary="List all users of a given organization from logged user, only for organization admin",
 *     security={{"passport":{}}},
 *     @OA\Response(
 *         response="200",
 *         description="Return a list of users of a given organization",
 *     ),
 * )
 */
final class GetAll extends Controller
{

    public function __invoke(Request $request, $organization): JsonResponse
    {
        $members = array_map(function ($member) {
            $member['role'] = $member['pivot']['role'];
            $member['privileged'] = in_array($member['role'], Organization::getPrivilegedRoles());
            return $member;
        }, $request->user()->organizations()->find($organization)->users()->orderBy('pivot_id')->get()->toArray());
        return new JsonResponse($members);
    }
}
