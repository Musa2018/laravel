<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentityType extends Model
{
    //
    protected $fillable = [
        'name_ar',
        'name_en',
    ];

    public function Farmers(){
        return $this->hasMany(Farmer::class);
    }
}
