<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$router->post('/register', [
    'uses' => 'MemberController@register'
]);

$router->put('/user', [
    'uses' => 'MemberController@update',
    'middleware' => 'auth:api'
]);
$router->get('/index', 'WebController@index');
$router->get('/recharge', 'WebController@recharge');
$router->get('/shop', 'WebController@shop');
$router->put('/recharge/{product}', 'OrderController@recharge');

$router->get('/orders', 'OrderController@index');
$router->get('/wechat', 'WechatController@create');
$router->get('/orders/counts', 'OrderController@counts');
$router->get('/orders/{order}', 'OrderController@show');
$router->put('/orders/{order}', 'OrderController@update');


$router->put('/orders/buy', 'OrderController@buy');

// $router->get('/users', 'UserController@index');
// $router->get('/users/{user}', 'UserController@show')->name('user_info');
// $router->put('/users', 'UserController@update');
$router->get('/users/integral', 'UserController@integral');
$router->get('/users/balance', 'UserController@balance');


$router->get('/address', 'AddressController@index');
$router->post('/address', 'AddressController@create');
$router->get('/address/{address}', 'AddressController@show');
$router->put('/address/{address}', 'AddressController@update');
$router->delete('/address/{address}', 'AddressController@delete');
