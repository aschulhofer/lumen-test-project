<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'api'], function() use ($app) {
    $app->post('login', 'LoginController@login');


});

$app->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($app) {
    $app->get('tokenTest', 'WoodstickController@tokenTest');
    
    $app->post('logout', 'LogoutController@logout');
});


$app->get('woodstick/sayhello', 'WoodstickController@sayHello');

$app->get('woodstick/jwttest', 'WoodstickController@jwtTest');

$app->get('woodstick/jwttestlib', 'WoodstickController@jwtTestLib');

$app->get('woodstick/hash/{valueToHash}', 'WoodstickController@testHash');
