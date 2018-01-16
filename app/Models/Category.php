<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const RECHARGE_ID = 1;
    const ON = 1;
    const OFF = 0;
    protected $hidden = ['created_at', 'updated_at'];

    public function shelf()
    {
        return $this->hasMany(Shelf::class);
    }
}
