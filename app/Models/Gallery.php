<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public function setValueAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['value'] = json_encode($pictures);
        } else {
            $this->attributes['value'] = $pictures;
        }
    }

    public function getValueAttribute($pictures)
    {
        if (is_array(json_decode($pictures, true))) {
            return json_decode($pictures, true);
        } else {
            return $pictures;
        }
    }
}
