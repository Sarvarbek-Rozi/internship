<?php
namespace App\Repositories\Api;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DoctorRepository
{
    protected $model;
    protected $model2;


    public function __construct()
    {
        $this->model = new Doctor();
        $this->model2 = new User();
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
        return  $this->model2->find($id);

    }
    public function store($request)
    {
        $user = User::create([
            'name'=>$request->name,
            'role_id'=>2,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        $doctor = $this->model->create([
            'user_id' => $user->id,
            'region_id'=>$request->region_id,
            'city_id'=>$request->city_id,
            'disease_id'=>$request->disease_id,
            'description'=>$request->description,
            'hospital_id'=>$request->hospital_id

        ]);

        if (isset($request->permissions))
        {
            $doctor->perms()->sync($request->permissions);
        }


        $data['doctor'] = $doctor;
        return $data;
    }

    public function toValidate($array, $status = null)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
            'role_id'=>'required|in:2',
            'region_id'=>'required',
            'city_id'=>'required',
            'disease_id'=>'required',
            'hospital_id' => 'required',
            'description'=>['required', 'string', 'max:255'],
        ];

        $validator = Validator::make($array, $rules);

        return $validator;
    }

    public function update($request, $id)
    {
//        $user = $this->guard()->user();
        $doctor  = Doctor::find($id);
        $user = User::find($id);
        $user ->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'role_id'=>2,

        ]);

//        $citizen = $this->getById($id);
        $doctor->update([
            'region_id'=>$request->region_id,
            'city_id'=>$request->city_id,
            'disease_id'=>$request->disease_id,
            'description'=>$request->description,
            'hospital_id'=>$request->hospital_id
        ]);

        $doctorShow  = Doctor::query()->where('id',$doctor->id)->with('region','city','disease','user')->first();
        $doctor->with('user');
        $data['doctor']=$doctorShow;

        return $data;
    }
}
