<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Models\Shelf;
use App\Models\Product;
use App\Models\Address;
use App\Models\Integral;
use App\Models\Balance;
use App\Models\Pay;
use App\Models\AdminConfig as Config;
use Carbon\Carbon;

class WebController extends Controller
{
    #首页
    public function index()
    {
        #商家logo,公告
        #商品分类
        #商品列表
        // $this->authorize('update', $user);
        $categories = Category::where('status', Category::ON)->where('id', '<>', Category::RECHARGE_ID)->with('shelf', 'shelf.product')->get()->toArray();
        $min = collect($categories)->min('foo');
        foreach ($categories as $key => $vo) {
            foreach ($vo['shelf'] as $key2 => $pro) {
                $categories[$key]['shelf'][$key2]['min_price'] = collect($pro['product'])->min('price');
                $categories[$key]['shelf'][$key2]['max_sales'] = collect($pro['product'])->max('sales');
            }
        }
        // dd($categories);
        return response()->json(['data' => $categories, 'status' => 1], 201);
    }
    /**
     * [onLogin description]
     * @return [type] [description]
     */
    public function onLogin()
    {
        return 111;
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

        return Carbon::parse('now')->between($first, $second);
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

    public function shop()
    {
        $shopname =  Config::find(Config::WEBNAME_ID)->value;
        $opentimes =  Config::find(Config::OPENTIMES_ID)->value;
        $sendtimes = Config::find(Config::SENDTIMES_ID)->value;
        $address =  Config::find(Config::ADDRESS_ID)->value;
        $tel =  Config::find(Config::SHOPTEL_ID)->value;
        $sendmess =  Config::find(Config::SENDMESS_ID)->value;
        $activity =  Config::find(Config::ACTIVITY_ID)->value;
        $service =  Config::find(Config::SERVICE_ID)->value;
        $standard =  Config::find(Config::STANDARD_ID)->value;
        $pictures =  Config::find(Config::PICTURES_ID)->value;
        $logo = config('app.url') . '/uploads/' . $pictures[0];
        $pictures = count($pictures) > 3 ? array_splice($pictures, 1, 4) : $pictures;
        $pic = array_map(function ($vo) {
            return config('app.url') . '/uploads/' . $vo;
        }, $pictures);
        $data = [
            'shopname' => $shopname,
            'opentimes' => $opentimes,
            'sendtimes' => $sendtimes,
            'address'  => $address,
            'tel'  => $tel,
            'sendmess' => $sendmess,
            'activity' => $activity,
            'service' => $service,
            'standard' => $standard,
            'logo' => $logo,
            'pictures' => $pic,
        ];

        return response()->json([ 'data' => $data, 'info' => '', 'status' => 1], 201);
    }
}
