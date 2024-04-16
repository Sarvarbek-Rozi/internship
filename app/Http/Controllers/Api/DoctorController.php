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
        $doctors = $this->service->getAll($request);

        return response()->successJson(['doctors' => $doctors]);

    }
    public function store(Request $request)
    {
        return $this->service->store($request);
    }
    public function show($id)
    {
        $doctor = $this->service->show($id);
        $this->response['result'] = [
            'doctor' =>  $doctor
        ];
        return response()->json($this->response);
    }
    public function update(Request $request, $id)
    {
        return $this->service->update($request, $id);

    }

    public function destroy($id)
    {
        return $this->service->destroy($id);

    }
}
