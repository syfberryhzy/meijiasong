<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart as ShopCart;
use Cart;

class CartController extends Controller
{
    public function create()
    {
        #查看是否已存在

        Cart::instance('meijiasong')->restore('syf');
        $datas = Cart::instance('meijiasong')->content();
        // dd($datas);
        // Cart::instance('meijiasong')->add($datas);
        Cart::instance('meijiasong')->store('syf');
        dd($datas);
        // Cart::instance('meijiasong')->add([
        //   ['id' => '293ad', 'name' => 'Product 1', 'qty' => 1, 'price' => 10.00],
        //   ['id' => '4832k', 'name' => 'Product 2', 'qty' => 1, 'price' => 10.00, 'options' => ['size' => 'large']]
        // ]);

        // Cart::instance('meijiasong')->store('syf');

        // return response()->json(['data' => [], 'status' => 1], 201);
    }
}
