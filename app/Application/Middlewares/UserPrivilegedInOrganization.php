<?php

namespace App\Application\Middlewares;

use Illuminate\Http\Request;
use Closure;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserPrivilegedInOrganization
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

        if (!$user->isPrivilegedInOrganization($request->route('organization'))) {
            return response()->json([
                'message' => 'You are not allowed to do that in this organization.'
            ], ResponseAlias::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
