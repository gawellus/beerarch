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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('countries',  ['uses' => 'CountryController@getList']);
  
    $router->get('countries/{id}', ['uses' => 'CountryController@get']);
  
    $router->post('countries', ['uses' => 'CountryController@create']);
  
    $router->delete('countries/{id}', ['uses' => 'CountryController@delete']);
  
    $router->put('countries/{id}', ['uses' => 'CountryController@update']);
});