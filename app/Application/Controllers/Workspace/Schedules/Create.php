<?php

namespace App\Application\Controllers\Workspace\Schedules;

use App\Application\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @OA\Post(
 *     path="/organizations/{organization_id}/workspaces/schedules",
 *     tags={"workspaces"},
 *     summary="Create schedule for a given workspace",
 *     security={{"passport":{}}},
 *     @OA\Parameter (
 *         name="weekday",
 *         in="query",
 *         description="Integer representing the day of the week",
 *         required=true,
 *     ),
 *     @OA\Parameter (
 *         name="start_time",
 *         in="query",
 *         description="Integer representing the start time in minutes",
 *         required=true,
 *     ),
 *     @OA\Parameter (
 *         name="end_time",
 *         in="query",
 *         description="Integer representing the end time in minutes",
 *         required=true,
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success message",
 *     ),
 * )
 */
class Create extends Controller
{

	public function __invoke(Request $request): JsonResponse
	{

		try {
			$this->validate($request, [
				'weekday' => 'required|integer|between:0,6',
				'start_time' => 'required|integer|between:0,1440|lt:end_time',
				'end_time' => 'required|integer|between:0,1440|gt:start_time',
			]);
		} catch (ValidationException $e) {
			return $this->respondWithValidationError(
				"Unable to add schedule",
				$e->errors(),
				ResponseAlias::HTTP_BAD_REQUEST
			);
		}

		$conflictSchedule = $request->workspace->schedules()->where('weekday', $request->input('weekday'))
			->whereBetween('start_time', [$request->input('start_time'), $request->input('end_time')])
			->orWhereBetween('end_time', [$request->input('start_time'), $request->input('end_time')])
			->first();

		if ($conflictSchedule) {
			return $this->respondWithError(
				"Unable to add schedule",
				ResponseAlias::HTTP_CONFLICT
			);
		}

		$request->workspace->schedules()->create([
			'weekday' => $request->input('weekday'),
			'start_time' => $request->input('start_time'),
			'end_time' => $request->input('end_time'),
		]);

		return $this->respondWithSuccess(
			"Schedule created successfully",
			ResponseAlias::HTTP_CREATED
		);
	}
}
