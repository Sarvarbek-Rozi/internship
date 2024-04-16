<?php


namespace App\Services\Api;

use App\Models\Citizen;
use App\Models\Roles;
use App\Repositories\Api\CitizenRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;

class CitizenService
{
    const RESOURCE_URL = 'https://resource1.mehnat.uz/services';

    private $repository;

    public function __construct()
    {
        $this->repository = new CitizenRepository();
    }

    public function getAll(Request $request)
    {
        $query = $this->repository->getQuery();

        $query->with('region')
            ->with('city')
            ->with('diseases');

        $user = auth()->user();
        $role = $user->role()->first();
        if ($role && $role->name == 'doktor') {
            $query->where(['doctor_user_id' => $user->id]);
        }
        if (!empty($request->all()['region_id'])) {
            $query->where(['region_id' => $request->all()['region_id']]);
        }
        if (!empty($request->all()['city_id'])) {
            $query->where(['city_id' => $request->all()['city_id']]);
        }
        if (!empty($request->all()['diseases_id'])) {
            $query->where(['diseases_id' => $request->all()['diseases_id']]);
        }

        if (!empty($request->all()['last_name'])) {
            $query->where('citizens.last_name', 'like', '%' . $request->all()['last_name'] . '%');
        }
        if (!empty($request->all()['first_name'])) {
            $query->where('citizens.first_name', 'like', '%' . $request->all()['first_name'] . '%');
        }
        if (!empty($request->all()['patronymic'])) {
            $query->where('citizens.patronymic', 'like', '%' . $request->all()['patronymic'] . '%');
        }
        if (!empty($request->all()['passport'])) {
            $query->where('citizens.passport', 'like', '%' . $request->all()['passport'] . '%');
        }

        if ($request->get('getAll')) {
            return $query->get();
        }
        return $query->paginate(15);
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
            if (!empty($errors)) {
                $msg = "Foydalanuvchi yaratilmadi";
            }
            return response()->json($msg, 400);
        }
    }

    public function show($id)
    {
//        $user = Auth::user();
        $query = Citizen::query();
        $query->where(['id' => $id])
            ->with('region:id,name_uz')
            ->with('city')
            ->with('diseases:id,name');;

        if (empty($query->first())){
            return response()->errorJson('Бундай ид ли фойдаланувчи мавжуд емас', 409);
        }
        else{
            return $query->first();
        }

        }

    public function update($request, $id){
        $msg = "";
        $validator = $this->repository->toValidate($request->all());

        if (!$validator->fails()) {
            $citizen = $this->repository->update($request, $id);
            $result =  ['status' => 200, 'citizen' => $citizen];
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
        return response()->successJson($result['citizen']);
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
    public function getPassport($passport, $tin){
        $client = new Client(['verify' => false]);
        $data = [
            'version' => '1.0',
            'id' => 7436,
            'method' => 'fhdyo.birth',
            'params' => [
                'passport' => $passport,
                'pin' => $tin
            ]
        ];
        try {
            $response = $client->post(self::RESOURCE_URL, [
                'json' => $data
            ]);

            return json_decode((string)$response->getBody(), true);
        } catch (RequestException   $e) {
            return null;
        } catch (ConnectException    $e) {
            return null;
        }
    }
}
