<?php
namespace App\Services;

use Woodstick\JWT\JWTLib;

use Illuminate\Auth\GuardHelpers as GuardHelpersTrait;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard as GuardContract;

use Illuminate\Support\Facades\Log;

class JWTGuard implements GuardContract
{
    use GuardHelpersTrait;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    public function __construct(UserProvider $provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     *
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        $user = $this->provider->retrieveByCredentials($credentials);

        return $this->hasValidCredentials($user, $credentials);
    }

    /**
     * Attempt to authenticate the user using the given credentials and return the token.
     *
     * @param array $credentials
     * @param bool  $login
     *
     * @return mixed
     */
    public function attempt(array $credentials = [])
    {
        Log::debug('Attemp to authenticate');

        $user = $this->provider->retrieveByCredentials($credentials);

        if ($this->hasValidCredentials($user, $credentials)) {

            $this->login($user, $credentials);

            return true;
        }

        return false;
    }

    /**
     * Determine if the user matches the credentials.
     *
     * @param  mixed  $user
     * @param  array  $credentials
     *
     * @return bool
     */
    protected function hasValidCredentials($user, $credentials)
    {
        return !is_null($user) && $this->provider->validateCredentials($user, $credentials);
    }

    /**
     * Log a user into the application.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     *
     * @return void
     */
    public function login(Authenticatable $user)
    {
        $this->setUser($user);
    }

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout()
    {
        $this->user = null;
    }
}
