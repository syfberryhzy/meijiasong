<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shelf;

class Product extends Model
{
    public function shelf()
    {
        return $this->belongsTo(Shelf::class);
    }
}
