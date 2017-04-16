<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

use  App\Services\JWTAuth;

class JWTMiddleware
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    protected $jwtAuth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(JWTAuth $jwtAuth, Auth $auth)
    {
        $this->auth = $auth;
        $this->jwtAuth = $jwtAuth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//        $token = $request->header('Authorization');
//        $token = $this->jwtAuth->getToken();

        if($this->auth->guard($guard)->guest()) {
//        if(!$this->jwtAuth->verifyToken($token)) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
