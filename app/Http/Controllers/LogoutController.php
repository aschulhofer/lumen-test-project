<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Factory as Auth;
use function response;

class LogoutController extends Controller
{
    protected $auth;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     *
     */
    public function logout() {
        
        $this->auth->guard()->logout();

        return response()->json(
            [
                'success' => true
            ]
        );
    }
}
