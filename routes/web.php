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

    //Countries
    $router->get('countries', ['uses' => 'CountryController@getList']);
    $router->get('countries/{id}', ['uses' => 'CountryController@get']);
    $router->post('countries', ['uses' => 'CountryController@create']);
    $router->delete('countries/{id}', ['uses' => 'CountryController@delete']);
    $router->put('countries/{id}', ['uses' => 'CountryController@update']);

    //Beers
    $router->get('beers', ['uses' => 'BeerController@getList']);
    $router->get('beers/{id}', ['uses' => 'BeerController@get']);
    $router->post('beers', ['uses' => 'BeerController@create']);
    $router->delete('beers/{id}', ['uses' => 'BeerController@delete']);
    $router->put('beers/{id}', ['uses' => 'BeerController@update']);

    //Breweries
    $router->get('breweries', ['uses' => 'BreweryController@getList']);
    $router->get('breweries/{id}', ['uses' => 'BreweryController@get']);
    $router->post('breweries', ['uses' => 'BreweryController@create']);
    $router->delete('breweries/{id}', ['uses' => 'BreweryController@delete']);
    $router->put('breweries/{id}', ['uses' => 'BreweryController@update']);

    //Styles
    $router->get('styles', ['uses' => 'StyleController@getList']);
    $router->get('styles/{id}', ['uses' => 'StyleController@get']);
    $router->post('styles', ['uses' => 'StyleController@create']);
    $router->delete('styles/{id}', ['uses' => 'StyleController@delete']);
    $router->put('styles/{id}', ['uses' => 'StyleController@update']);

    //Auth
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');

    //Users
    $router->get('profile', 'UserController@profile');
    $router->get('users/{id}', 'UserController@singleUser');
    $router->get('users', 'UserController@allUsers');

});
