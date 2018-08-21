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

/**
 * @SWG\Info(title="SafetyRatings API", version="1.0")
 */

 /**
 * @SWG\Get(
 *     path="/api/v1/vehicles/{year}/{manufacturer}/{model}",
 *     @SWG\Response(response="200", description="Query vehicles")
 * )
 */
$router->get("vehicles/{year}/{manufacturer}/{model}", "VehicleController@getWithPathParams");

/**
 * @SWG\Get(
 *     path="/api/v1/vehicles",
 *     @SWG\Response(response="200", description="Add vehicles data")
 * )
 */
$router->post("vehicles", "VehicleController@post");

/**
 * @SWG\Get(
 *     path="/api/v1/",
 *     @SWG\Response(response="200", description="Get API version")
 * )
 */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

