<?php

namespace App\Http\Controllers;

use App\Services\JWTAuth;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    protected $jwtAuth;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function login(Request $request) {

        $email = $request->input('email', 'default@default.de');
        $password = $request->input('password');


        if(Auth::attempt(['email' => $email, 'password' => $password]))
        {
            $user = Auth::user();
            $token = $this->jwtAuth->authenticateUser($user);

            return response()->json(
                [
                    'success' => true,
                    'email' => $email,
                    'token' => strval($token),
                ]
            );
        }
        else
        {
            return response()->json(['success' => false, 'email' => $email]);
        }
    }
}
