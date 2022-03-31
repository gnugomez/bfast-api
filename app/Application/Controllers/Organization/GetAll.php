<?php

namespace App\Application\Controllers\Organization;

use App\Application\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Domain\Models\Organization;

/**
 * @OA\Get(
 *     path="/organizations",
 *     tags={"organizations"},
 *     summary="List all Organizations from logged user",
 *     security={{"passport":{}}},
 *     @OA\Response(
 *         response="200",
 *         description="Return a list of organizations",
 *     ),
 * )
 */
final class GetAll extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {

        $organizations = array_map(function ($organization) {
            $organization['role'] = $organization['pivot']['role'];
            $organization['privileged'] = in_array($organization['role'], Organization::getPrivilegedRoles());
            return $organization;
        }, $request->user()->organizations()->get()->toArray());

        return new JsonResponse($organizations);
    }
}
