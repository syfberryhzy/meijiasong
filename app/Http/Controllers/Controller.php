<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Cart as ShopCart;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * [getcart description]
     * @return [type] [description]
     */
    public function getCartContent($cart = null)
    {
        $cart || $cart = $this->getCart();
        if ($rowIds = request()->rowIds) {
            foreach ($rowIds as $rowId) {
                $carts[$rowId] = $cart->get($rowId);
            }
        } else {
            $carts = $cart->content();
        }
        return $carts;
    }

    public function getCart()
    {
        $user = auth()->user();
        $identifier = "user.{$user->id}.cart";
        $cart = ShopCart::instance('meijiasong');
        $cart->restore($identifier);
        $cart->store($identifier);

        return $cart;
    }

    public function deleteCart()
    {
        $user = auth()->user();
        $identifier = "user.{$user->id}.cart";
        $cart = ShopCart::instance('meijiasong');
        $cart->restore($identifier);

        if ($rowIds = request()->rowIds) {
            foreach ($rowIds as $rowId) {
                $cart->remove($rowId);
            }
            $cart->store($identifier);
        } else {
            Cache::tags('shoppingcart')->flush();
            $cart->destroy();
        }
    }
}
