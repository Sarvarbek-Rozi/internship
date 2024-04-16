<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use \App\Models\Region;
class Application extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'applications';

    protected $fillable = ['first_name','diseases_id', 'number','code','status',
        'phone','last_name', 'patronymic', 'birth_date', 'region_id', 'city_id', 'doctor_user_id','address', 'password',
        'passport', 'tin', 'created_at', 'updated_at','deny_reason'];

    const NEW_USER = 0;
    const CONFIRMED = 1;
    const REJECTED = 3;

    public static function rules()
    {
        return [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'patronymic' => 'string|required',
            'phone' => 'string|required',
            'birth_date' => 'required',
            'region_id' => 'integer|required',
            'city_id' => 'integer|nullable',
            'address' => 'string|required',
            'doctor_user_id' =>'string|required',
            'passport' => 'string|required',
            'tin' => 'integer|required',
            'diseases_id' => 'integer|required',
            'remember_token' => 'string|nullable',
            'created_at' => 'datetime|nullable',
            'updated_at' => 'datetime|nullable',
        ];
    }
    public function setBirthDateAttribute($value)
    {
        if (strpos($value, '.')) {
            $b_date = explode(".", $value);
            $value = $b_date[2] . "-" . $b_date[1] . "-" . $b_date[0];
        }
        $this->attributes['birth_date'] = $value;
    }

    public function getBirthDateAttribute(){
        return date('d.m.Y', strtotime($this->attributes['birth_date']));
    }

    public function setPassportAttribute($value)
    {
        $this->attributes['passport']  = str_replace(' ','', $value);
    }

    public function setCodeAttribute(){
        $this->attributes['code'] = mt_rand(10000,99999);
    }
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function diseases()
    {
        return $this->belongsTo(Disease::class);
    }
}
