<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\User\Application\UseCases\ListUsers;
use App\User\Domain\Interfaces\UserRepositoryInterface;
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

    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function __invoke(): Response
    {
        $allUsers = (new ListUsers($this->repository))();
        return count($allUsers) ? new Response($allUsers) : new Response(['message' => 'No users found'], 404) ;
    }
}
