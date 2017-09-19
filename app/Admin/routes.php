<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    #用户组
    $router->resource('/usergroup/users', UserController::class);
    $router->resource('/usergroup/address', AddressController::class);
    $router->resource('/usergroup/integrals', IntegralController::class);
    $router->resource('/usergroup/balances', BalanceController::class);
    #商品台
    $router->resource('/goods/categories', CategoryController::class);
    $router->resource('/goods/shelfs', ShelfController::class);
    $router->resource('/goods/products', ProductController::class);

    #订购
    $router->resource('/orders/pays', PayController::class);
    $router->resource('/orders/order_menus', OrderController::class);
    $router->post('/orders/order_menus/operate', 'OrderController@operate');
    $router->resource('/orders/order_items', OrderItemController::class);
    $router->resource('/config', ConfigController::class);
});
