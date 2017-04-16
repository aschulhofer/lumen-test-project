<?php

namespace App\Services;

use App\Services\TokenSource;
use App\Services\RequestTrait;

use Illuminate\Http\Request;

/**
 *
 */
class TokenProvider {
    
    use RequestTrait;
    
    /**
     * @var \App\Services\TokenSource 
     */
    protected $tokenSource;
    
    /**
     * @var string 
     */
    protected $token;
    
    public function __construct(Request $request, TokenSource $tokenSource) {
        $this->request = $request;
        $this->tokenSource = $tokenSource;
    }
    
    /**
     * Retrieves the token from the current request.
     * 
     * @return string
     */
    public function retrieveToken() {
        if(!$this->token) {
            $this->token = $this->tokenSource->getToken($this->request);
        }
        
        return $this->token;
    }
}
