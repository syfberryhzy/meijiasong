<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class OrderItem extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        static::bootTraits();
        static::created(function ($query) {
            #销量自增
            $query->product->increment('sales', $query->number);
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
