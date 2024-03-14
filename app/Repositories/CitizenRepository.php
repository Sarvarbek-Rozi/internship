<?php

namespace App\Repositories;
use App\Models\Citizen;
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
            'pin' =>  $request->pin,
            'gender' =>  $request->gender,
            'birth_date' =>  $request->birth_date,
            'region_id'=>$request->region_id,
            'city_id'=>$request->city_id,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'doctor_user_id'=>$request->doctor_user_id,
            'disease_id'=>$request->disease_id
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
            'first_name' => 'required',
            'last_name' =>  'required',
            'patronymic' =>  'required',
            'passport' =>  'required',
            'pin' =>  'required',
            'gender' => 'required',
            'birth_date' =>  'required',
            'region_id'=>'required',
            'city_id'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'doctor_user_id'=>'required',
            'disease_id'=>'required'
        ];

        $validator = Validator::make($array, $rules);

        return $validator;
    }

    public function update($request, $id)
    {
        $citizen = $this->getById($id);
        $citizen->update([
            'first_name' => $request->first_name,
            'last_name' =>  $request->last_name,
            'patronymic' =>  $request->patronymic,
            'passport' =>  $request->passport,
            'pin' =>  $request->pin,
            'gender' =>  $request->gender,
            'birth_date' =>  $request->birth_date,
            'region_id'=>$request->region_id,
            'city_id'=>$request->city_id,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'doctor_user_id'=>$request->doctor_user_id,
            'disease_id'=>$request->disease_id
        ]);

        if (isset($request->permissions)) {
            $citizen->perms()->sync($request->permissions);
        }


        return $citizen;
    }


}
