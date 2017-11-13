<?php

namespace App\Models;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Integral;
use App\Models\Balance;
use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $guarded = [];

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function defaultAddress()
    {
        if ($this->isHasDefaultAddress()) {
            return $this->address()->where('is_default', 1)->first();
        }
        return $this->address()->first();
    }

    public function isHasDefaultAddress()
    {
        return $this->address()->where('is_default', 1)->exists();
    }

    public function address()
    {
        dd(123);
        return $this->hasMany(Address::class, 'user_id');
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function integrals()
    {
        return $this->hasMany(Integral::class);
    }

    public function balances()
    {
        return $this->hasMany(Balance::class);
    }

    /**
     * 设置默认的openid来获取token
     * @param  [type] $username [description]
     * @return [type]           [description]
     */
    public function findForPassport($username)
    {
        //        return \App\User::normal()
        return \App\Models\User::where('openid', $username)->first();
    }

    /**
     * 获取正常的用户
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public function scopeNormal(Builder $query)
    {
        return $query->where('status', self::STATUS_NORMAL);
    }

    /**
     * 判断密码是否等于设置的123456
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
    public function validateForPassportPasswordGrant($password)
    {
        return $password == 'huishuoit';
    }
}
