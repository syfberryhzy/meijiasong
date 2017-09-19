<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Pay extends Model
{
    const PAY_YUE_ID = 1;
    const PAY_WEIXIN_ID = 2;
    const PAY_DAOFU_ID = 3;

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
