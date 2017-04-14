<?php

namespace App\Http\Controllers;

use Woodstick\Hello\SayHello;
use Woodstick\JWT\JWTTest;

class WoodstickController extends Controller
{
    public function __construct() {
    }

    public function sayHello() {
      return SayHello::world();
    }

    public function jwtTest() {
      return (new JWTTest())->run();
    }

    public function jwtTestLib() {
      return (new JWTTest())->runLib();
    }
}