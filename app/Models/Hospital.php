<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'region_id',
        'city_id',
        'tin',
        'director_id'
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
    public function region()
    {
        $this->belongsTo(Region::class);
    }
    public function city()
    {
        $this->belongsTo(City::class);
    }
}
