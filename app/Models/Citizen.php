<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    use HasFactory;
    protected $fillable=
        [
            'first_name',
            'last_name',
            'patronymic',
            'passport',
            'tin',
            'birth_date',
            'region_id',
            'city_id',
            'address',
            'phone',
            'doctor_user_id',
            'diseases_id',

        ];
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function diseases()
    {
        return $this->belongsTo(Disease::class);
    }
}
