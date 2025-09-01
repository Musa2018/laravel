<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Farmer extends Model
{
    use HasFactory;

    // تحديد الجدول (اختياري إذا الاسم farmers)
    protected $table = 'farmers';

    // الحقول المسموح بالتعبئة
    protected $fillable = [
        'name_en',
        'name_ar',
        'birthdate',
        'phone',
        'identity',
        'identity_type_id',
        'address',
        'gender_id',
        'governorate_id',       // إذا عندك جدول genders
        'locality_id',  // إذا عندك جدول nationalities
        'created_by',
    ];

    // إذا بدك تخفي أعمدة معينة من الـ JSON
    protected $hidden = [
        // 'created_at', 'updated_at'
    ];

    // تحويل أنواع الحقول تلقائيًا
    protected $casts = [

    ];

    // العلاقات (Relations)

    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }
    public function locality()
    {
        return $this->belongsTo(Locality::class, 'locality_id');
    }
    public function gender(){
        return $this->belongsTo(Gender::class, 'gender_id');
    }

   public  function identityType()
   {
    return $this->belongsTo(IdentityType::class, 'identity_type_id');
   }
}
