<?php

namespace App\Application\Middlewares;

use Illuminate\Http\Request;
use Closure;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OrganizationExist
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
        $organization = $user->organizations()->find($request->route('organization'));

        if (!$organization) {
            return response()->json([
                'message' => 'Organization not found'
            ], 404);
        }

        return $next($request);
    }

}
