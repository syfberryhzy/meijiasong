<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

;


// $router->get('/user/counts', 'WebController@orderCount');
// $router->get('/user/counts', 'WebController@orderCount');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::any('/wechat/payment/notify', 'WechatController@update');

Route::get('canelorder', function () {
    $order = \App\Models\Order::find(112);
    \App\Jobs\CancelOrder::dispatch($order);
});
