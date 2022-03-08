<?php

namespace App\Application\Middlewares;

use Closure;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var AuthFactory
     */
    protected AuthFactory $auth;

    /**
     * Create a new middleware instance.
     *
     * @param AuthFactory $auth
     * @return void
     */
    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $guard = null): mixed
    {
        if ($this->auth->guard($guard)->guest()) {
            return new Response(['message' => 'Unauthorized'], 401);
        }else{
            $user = Auth::user();
            $request->merge(['user' => $user ]);

            $request->setUserResolver(function () use ($user) {
                return $user;
            });
        }

        return $next($request);
    }
}
