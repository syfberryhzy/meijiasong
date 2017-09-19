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
    #个人中心首页
    public function index()
    {
        $user = User::find(1);
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
        $user = User::find(1);
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
        $carbon = new Carbon();

        foreach ($balances as $key => $vo) {
            $dt = Carbon::parse($vo['created_at']);
            $balances[$key]['created_at'] = $dt->year . '-' . $dt->month . '-'. $dt->day;
        }
        $user_balance = '100.00';
        return response()->json([ 'data' => $balances, 'info' => '', 'status' => 1], 201);
    }
}
