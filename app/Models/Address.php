<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['user_id', 'receiver', 'phone', 'areas', 'details', 'is_default', 'status'];

    public function setAreasAttribute($araes)
    {
        return $this->attributes['areas'] = implode(' ', $araes);
    }

    public function getAreasAttribute($araes)
    {
        return $this->attributes['areas'] = explode(' ', $araes);
    }
}
