<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Pay;
use App\Models\OrderItem;
use App\Models\Integral;
use App\Models\Balance;

class Order extends Model
{
    const ORDER_UNPAY = 1; //待支付

    const ORDER_UNRECEIVE = 2; //待确认
    const ORDER_UNRECEIVE_PEND = 21; //待接单 【接单/取消】
    const ORDER_UNRECEIVE_SEND = 22; //已接单，配送中

    const ORDER_CANCEL = 3; //已取消
    const ORDER_CANCEL_USER = 31; //用户取消
    const ORDER_CANCEL_ADMIN = 32; //后台取消
    const ORDER_CANCEL_ADMIN_REFUNDS = 33; //后台取消并退款

    const ORDER_FINISH = 4; //已完成
    const ORDER_FINISH_SEND = 41; //订单完成
    const ORDER_FINISH_CONFIRM = 42; //确认收货

    protected $guarded = [];
  
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pay()
    {
        return $this->belongsTo(Pay::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function integral()
    {
        return $this->hasMany(Integral::class);
    }

    public function balance()
    {
        return $this->hasOne(Balance::class);
    }

      /**
      *
      *
      * @param $query
      * @param $gender
      * @return mixed
      */
    public function scopeGender(Builder $query, $status)
    {
        if (!in_array($status, ['1', '2', '21', '22', '3', '31', '32', '4', '41', '42'])) {
             return $query;
        }

        return $query->where('status', 'like', $status.'%');
    }
}
