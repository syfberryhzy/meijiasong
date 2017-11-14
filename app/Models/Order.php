<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Pay;
use App\Models\OrderItem;
use App\Models\Integral;
use App\Models\Balance;
use App\Models\AdminConfig;

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

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        static::bootTraits();

        static::created(function ($query) {
            $query->ifShopping();
            $query->ifRecharge();
        });
    }

    public function deduct()
    {
        if ($this->pay->isDeductible()) {
            $point = $this->discount * (AdminConfig::points());
            #添加抵扣记录
            $this->changeIntegral([
                'current' => $this->user->integral - $point,
                'desc' => '支付抵扣',
                'number' => $point,
                'type' => 2
            ]);
        }
    }

    public function reward()
    {
        if ($this->pay->isReward()) {
            $point = $this->total * ($this->pay->proportion);//奖励积分
            #添加奖励记录
            $this->changeIntegral([
                'current' => $this->user->integral + $point,
                'number' => $point,
                'desc' => '支付奖励',
                'type' => 1
            ]);
        }
    }

    public function changeIntegral($data)
    {
        $integral = [
            'before' => $this->user->integral,
            'user_id' => $this->user_id,
        ];
        $this->integral()->create(array_merge($integral, $data));
    }

    /**
     * 余额充值
     */
    public function addBalance()
    {
        $price = $this->items->first()->amount;
        $this->changeBalance([
            'current' => $this->user->balance + intval($price),
            'number' => intval($price),
            'desc' => '余额充值',
            'type' => 1
        ]);
    }
    /**
     * 余额支付扣除
     * @return [type] [description]
     */
    public function reduceBalance()
    {
        $this->changeBalance([
            'current' => $this->user->balance - $this->total,
            'number' => $this->total,
            'desc' => '支付扣除',
            'type' => 2
        ]);
    }

    public function changeBalance($data)
    {
        $balance = [
            'before' => $this->user->balance,
            'user_id' => $this->user_id,
        ];
        $this->balance()->create(array_merge($balance, $data));
    }

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
        return $this->hasMany(Integral::class, 'order_id', 'id');
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

    public function ifShopping()
    {
        if ($this->type == 2 && $this->status == 21) {
            $this->deduct();//抵扣积分
            $this->reward();//奖励积分
            $this->pay_id == 1 && $this->reduceBalance();//扣除余额
        }
    }

    public function ifRecharge()
    {
        if ($this->type == 1 && $this->status == 41) {
            $this->addBalance();//添加余额
        }
    }
}
