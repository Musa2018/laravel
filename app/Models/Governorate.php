<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',

    ];
    public function Users()
    {
        return $this->hasMany(User::class);
    }
    public function Farmers(){
        return $this->hasMany(Farmer::class);
    }

    public function locality()
    {
        return $this->belongsTo(Locality::class, 'locality_id');
    }
}
