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
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    #个人中心首页
    public function index()
    {
        $user = auth()->user();
        return response()->json([ 'data' => $user, 'info' => '操作完成', 'status' => 1], 201);
    }

    /**
     * 个人详情
     * @return [type] [description]
     */
    // public function show(User $user)
    // {
    //     return response()->json([ 'data' => $user, 'info' => '操作完成', 'status' => 1], 201);
    // }

    /**
     * 个人编辑
     * @param  Request $request [description]
     * @param  User    $user    [description]
     * @return [type]           [description]
     */
    public function update(Request $request)
    {
        $user = \Auth::user();
        if ($request->avatar) {
            $user->avatar = $request->avatar;
        }

        if ($request->name) {
            $user->name = $request->name;
        }

        if ($request->gender) {
            $user->gender = $request->gender;
        }

        if ($user->save()) {
            // $user = User::find(1);
            return response()->json([ 'data' => $user, 'info' => '修改完成', 'status' => 1], 201);
        }
        return response()->json([ 'data' => $user, 'info' => '修改失败', 'status' => 0], 201);
    }

    /**
     * 积分明细
     * @return [type] [description]
     */
    public function integral()
    {
        $user = auth()->user();
        $integrals = $user->integrals()->latest()->get();
        $user_integral = number_format($user->integral, 2);
        return response()->json([ 'data' => $integrals, 'info' => '', 'status' => 1, 'integral' => $user_integral], 201);
    }
    /**
     * 余额明细
     * @return [type]
     */
    public function balance()
    {
        $user = auth()->user();
        $balances = $user->balances()->latest()->get();
        $user_balance = number_format($user->balance, 2);
        return response()->json([ 'data' => $balances, 'info' => '', 'status' => 1, 'balance' => $user_balance], 201);
    }
}
