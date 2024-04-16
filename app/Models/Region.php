<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $fillable =[
        'name_uz',
        'name_ru',
        'name_en',
        'name_cyrl',
        'soato'
    ];
    public function doctor() {
        return $this->hasMany('App\Models\Doctor');
    }
}
