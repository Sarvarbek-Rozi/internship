<?php


namespace App\Services\Api;
use App\Models\Roles;
use App\Models\Doctor;
use App\Repositories\Api\DoctorRepository;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;

class DoctorService
{

    private $repository;

    public function __construct()
    {
        $this->repository = new DoctorRepository();
    }

    public function getAll(Request $request)
    {
//        $user = $this->repository->getAuth();

        $doctors = $this->repository->getQuery()
            ->with('region','city','disease','user');



        if (!empty($request->all()['region_id'])){
            $doctors->where(['region_id' => $request->all()['region_id']]);
        }
        if (!empty($request->all()['city_id'])){
            $doctors->where(['city_id' => $request->all()['city_id']]);
        }
        if (!empty($request->all()['disease_id'])){
            $doctors->where(['disease_id' => $request->all()['disease_id']]);
        }
        if (!empty($request->all()['name'])){
            $doctors->where('doctors.name', 'like', '%'. $request->all()['name'].'%');
        }
        if (!empty($request->all()['email'])){
            $doctors->where('doctors.email', 'like', '%'. $request->all()['email'].'%');
        }
//        $doctors = app(Pipeline::class)
//            ->send($this->repository->getQuery())
//            ->thenReturn()
//            ->with('region','city','disease')
//            ->select([
//                'doctors.name',
//                'doctors.role_id',
//                'doctors.email',
//                'doctors.password',
//                'doctors.region_id',
//                'doctors.city_id',
//                'doctors.disease_id',
//                'doctors.description'
//            ]);
//        dd($doctors);
//        return $doctors;

        if ($request->get('getAll')) {
            return $doctors->get();
        }

        return $doctors->paginate(10);
    }

    public function store($request)
    {
        $validator = $this->repository->toValidate($request->all());
        $msg = "";
        if (!$validator->fails()) {
            $citizen = $this->repository->store($request);
            return response()->json($citizen);
        } else {
            $errors = $validator->failed();
//                dd($errors);
            if (!empty($errors)) {
                $msg = "Foydalanuvchi yaratilmadi";
            }
            return response()->json($msg, 400);
        }
    }

        public function show($id)
    {
//        $user = Auth::user();
        $query = Doctor::query();
        $query->where(['id' => $id])
            ->with('region:id,name_uz')
            ->with('city')
            ->with('disease:id,name')
            ->with('user:id,name,email,password');

        if (empty($query->first())) {
            return response()->errorJson('Бундай ид ли фойдаланувчи мавжуд емас', 409);
        }
        else {
            return $query->first();
        }

    }
    public function update($request, $id){
        $msg = "";
        $validator = $this->repository->toValidate($request->all());

        if (!$validator->fails()) {
            $doctor = $this->repository->update($request, $id);
            $result =  ['status' => 200, 'doctor' => $doctor];
        } else {
            $errors = $validator->failed();
            if(empty($errors)) {
                $msg = "Соҳалар нотўғри киритилди";
            }
            $result = ['msg' => $msg, 'status' => 422, 'error' => $errors];
        }

        if($result['status'] == 409) {
            return response()->errorJson($result['msg'], 200, [], [], 'db');
        }
        if($result['status'] == 422) {
            return response()->errorJson($result['msg'], 200, $result['error'], [], 'db');
        }
        return response()->successJson($result['doctor']);
    }
    public function destroy($id){
        $doctor = $this->repository->getById($id);
        $user = $this->repository->getById($id);
        if ($doctor) {
            $doctor->delete();
            $this->response['success'] = true;
        }
        if ($user){
            $user->delete();
            $this->response['success'] = true;
        }

        else {
            $this->response['success'] = false;
            $this->response['error'] = "Doctor not found";
        }
        return response()->json($this->response);
    }
}
