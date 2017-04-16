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
     * Removed the stored data for the given token.
     * 
     * @param string $token
     * 
     * @return int
     */
    public function removeTokenData($token) {
        return JWTToken::where('token', $token)->delete();
    }
    
    /**
     * Get the stored data for the given token.
     * 
     * @param string $token
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
