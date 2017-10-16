<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shelf;

class Product extends Model
{
    protected $hidden = ['created_at', 'updated_at', 'status'];
    public function shelf()
    {
        return $this->belongsTo(Shelf::class);
    }
}
