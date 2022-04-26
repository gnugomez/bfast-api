<?php

namespace App\Application\Middlewares;

use Illuminate\Http\Request;
use Closure;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class WorkspaceExistInOrganization
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = $request->user();
        $workspace = $user->organizations()->find($request->route('organization'))->workspaces()->find($request->route('workspace'));

        if (!$workspace) {
            return response()->json([
                'message' => 'Workspace not found in this organization',
            ], ResponseAlias::HTTP_NOT_FOUND);
        }

        $request->merge(['workspace' => $workspace]);

        return $next($request);
    }
}
