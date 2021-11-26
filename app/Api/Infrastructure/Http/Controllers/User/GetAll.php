<?php

namespace App\Api\Infrastructure\Http\Controllers\User;
use App\Api\Infrastructure\Http\Controllers\Controller;
use App\Api\Application\User\ListUsers;
use App\Api\Domain\Contracts\UserRepositoryContract;
use Illuminate\Http\Response;

/**
 * @OA\Get(
 *     path="/users",
 *     tags={"users"},
 *     summary="List all users",
 *     @OA\Response(
 *         response="200",
 *         description="Return a list of users",
 *     ),
 * )
 */
final class GetAll extends Controller
{

    private UserRepositoryContract $repository;

    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->repository = $userRepository;
        $this->middleware('auth');
    }

    public function __invoke(): Response
    {
        $allUsers = (new ListUsers($this->repository))();
        return count($allUsers) ? new Response($allUsers) : new Response(['message' => 'No users found'], 404) ;
    }
}
