<?php

namespace App\Application\Controllers\Organization;

use App\Application\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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


    public function __construct()
    {
    }

    public function __invoke(): JsonResponse
    {
        return new JsonResponse(Auth::User()->organizations()->get());
    }
}
