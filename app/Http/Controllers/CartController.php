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
    }

    /**
     * 查看当前的购物车信息
     *
     * @return [type] [description]
     */
    public function index()
    {
        $identifier = 'user.'.auth()->id().'.cart';
        $this->cart->restore($identifier);
        try {
            $this->cart->store($identifier);
        } catch (\Gloudemans\Shoppingcart\Exceptions\CartAlreadyStoredException $e) {
            \DB::table('shoppingcart')->where(['identifier' => $identifier])->delete();
            $this->cart->store($identifier);
        }
        return response([
            'data' => $this->cart->content(),
            'count' => $this->cart->count(),
            'price' => $this->cart->subtotal
        ]);
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
        $identifier = 'user.'.auth()->id().'.cart';
        $this->cart->restore($identifier);

        $cacheKey = "{$identifier}.shelf.{$shelf->id}.product.{$product->id}";
        $rowId = Cache::tags(['shoppingcart'])->get($cacheKey);

        if ($this->cart->content()->has($rowId) && !is_null(request()->qty)) {
            $this->cart->update($rowId, ['qty' => (int)request()->qty]);
        } else {
            $data = $this->cart->add(
                $product->id,
                $shelf->name . "( {$product->characters} )",
                request()->qty ?? 1,
                $product->price,
                $options = [
                    'shelf_id' => $shelf->id,
                    'product_id' => $product->id,
                    'image' => asset('/uploads/' . $shelf->image[0])
                ]
            )->associate(Product::class);

            $cacheKey = "{$identifier}.shelf.{$shelf->id}.product.{$product->id}";
            Cache::tags(['shoppingcart'])->forever($cacheKey, $data->rowId);
        }

        try {
            $this->cart->store($identifier);
        } catch (\Gloudemans\Shoppingcart\Exceptions\CartAlreadyStoredException $e) {
            \DB::table('shoppingcart')->where(['identifier' => $identifier])->delete();
            $this->cart->store($identifier);
        }


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

        $identifier = 'user.'.auth()->id().'.cart';
        $this->cart->restore($identifier);

        $cacheKey = "{$identifier}.shelf.{$shelf->id}.product.{$product->id}";
        $rowId = Cache::tags(['shoppingcart'])->get($cacheKey);

        if ($data['qty'] == 0) {
            Cache::forget($cacheKey);
            $this->cart->remove($rowId);
        } else {
            $this->cart->update($rowId, ['qty' => (int)$data['qty']]);
        }

        try {
            $this->cart->store($identifier);
        } catch (\Gloudemans\Shoppingcart\Exceptions\CartAlreadyStoredException $e) {
            \DB::table('shoppingcart')->where(['identifier' => $identifier])->delete();
            $this->cart->store($identifier);
        }


        return response($this->cart->content());
    }

    /**
     * 清空购物车
     *
     * @return [type] [description]
     */
    public function destory(Request $request)
    {
        // $identifier = 'user.'.auth()->id().'.cart';
        // $this->cart->restore($identifier);
        // if ($rowIds = $request->rowIds) {
        //     foreach ($rowIds as $rowId) {
        //         $this->cart->remove($rowId);
        //     }
        //     $this->cart->store($identifier);
        // } else {
        //     Cache::tags('shoppingcart')->flush();
        //     $this->cart->destroy();
        // }
        $this->deleteCart();
    }
}
