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
            'pin',
            'gender',
            'birth_date',
            'region_id',
            'city_id',
            'address',
            'phone',
            'doctor_user_id',
            'disease_id',

        ];
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    public function city()
    {
        $this->belongsTo(City::class);
    }
    public function user()
    {
        $this->belongsTo(User::class);
    }
    public function disease()
    {
        $this->belongsTo(Disease::class);
    }
}
