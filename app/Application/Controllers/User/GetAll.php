<?php

namespace App\Application\Controllers\User;

use App\Application\Controllers\Controller;
use App\Domain\Models\User;
use Illuminate\Http\Response;

/**
 * @OA\Get(
 *     path="/users",
 *     tags={"users"},
 *     summary="List all users",
 *     security={{"passport":{}}},
 *     @OA\Response(
 *         response="200",
 *         description="Return a list of users",
 *     ),
 * )
 */
final class GetAll extends Controller
{


    public function __construct()
    {
    }

    public function __invoke(): Response
    {
        $allUsers = User::all();
        return count($allUsers) ? new Response($allUsers) : new Response(['message' => 'No users found'], 404);
    }
}
