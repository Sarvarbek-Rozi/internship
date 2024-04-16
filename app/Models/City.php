<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'cities';

    protected $fillable =[
        'region_id',
        'name_uz',
        'name_ru',
        'name_en',
        'name_cyrl',
        'soato'
    ];
    public function region() {
        return $this->belongsTo('App\Models\Region', 'region_id');
    }

}
