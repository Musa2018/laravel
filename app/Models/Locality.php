<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locality extends Model
{
    //

    protected $fillable = [
        'name_ar',
        'name_en',
        'governorate_id',
    ];

    public function Farmers(){
        return $this->hasMany(Farmer::class);
    }
    public function governorate()
    {
        return $this->hasMany(Governorate::class, 'governorate_id');
    }
}
