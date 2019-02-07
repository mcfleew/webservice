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
    //return $router->app->version();

    return view('app');
});

//
$router->group(['prefix' => 'api/v1'], function () use ($router) {
  //$router->get('clients',  ['uses' => 'ClientController@showAllClients']);
  $router->get('clients',  ['uses' => 'ClientController@showSomeClients']);

  $router->get('clients/{id}', ['uses' => 'ClientController@showOneClient']);
  
  $router->get('clients/search',  ['uses' => 'ClientController@searchClients']);

  $router->post('clients', ['uses' => 'ClientController@create']);

  $router->delete('clients/{id}', ['uses' => 'ClientController@delete']);

  $router->put('clients/{id}', ['uses' => 'ClientController@update']);
});
