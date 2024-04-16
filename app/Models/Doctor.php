<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $table = 'doctors';

    protected $fillable =[
        'id',
        'name',
        'email',
        'password',
        'region_id',
        'city_id',
        'user_id',
        'disease_id',
        'description',
        'hospital_id'
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function region()
    {
        return $this->belongsTo('App\Models\Region','region_id');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\City','city_id');
    }
   public function disease()
    {
        return $this->belongsTo('App\Models\Disease','disease_id');
    }
}
