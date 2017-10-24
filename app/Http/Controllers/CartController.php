<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Cart;
use App\Models\Shelf;
use App\Models\Product;
use Cart as ShopCart;

class CartController extends Controller
{
    public $cart;

    public $identifier;

    public function __construct()
    {
        $this->middleware('auth:api');

        $this->cart = ShopCart::instance('meijiasong');
        $this->identifier = 'user.' . auth()->id() . '.cart';

    }

    /**
     * 查看当前的购物车信息
     *
     * @return [type] [description]
     */
    public function index()
    {
        $this->cart->restore($this->identifier);
        $this->cart->store($this->identifier);
        return response($this->cart->content());
    }

    /**
     * 添加一个购物车商品信息，或者单个添加
     *
     * @param  Shelf   $shelf   [description]
     * @param  Product $product [description]
     * @return [type]           [description]
     */
    public function create(Shelf $shelf, Product $product)
    {
        $this->cart->restore($this->identifier);
        $data = $this->cart->add(
            $product->id,
            $shelf->name . "( {$product->characters} )",
            1,
            $product->price,
            $options = [
                'shelf_id' => $shelf->id,
                'product_id' => $product->id,
            ]
        );
        $this->cart->store($this->identifier);

        $cacheKey = "{$this->identifier}.shelf.{$shelf->id}.product.{$product->id}";
        Cache::tags(['shoppingcart'])->forever($cacheKey);

        return response($this->cart->content());
    }

    /**
     * 更新购物车中的一个商品，可修改多个，用于减少购物车的时候使用
     *
     * @return [type]           [description]
     */
    public function update(Shelf $shelf, Product $product)
    {
        $data = request()->validate([
            'qty' => 'required'
        ]);

        $this->cart->restore($this->identifier);

        $cacheKey = "{$this->identifier}.shelf.{$shelf->id}.product.{$product->id}";
        $rowId = Cache::tags(['shoppingcart'])->get($cacheKey);

        if ((int)$data['qty'] === 0) {
            Cache::forget($cacheKey);
            $this->cart->remove($rowId);
        } else {
            $this->cart->update($rowId, ['qty' => (int)$data['qty']]);
        }

        $this->cart->store($this->identifier);

        return response($this->cart->content());
    }

    /**
     * 清空购物车
     *
     * @return [type] [description]
     */
    public function destory()
    {
        Cache::tags('shoppingcart')->flush();
        $this->cart->destroy();
    }
}
