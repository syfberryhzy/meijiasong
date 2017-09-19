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

class UserController extends Controller
{
    #个人中心首页
    public function index()
    {
        return response()->json([ 'data' => $user, 'info' => '操作完成', 'status' => 1], 201);
    }

    /**
     * 个人详情
     * @return [type] [description]
     */
    public function info()
    {
        $user = User::find(1);
        return response()->json([ 'data' => $user, 'info' => '操作完成', 'status' => 1], 201);
    }

    /**
     * 个人编辑
     * @param  Request $request [description]
     * @param  User    $user    [description]
     * @return [type]           [description]
     */
    public function userEdit(Request $request, User $user)
    {
        $user->vartar = $request->avatar;
        if ($user->save()) {
            return response()->json([ 'data' => $user, 'info' => '修改完成', 'status' => 1], 201);
        }
        return response()->json([ 'data' => $user, 'info' => '修改失败', 'status' => 0], 201);
    }

    /**
     * 地址列
     * @return [type] [description]
     */
    public function addresses()
    {
        $address = Address::where('user_id', 1)->orderby('is_default', 'desc')->get()->toArray();
        return response()->json([ 'data' => $address, 'info' => '操作完成', 'status' => 1], 201);
    }

    /**
     * 地址详情
     * @param  Address $address [description]
     * @return [type]           [description]
     */
    public function addressShow(Address $address)
    {
        $address = Address::where('user_id', 1)->orderby('is_default', 'desc')->get()->toArray();
        return response()->json([ 'data' => $address, 'info' => '操作完成', 'status' => 1], 201);
    }


    /**
     * 添加地址
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function addressCreate(Request $request)
    {
        Address::create([
            'user_id' => 1,
            'address' => 1,
            'area' => 1,
            'is_default' => 1,
            'user_id' => 1,
        ]);
        return response()->json([ 'data' => $address, 'info' => '操作完成', 'status' => 1], 201);
    }

    /**
     * 地址编辑
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function addressEdit(Request $request, Address $address)
    {
        $address->is_default = $request->is_default;
        if ($address->save()) {
            return response()->json([ 'data' => $address, 'info' => '修改成功', 'status' => 1], 201);
        }
        return response()->json([ 'data' => $address, 'info' => '修改失败', 'status' => 0], 201);
    }
    /**
     * 删除地址
     * @param  Address $address [description]
     * @return [type]           [description]
     */
    public function addressDelete(Address $address)
    {
        if (Address::where('user_id', 1)->delete()) {
            return response()->json([ 'data' => $address, 'info' => '删除成功', 'status' => 1], 201);
        }
        return response()->json([ 'data' => $address, 'info' => '删除失败', 'status' => 0], 201);
    }

    /**
     * 积分明细
     * @return [type] [description]
     */
    public function integral()
    {
        $integrals = Integral::where('user_id', 1)->orderby('id', 'desc')->get()->toArray();
        return response()->json([ 'data' => $integrals, 'info' => '', 'status' => 1], 201);
    }
    /**
     * 余额明细
     * @return [type]
     */
    public function balance()
    {
        $balances = Balance::where('user_id', 1)->orderby('id', 'desc')->get()->toArray();
        return response()->json([ 'data' => $balances, 'info' => '', 'status' => 1], 201);
    }
}
