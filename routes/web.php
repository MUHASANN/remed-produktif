<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\InboundStuffController;

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

$router->post('login', 'UserController@login'); 
$router->get('logout', 'UserController@logout');


//manggil method index dari StuffController buat menangani permintaan
$router->get('/stuffs', 'StuffContoller@index');


//route di dalem ini berawalan stuff   //callback funtion yang ber definisi route yg di kelompokan
$router->group(['prefix' => 'stuff', 'middleware' => 'auth'], function() use ($router) {
    $router->get('/data', 'StuffController@index');
    $router->post('/store', 'StuffController@store');
    $router->get('/trash', 'StuffController@trash');

    //dynamic routes \nilai dinamis dari url
    $router->get('{id}', 'StuffController@show');
    $router->patch('/{id}', 'StuffController@update');
    $router->delete('/{id}', 'StuffController@destroy');
    $router->get('/restore/{id}', 'StuffController@restore');
    $router->delete('/permanent/{id}', 'StuffController@deletePermanent');
}); 


$router->group(['prefix' => 'user'], function() use ($router) {
    //static routes
    $router->get('/data', 'UserController@index');
    $router->post('/store', 'UserController@store');
    $router->get('/trash', 'UserController@trash');

    //dynamic routes \nilai dinamis dari url
    $router->get('{id}', 'UserController@show');
    $router->patch('/{id}', 'UserController@update');
    $router->delete('/{id}', 'UserController@destroy');
    $router->get('/restore/{id}', 'UserController@restore');
    $router->delete('/permanent/{id}', 'UserController@deletePermanent');
}); 


$router->group(['prefix' => 'Inbound_stuff/', 'middleware' => 'auth'], function() use ($router) {
    $router->get('/', 'InboundStuffController@index');
    $router->post('store', 'InboundStuffController@store');
    $router->get('detail/{id}', 'InboundStuffController@show');
    $router->patch('update/{id}', 'InboundStuffController@update');
    $router->delete('delete/{id}', 'InboundStuffController@destroy');
    $router->get('recycle-bin', 'InboundStuffController@recycle-bin');
    $router->get('restore/{id}', 'InboundStuffController@restore');
    $router->get('force-delete/{id}', 'InboundStuffController@force=destroy');
}); 


$router->group(['prefix' => 'StuffStock/', 'middleware' => 'auth'], function() use ($router) {
    $router->get('/', 'StuffStockController@index');
    $router->post('store', 'StuffStockController@store');
    $router->get('detail/{id}', 'StuffStockController@show');
    $router->patch('update/{id}', 'StuffStockController@update');
    $router->delete('delete/{id}', 'StuffStockController@destroy');
 
    $router->get('restore/{id}', 'StuffStockController@restore');
    // $router->get('force-delete/{id}', 'StuffStockController@force=destroy');
    $router->post('add-stock', 'StuffStockController@addStock');
    $router->post('sub-stock', 'StuffStockController@subStock');    
}); 