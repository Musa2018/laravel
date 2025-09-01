<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    //
    protected $fillable = [
        'gender_en',
        'gender_ar',
    ];

    public function Farmers(){
        return $this->hasMany(Farmer::class);
    }
}
