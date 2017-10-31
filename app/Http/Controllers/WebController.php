<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Shelf;
use App\Models\Product;
use App\Models\Address;
use App\Models\Integral;
use App\Models\Balance;
use App\Models\Pay;
use App\Models\AdminConfig as Config;
use Carbon\Carbon;
use App\Policies\ConfigPolicy;
use Auth;
use Illuminate\Support\Facades\Cache;
use Cart as ShopCart;

class WebController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['index']);
    }

    #首页
    public function index()
    {
        #商品列表
        $categories = Category::where('status', Category::ON)->where('id', '<>', Category::RECHARGE_ID)->with('shelf', 'shelf.product')->get()->toArray();
        $datas = [];
        foreach ($categories as $cate) {
            $data['name'] = $cate['title'];
            $data['description'] = $cate['description'];
            $data['type'] = $cate['type'];
            $data['food'] = [];
            foreach ($cate['shelf'] as $key => $val) {
                $food = [];
                $product = $val['product'];
                if (count($product) > 0) {
                    $food['id'] = $val['id'];
                    $food['name'] = $val['name'];
                    $food['attributes'] = $val['attributes'];
                    $food['image'] = config('app.url'). '/uploads/'. $val['image'][0];
                    $food['info'] = $product[0]['content'];
                    $food['cateCount'] = count($product);
                    $food['Count'] = $this->shoppingCartItemCount($val['id'], $product);
                    $food['price'] = collect($product)->min('price'); //最低价格
                    $food['sellCount'] = collect($product)->sum('sales'); //销量之和
                    $food['cate'] = array_map( function ($vo) {
                        $cate['cate_id'] = $vo['id'];
                        $cate['characters'] = $vo['characters'];
                        $cate['price'] = $vo['price'];
                        return $cate;
                    }, $product);
                    $data['food'][] = $food;
                }
            }
            $datas[] = $data;
        }
        if ($datas) {
            return response()->json(['data' => $datas, 'status' => 1], 201);
        }
        return response()->json(['data' => [], 'status' => 0], 403);
    }

    /**
     * [shoppingCartItemCount description]
     * @param  [type] $id       [description]
     * @param  [type] $products [description]
     * @return [type]           [description]
     */
    private function shoppingCartItemCount($id, $products)
    {
        $store = 'user.' . auth()->id() . '.cart';
        ShopCart::instance('meijiasong')->restore($store);
        $cart = ShopCart::instance('meijiasong')->content();
        $qty = 0;
        foreach ($products as $product) {
            $rowId = $cart->search(function ($cartItem, $rowId) use ($id, $product) {
            	return $cartItem->options->shelf_id === $id && $cartItem->options->product_id == $product['id'];
            });
            $qty += $rowId ? ShopCart::get($rowId)->qty : 0;
        }

        ShopCart::instance('meijiasong')->store($store);
        return $qty;
    }

    /**
     * [detail description]
     * @param  Shelf  $shelf [description]
     * @return [type]        [description]
     */
    public function detail(Shelf $shelf)
    {
        $shelf = $shelf->load('product');
        $product = $shelf['product'];
        if (count($product) == 0) {
            return response()->json(['data' => [], 'info' => '暂无商品上架', 'status' => 0], 403);
        }
        $shelf['image'] = array_map(function ($img) {
            return config('app.url'). '/uploads/'. $img;
        }, $shelf['image']);
        $shelf['sellCount'] = collect($product)->sum('sales'); //销量之和
        $min_price = collect($product)->min('price');
        $max_price = collect($product)->max('price');

        $shelf['price'] = $min_price . '-' . $max_price;
        if ($min_price == $max_price) {
            $shelf['price'] = $min_price;
        }
        $shelf['deductible'] = '';
        $shelf['count'] = count($product);
        $shelf['content'] = $product[0]['content'];
        if ($product[0]['is_default'] == 1) {
            $config = new ConfigPolicy();
            $configPoints = $config->getPoints();
            $point = $product[0]['points'];
            $point = (!$point || $point == 0) ? 1 : $point;
            $per = $point * $configPoints[1] / $configPoints[0];
            $shelf['deductible'] = '可用'. $point .'积分抵扣'. $per . '元';
        }

        return response()->json(['data' => $shelf, 'status' => 1], 201);
    }
    /**
     * 充值中心
     * @return [type] [description]
     */
    public function recharge()
    {
        $recharges = Shelf::where('category_id', Category::RECHARGE_ID)->with('product')->get()->toArray();
        $datas = [];
        $values = ['shelf_id', 'characters', 'price', 'id'];
        foreach ($recharges as $key => $vo) {
            if (count($vo['product']) > 0) {
                $data = array_only($vo['product'][0], $values);
                $data['name'] = $vo['name'];
                $data['price'] = intval($data['price']);
                $datas[$key] = $data;
            }
        }
        // dd($recharges);
        return response()->json([ 'data' => $datas, 'info' => '', 'status' => 1], 201);
    }

    public function checkOpen()
    {
        #是否休息日
        #开业时间段

        if ($data = Config::where('id', Config::OPENTIMES_ID)->first()) {
            $opentimes = explode('-', $data['value']);
        } else {
            $opentimes = ['0:00', '23:59'];
        }
        $carbon = new Carbon();
        $first = Carbon::parse($opentimes[0]);
        $second = Carbon::parse($opentimes[1]);

        return response()->json([ 'data' => Carbon::parse('now')->between($first, $second), 'info' => '', 'status' => 1], 201);
    }

    public function checkSend()
    {
        #配送时间段
        if ($data = Config::where('id', Config::SENDTIMES_ID)->first()) {
            $sendtimes = explode('-', $data['value']);
        } else {
            $sendtimes = ['0:00', '23:59'];
        }
        $carbon = new Carbon();
        $first = Carbon::parse($opentimes[0]);
        $second = Carbon::parse($opentimes[1]);

        return Carbon::parse('now')->between($first, $second);
    }

    //商家信息
    public function shop()
    {
        $config = new ConfigPolicy();
        $data = $config->shopInfo();
        return response()->json([ 'data' => $data, 'info' => '', 'status' => 1], 201);
    }

    public function pays()
    {
        $pays = Pay::where('status', 1)->get()->pluck('name', 'id')->toArray();

        $data = array_only($pays, 'name');
        foreach ($pays as $key => $pay) {
            $data[0][] = $key;
            $data[1][] = $pay;
        }

        return response()->json([ 'data' => $data, 'info' => '', 'status' => 1], 201);
    }

    public function notice()
    {
        $notice = Config::where('id', '>', Config::POINTS_ID)->orderBy('id', 'desc')->first();
        if ($notice) {
            $notice['short_value'] = mb_substr($notice['value'], 0, 20, 'UTF-8') .'...';
            return response()->json([ 'data' => $notice, 'info' => '', 'status' => 1], 201);
        }
        return response()->json([ 'data' => [], 'info' => '', 'status' => 0], 403);
    }
}
