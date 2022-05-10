<?php

namespace App\Application\Controllers\Workspace\Schedules;

use App\Application\Controllers\Controller;
use App\Domain\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @OA\Delete(
 *     path="/organizations/{organization_id}/{workspace_id}/schedule/{schedule_id}",
 *     tags={"workspaces"},
 *     summary="Remove user from workspace",
 *     security={{"passport":{}}},
 *     @OA\Parameter (
 *         name="schedule_id",
 *         in="path",
 *         description="schedule id",
 *         required=true,
 *     ),
 *     @OA\Parameter (
 *         name="organization_id",
 *         in="path",
 *         description="organization id",
 *         required=true,
 *     ),
 *     @OA\Parameter (
 *         name="workspace_id",
 *         in="path",
 *         description="workspace id",
 *         required=true,
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success message",
 *     ),
 * )
 */
final class Delete extends Controller
{
    public function __invoke(Request $request, $schedule_id): JsonResponse
    {

        $scheduleToDelete = $request->workspace->schedules()->find($schedule_id);

        if (!$scheduleToDelete) {
            return $this->respondWithValidationError(
                "Unable to delete schedule",
                [
                    'schedule_id' => 'User not found',
                ],
                ResponseAlias::HTTP_BAD_REQUEST
            );
        }

        $scheduleToDelete->delete();

        return $this->respondWithSuccess('Schedule removed from workspace', 200);
    }
}
