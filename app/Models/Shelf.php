<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Product;

class Shelf extends Model
{
    public $fillable = ['category_id', 'name', 'attributes', 'image', 'status'];
    protected $hidden = ['created_at', 'updated_at'];

    public function setImageAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['image'] = json_encode($pictures);
        } else {
            $this->attributes['image'] = $pictures;
        }
    }

    public function getImageAttribute($pictures)
    {
        if (is_array(json_decode($pictures, true))) {
            return json_decode($pictures, true);
        } else {
            return $pictures;
        }
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
