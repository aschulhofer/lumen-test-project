<?php

namespace App\Services\Contracts; 

use Illuminate\Http\Request;

/**
 *
 */
interface TokenSource {
    
    public function getToken(Request $request);
    
}
