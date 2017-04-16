<?php

namespace App\Data\Model;

use Illuminate\Database\Eloquent\Model;

class JWTToken extends Model
{
    protected $table = 'jwttokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['token', 'issued_at', 'expires_at', 'last_access', 'user_id'];
    
    /**
     * Get the user that owns the token.
     */
    public function user()
    {
        // Default for foreign key would be user_id
        return $this->belongsTo('App\Data\Model\User', 'user_id');
    }
}
