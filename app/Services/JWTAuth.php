<?php

namespace App\Services;

use App\Services\TokenProvider;
use App\Services\TokenStorage;
use Illuminate\Support\Facades\Log;
use Woodstick\JWT\Claim\Claim;
use Woodstick\JWT\Claim\IssuedAt;
use Woodstick\JWT\Claim\Subject;
use Woodstick\JWT\JWTLib;
use Woodstick\JWT\Token;

class JWTAuth {

    /**
     * The jwt library instance.
     * 
     * @var JWTLib
     */
    protected $jwtLib;
    
    /**
     *
     * @var TokenProvider 
     */
    protected $tokenProvider;
    
    /**
     *
     * @var TokenStorage 
     */
    protected $tokenStorage;
    
    public function __construct(JWTLib $jwtLib, TokenProvider $tokenProvider, TokenStorage $tokenStorage) {
        $this->jwtLib = $jwtLib;
        $this->tokenProvider = $tokenProvider;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Get token for current request as string or token object.
     * 
     * @param boolean $parse if set to false returns token as string
     * 
     * @return mixed
     */
    public function getToken($parse = false) {
        $tokenString = $this->tokenProvider->retrieveToken();
        
        if($parse) {
            return $this->parseToken($tokenString);
        }
        
        return $tokenString;
    }
    
    /**
     * Parses the given token string
     * 
     * @param string $tokenString
     * 
     * @return Token
     */
    public function parseToken($tokenString) {
        return $this->jwtLib->parse($tokenString);
    }
    
    /**
     * Parses the given token and verifies the signature.
     * 
     * @param string $tokenString
     * 
     * @return boolean
     */
    public function verifyToken($tokenString) {
        $token = $this->parseToken($tokenString);

        return $this->jwtLib->verify($token);
    }

    /**
     * Checks if the token is valid and returns the authenticated user or null
     * if invalid.
     *  
     * @param string $token
     * 
     * @return App\Data\Model\User|null
     */
    public function checkToken($token) {
        $tokenData = $this->tokenStorage->getTokenData($token);
        
        if(!$tokenData) {
            Log::debug(sprintf('No token data found for "%s"', $token));
            
            return null;
        }
        
        $user = $tokenData->user;
        
        Log::debug(sprintf('Found user "%s" for token "%s"', $user->email, $token));
        
        return $user;
    }
    
    /**
     *
     * @param type $user
     *
     * @return type
     */
    public function authenticateUser($user) {

        $issuedAt = new \DateTime();
        $issuedAtTimestamp = $issuedAt->format('U');

        $claims = [
            new Claim("ntb", time() + 60),
            new Claim("exp", time() + 3600),
            new Subject("token"),
            new IssuedAt($issuedAtTimestamp),
            new Claim("data", [
                "email" => $user->email,
            ]),
        ];

        $token = $this->jwtLib->create($claims);

        $this->tokenStorage->addTokenData([
            'token' => strval($token),
            'user_id' => $user->id,
            'issued_at' => $issuedAt
        ]);
        
        return $token;
    }
}
