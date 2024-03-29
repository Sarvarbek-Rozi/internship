<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Api\DoctorRepository;
use App\Services\Api\DoctorService;
use Illuminate\Http\Request;
class DoctorController extends Controller
{
    private $service;
    private $repo;
    protected $response;

    public function __construct()
    {
        $this->service = new DoctorService();
        $this->repo = new DoctorRepository();

//        $this->middleware('permission:faqs.index')->only(['index']);
//        $this->middleware('permission:citizens.create')->only(['store']);
//        $this->middleware('permission:citizens.show')->only(['show']);
//        $this->middleware('permission:citizens.update')->only(['update']);
//        $this->middleware('permission:citizens.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $doctors = $this->service->getAll($request)->where('role_id',2)->get();

        return $doctors;
    }
    public function store(Request $request)
    {
        return $this->service->store($request);
    }
    public function show($id)
    {
        $doctors = $this->service->show($id);
        $this->response['result'] = [
            ' doctor' =>  $doctors
        ];
        return response()->json($this->response);
    }
    public function update(Request $request, $id)
    {
        $result = $this->service->update($request, $id);
        if($result['status'] == 409) {
            return response()->json($result['msg'], 200, [], [], 'db');
        }
        if($result['status'] == 422) {
            return response()->json($result['msg'], 200, $result['error'], [], 'db');
        }
        return response()->json($result);
    }

    public function destroy($id)
    {
        $citizen = $this->repo->getById($id);
        if ($citizen) {
            $citizen->delete();
            $this->response['success'] = true;
        } else {
            $this->response['success'] = false;
            $this->response['error'] = "Citizen not found";
        }
        return response()->json($this->response);
    }
}
