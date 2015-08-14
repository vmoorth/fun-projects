<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$app->get('/', function() use ($app) {
      return "Wow...";
});

$app->get('api/food','FoodController@index');
$app->get('api/order','OrderController@index');
$app->post('api/order','OrderController@createOrder');
$app->put('api/order/{id}','OrderController@updateOrder');
$app->delete('api/order/{id}','OrderController@deleteOrder');


?>
