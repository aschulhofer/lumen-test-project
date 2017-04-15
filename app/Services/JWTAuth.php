<?php
namespace App\Services;

use Woodstick\JWT\JWTLib;
use Woodstick\JWT\Claim\Claim;
use Woodstick\JWT\Claim\Subject;
use Woodstick\JWT\Claim\IssuedAt;

use App\Data\Model\User;

use Illuminate\Support\Facades\Log;

class JWTAuth
{

    /**
     * The jwt library instance.
     *
     * @var \Woodstick\JWT\JWTLib
     */
    protected $jwtLib;

    public function __construct(JWTLib $jwtLib) {
        $this->jwtLib = $jwtLib;
    }

    public function authenticateUser($user) {

        $issuedAt = time();

        $claims = [
            new Claim("ntb", time() + 60),
            new Claim("exp", time() + 3600),
            new Subject("token"),
            new IssuedAt($issuedAt),
            new Claim("data", [
                "email" => $user->email,
            ]),
        ];

        $token = $this->jwtLib->create($claims);

        return $token;
    }

    public function verifyToken($token) {
        $tokenStr = $this->jwtLib->parse($token);

        return $this->jwtLib->verify($tokenStr);
    }
}
