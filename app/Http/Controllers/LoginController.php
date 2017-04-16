<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function login(Request $request) {

        $email = $request->input('email', 'default@default.de');
        $password = $request->input('password');

        $token = Auth::attempt(['email' => $email, 'password' => $password]);
        if($token) {
            return response()->json(
                [
                    'success' => true,
                    'email' => $email,
                    'token' => strval($token),
                ]
            );
        }
        else {
            return response()->json(['success' => false, 'email' => $email]);
        }
    }
}
