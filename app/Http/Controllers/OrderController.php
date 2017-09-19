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

class OrderController extends Controller
{
    /**
     * 订单首页
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index(Request $request)
    {
        $orders = Order::where('user_id', 1)->with('items');
        if ($request->status) {
            $status = $request->status . '%';
            $orders = $orders->where('status', 'like', $status);
        }
        $orders = $orders->orderby('id', 'desc')->get()->toArray();
        foreach ($orders as $key => $vo) {
            $product = $vo['items'][0];
            $image = $this->getImage($product['product_id']);
            $product['image'] = $image ? config('app.url').'/uploads/'. $image : '/assets/goods.png';
            $orders[$key]['product'] = $product;
            $orders[$key]['status'] = $this->getStatus($vo['status']);
        }
        return response()->json(['data' => $orders, 'status' => 1], 201);
    }



    public function show(Order $order)
    {
        $order['items'] = OrderItem::where('order_id', $order->id)->get()->toArray();
        $intes = Integral::where('order_id', $order->id)->where('type', 1)->get()->toArray();
        $inte = collect($intes, 'number')->count();
        $order['reward'] = $inte ? $inte : '0.00';
        return response()->json(['data' => $order, 'status' => 1], 201);
    }
    /**
     * 各状态订单个数
     * @return [type] [description]
     */
    public function counts()
    {
        $datas = [];
        for ($i=1; $i<=4; $i++) {
            $datas[] = Order::where('user_id', 1)->where('status', 'like', $i.'%')->count();
        }
        return response()->json(['data' => $datas, 'status' => 1], 201);
    }
    public function getImage($id)
    {
        $data = Product::find($id)->shelf_id;
        $image = Shelf::find($data)->image;
        return $image;
    }

    public function getStatus($status)
    {
        switch ($status) {
            case 1:
                $status = 1;
                break;
            case 21:
            case 22:
                $status = 2;
                break;
            case 31:
            case 32:
                $status = 3;
                break;
            case 41:
            case 42:
                $status = 4;
                break;
            default:
                $status = 1;
        }
        return $status;
    }
    /**
     * 操作订单
     * @param  Request $request [description]
     * @param  Order   $order   [description]
     * @return [type]           [description]
     */
    public function update(Request $request, Order $order)
    {
        if ($request->status) {
            $order->status = $request->status == 4 ? 41 : 31;
        } else {
            return response()->json([ 'data' => [], 'info' => '系统有误', 'status' => 0], 403);
        }
        if ($order->save()) {
            return response()->json([ 'data' => [], 'info' => '操作完成', 'url' => '',  'status' => 1], 201);
        }
        return response()->json([ 'data' => [], 'info' => '操作失败', 'status' => 0], 201);
    }

    public function recharge(Shelf $shelf, Product $product)
    {
        $pay_id = Pay::WEIXIN_ID;
        if ($product->status == 1 && $shelf->status == 1) {
            $order = Order::create([
              'user_id' => 1,
              'pay_id' => $pay_id,
              'amount' => $product->price,
              'total' => $product->price,
              'status' => 1, //待支付
              'order_no' => '', //待支付
              'out_trade_no' => '', //待支付
            ]);
            OrderItem::create([
              'user_id' => 1,
              'order_id' => $order->id,
              'product_id' => $product->id,
              'name' => '充值卡:'.$product->name,
              'amount' => $product->price,
              'total' => $product->price,
              'attributes' => $product->characteres,
            ]);
            return response()->json([ 'data' => [], 'info' => '支付成功', 'status' => 1], 201);
        }
        return response()->json([ 'data' => [], 'info' => '操作失败', 'status' => 0], 201);
    }

    public function buy(Request $request)
    {
        foreach ($request->shelf as $key => $vo) {
            return '';
        }
    }
}
