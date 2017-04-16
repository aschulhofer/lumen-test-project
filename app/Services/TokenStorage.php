<?php

namespace App\Services;

use App\Data\Model\JWTToken;

/**
 * TODO: better naming?
 */
class TokenStorage {
    
    public function addTokenData($tokenData) {
        JWTToken::create($tokenData);
    }
    
    /**
     * 
     * 
     * @param type $token
     * 
     * @return App\Data\Model\JWTToken
     */
    public function getTokenData($token) {
        
//        try {
//            $tokenData = App\Data\Model\JWTToken::where('token', $token)->firstOrFail();
//            return $tokenData;
//        }
//        catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
//            return null;
//        }
        
        return $tokenData = JWTToken::where('token', $token)->first();
    }
}
