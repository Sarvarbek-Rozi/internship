<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable =[
        'region_id',
        'name_uz',
        'name_ru',
        'name_en',
        'name_cyrl',
        'soato'
    ];
}
