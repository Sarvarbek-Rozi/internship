<?php

namespace App\Repositories\Api;

use App\Models\Application;
use App\Models\Citizen;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApplicationRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Application();
    }

    public function getQuery()
    {
        return $this->model->query();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function getAuth(){
        return Auth::user();
    }
    public function toValidate($array)
    {
        $rules = [
            'status' => 'required|in:1,2',
            'deny_reason' => 'required_if:status,2',

        ];

        $validator = Validator::make($array, $rules);

        return $validator;
    }
    public function update($params,$id){


        $application = Application::query()->where(['id' => $id])->first();
        $application->update([
           'status' => $params['status'],
            'deny_reason' => $params['deny_reason']
        ]);

        $birth_date = date('d.m.Y', strtotime($application->birth_date));
        if ($application->status == 1) {
            Citizen::create([
                'first_name' => $application->first_name,
                'last_name' => $application->last_name,
                'patronymic' => $application->patronymic,
                'birth_date' => Carbon::parse($birth_date)->format('Y-m-d'),
                'region_id' => $application->region_id,
                'city_id' => $application->city_id,
                'address' => $application->address,
                'phone' => $application->phone,
                'doctor_user_id' => $application->doctor_user_id,
                'passport' => $application->passport,
                'tin' => $application->tin,
                'diseases_id' => $application->diseases_id,
                'created_at' => Carbon::now()->format('Y-m-d'),
            ]);
        }

        return response()->successJson('Ariza muvaffaqiyatli yaratildi');
    }

    public function getStore($request){
        $application = Application::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'patronymic' => $request->patronymic,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'region_id' => $request->region_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'doctor_user_id' => $request->doctor_user_id,
            'passport' => $request->passport,
            'tin' => $request->tin,
            'diseases_id' => $request->diseases_id,
            'number' => 0,
            'code' => $request->code,
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);

        $application->update([
            'number' => str_pad($application->id, 6, "0", STR_PAD_LEFT),
        ]);

        return response()->successJson(['citizen' => $application]);
    }

}
