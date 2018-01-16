<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded;
    protected $hidden = ['created_at', 'updated_at'];

    public function shelf()
    {
        return $this->belongsTo(Shelf::class);
    }
}
