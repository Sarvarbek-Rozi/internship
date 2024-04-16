<?php

namespace App\Repositories\Api;
use App\Models\Citizen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CitizenRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Citizen();
    }

    public function getQuery()
    {
        return $this->model->query();
    }
    public function getAuth(){
        return Auth::user();
    }
    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function store($request)
    {
        $citizen = $this->model->create([
            'first_name' => $request->first_name,
            'last_name' =>  $request->last_name,
            'patronymic' =>  $request->patronymic,
            'passport' =>  $request->passport,
            'tin' =>  $request->tin,
            'birth_date' =>  $request->birth_date,
            'region_id'=>$request->region_id,
            'city_id'=>$request->city_id,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'doctor_user_id'=>$request->doctor_user_id,
            'diseases_id'=>$request->diseases_id
        ]);

        if (isset($request->permissions))
        {
            $citizen->perms()->sync($request->permissions);
        }


        $data['citizen'] = $citizen;
        return $data;
    }

    public function toValidate($array, $status = null)
    {
        $rules = [
//            'first_name' => 'required', 'string', 'max:255',
//            'last_name' =>  'required', 'string', 'max:255',
//            'patronymic' =>  'required', 'string', 'max:255',
//            'passport' =>  'required|unique:citizens|min:9|max:9',
//            'tin' =>  'required|numeric|unique:citizens|digits:14',
//            'gender' => 'required|in:1,2',
//            'birth_date' =>  'required|date_format:Y-m-d',
//            'region_id'=>'required|exists:regions,id',
//            'city_id'=>'required|exists:cities,id',
//            'address'=>'required','string', 'max:255',
//            'phone'=>'required|string',
//            'doctor_user_id'=>'required|exists:users,id',
//            'disease_id'=>'required|exists:diseases,id'
            'first_name' => 'required', 'string', 'max:255',
            'last_name' =>  'required', 'string', 'max:255',
            'patronymic' =>  'required', 'string', 'max:255',
            'passport' =>  'required',
            'tin' =>  'required|numeric',
            'birth_date' =>  'required',
            'region_id'=>'required',
            'city_id'=>'required',
            'address'=>'required','string', 'max:255',
            'phone'=>'required|string',
            'doctor_user_id'=>'required',
            'diseases_id'=>'required'
        ];

        $validator = Validator::make($array, $rules);

        return $validator;
    }

    public function update($request, $id)
    {
        $citizen = Citizen::find($id);
        $citizen->update([
            'first_name' => $request->first_name,
            'last_name' =>  $request->last_name,
            'patronymic' =>  $request->patronymic,
            'passport' =>  $request->passport,
            'tin' =>  $request->tin,
            'birth_date' =>  $request->birth_date,
            'region_id'=>$request->region_id,
            'city_id'=>$request->city_id,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'diseases_id'=>$request->diseases_id
        ]);

        $citizenShow  = Citizen::query()->where('id',$citizen->id)->with('region','city','diseases')->first();
        $citizen->with('user');
        $data['citizen']=$citizenShow;

        return $data;
    }


}
