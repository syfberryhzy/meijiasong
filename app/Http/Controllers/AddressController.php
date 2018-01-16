<?php

namespace App\Http\Controllers;

use App\Policies\ConfigPolicy;
use Illuminate\Http\Request;
use App\Models\Address;

// use App\Http\Requests\AddressFormRequest;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * 地址列
     * @return [type] [description]
     */
    public function index()
    {
        $address = auth()->user()->address;
        return response()->json(['data' => $address, 'info' => '操作完成', 'status' => 1], 201);
    }

    // $address = Address::where('user_id', 1)->where('is_default', 1)->first();

    /**
     * 地址详情
     * @param  Address $address [description]
     * @return [type]           [description]
     */
    public function show(Address $address)
    {
        return response()->json(['data' => $address, 'info' => '操作完成', 'status' => 1], 201);
    }

    /**
     * 添加地址
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function create(Request $request)
    {
        $data = [
            'user_id' => auth()->id(),
            'receiver' => $request->receiver,
            'phone' => $request->phone,
            'areas' => $request->areas,
            'details' => $request->details,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ];

        if ($address = Address::create($data)) {
            return response()->json(['data' => $address, 'info' => '添加成功', 'status' => 1], 201);
        }
        return response()->json(['data' => [], 'info' => '添加失败', 'status' => 0], 403);
    }

    /**
     * 地址编辑
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update(Request $request, Address $address)
    {
        if ($request->receiver) {
            $address->receiver = $request->receiver;
        }
        if ($request->phone) {
            $address->phone = $request->phone;
        }
        if ($request->areas) {
            $address->areas = $request->areas;
        }
        if ($request->details) {
            $address->details = $request->details;
        }
        if ($request->is_default) {
            $address->is_default = $request->is_default;
        }
        if ($address->save()) {
            if ($address->is_default == 1) {
                Address::where('user_id', auth()->id())->where('id', '<>', $address->id)->update(['is_default' => 0]);
            }
            return response()->json(['data' => $address, 'info' => '修改成功', 'status' => 1], 201);
        }
        return response()->json(['data' => $address, 'info' => '修改失败', 'status' => 0], 201);
    }

    /**
     * 删除地址
     * @param  Address $address [description]
     * @return [type]           [description]
     */
    public function delete(Address $address)
    {
        if ($address->delete()) {
            return response()->json(['data' => [], 'info' => '删除成功', 'status' => 1], 201);
        }
        return response()->json(['data' => $address, 'info' => '删除失败', 'status' => 0], 201);
    }

    public function default()
    {
        $address = auth()->user()->defaultAddress();
        $configPolicy = new ConfigPolicy();
        $address = $configPolicy->defaultAddress($address);
        return response()->json(['data' => $address, 'info' => '', 'status' => 1], 201);
    }
}
