<?php


namespace App\Services;

use App\Repositories\CitizenRepository;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Http\Request;

class CitizenService
{

    private $repository;

    public function __construct()
    {
        $this->repository = new CitizenRepository();
    }

    public function getAll(Request $request)
    {
        $citizens = app(Pipeline::class)
            ->send($this->repository->getQuery())
            ->thenReturn()
            ->with('category2')
            ->select([
                'citizens.id',
                'citizens.first_name',
                'citizens.last_name',
                'citizens.patronymic',
                'citizens.passport',
                'citizens.pin',
                'citizens.gender',
                'citizens.birth_date',
                'citizens.region_id',
                'citizens.city_id',
                'citizens.address',
                'citizens.phone',
                'citizens.doctor_user_id',
                'citizens.disease_id'
            ]);

        return $citizens;
    }

    public function store($request)
    {
        $validator = $this->repository->toValidate($request->all());
        $msg = "";
        if (!$validator->fails()) {
            $role = $this->repository->store($request);
            return response()->successJson(['role' => $role]);
        } else {
            $errors = $validator->failed();
            if (empty($errors)) {
                $msg = "Foydalanuvchi yaratilmadi";
            }
            return response()->errorJson($msg, 400, $errors);
        }
    }

    public function show($id)
    {
        return $this->repository->getById($id);
    }

    public function update($request, $id)
    {
        $msg = "";
        $validator = $this->repository->toValidate($request->all());

        if (!$validator->fails()) {
            $role = $this->repository->update($request, $id);
            return ['status' => 200, 'role' => $role];
        } else {
            $errors = $validator->failed();
            return ['msg' => $msg, 'status' => 422, 'error' => $errors];
        }
    }
}
