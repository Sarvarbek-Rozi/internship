<?php

namespace App\Services\Api;

use App\Models\Application;
use App\Models\Citizen;
use App\Models\Roles;
use App\Repositories\Api\ApplicationRepository;
use App\Repositories\Api\CitizenRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new ApplicationRepository();
    }

    public function getAll(Request $request)
    {

//        $user = $this->repository->getAuth();
        $query = $this->repository->getQuery();
        $user = auth()->user();
        $role = $user->role()->first();


        if ($role && $role->name == 'doktor') {
            $query->where(['doctor_user_id' => $user->id]);
        }
        if (!empty($request->all()['status'])){
            $query->where(['status' => $request->all()['status']]);
        }
        else{
            $query->where(['status' => 0]);
        }
        if (!empty($request->all()['last_name'])){
            $query->where('applications.last_name', 'like', '%'. $request->all()['last_name'].'%');
        }
        if (!empty($request->all()['first_name'])){
            $query->where('applications.first_name', 'like', '%'. $request->all()['first_name'].'%');
        }
        if (!empty($request->all()['patronymic'])){
            $query->where('applications.patronymic', 'like', '%'. $request->all()['patronymic'].'%');
        }
        if (!empty($request->all()['passport'])){
            $query->where('applications.passport', 'like', '%'. $request->all()['passport'].'%');
        }
        $query->with('region');
        $query->with('city');
        $query->with('diseases');
        return $query->paginate(30);

//        return [
//            'current_page' => $request->page ?? 1,
//            'per_page' => $request->limit,
//            'data' =>$query->get(),
//            'total' => $query->count() < $request->limit ? $query->count() : -1
//        ];


    }

    public function update($request,$id){

        $msg = "";
        $validator = $this->repository->toValidate($request->all());
        if (!$validator->fails()) {

            $application = Application::query()->where('id',$id)->first();

            if ($application) {
                $result = $this->repository->update($request->all(),$id);
            } else {
                return response()->errorJson('Ushbu ariza bazada mavjud emas', 409);
            }

        } else {
            $errors = $validator->failed();
            if(empty($errors)) {
                $msg = "нотўғри киритилди";
            }
            $result = ['msg' => $msg, 'status' => 422, 'error' => $errors];
        }
        return response()->successJson($result);
    }

    public function getShow($id) {
        $application = Application::where(['id' => $id])
            ->with('region:id,name_uz')
            ->with('city')
            ->with('diseases')
            ->first();

        return response()->successJson(['application' => $application]);
    }

    public function checkStatusApplication($request)
    {
        $application = Application::query()
            ->where('number', $request['number'])
            ->where('code', $request['code'])
            ->withoutGlobalScopes()
            ->select('id','first_name','last_name','status',
                'deny_reason','region_id','city_id')
            ->first();
        if ($application) {
            $application->region;
            $application->city;
        }

        return $application;
    }

    public function getStore($request){

        return $this->repository->getStore($request);
    }



}
