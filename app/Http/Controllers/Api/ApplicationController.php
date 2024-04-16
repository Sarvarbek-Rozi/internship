<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Repositories\Api\CitizenRepository;
use App\Services\Api\ApplicationService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    private $service;

    public function __construct()
    {
//        $this->middleware('logs', ['only' => ['show', 'passport', 'passportDataFromBase']]);
        $this->modelClass = new Application();
        $this->repo = new CitizenRepository;
        $this->service = new ApplicationService();
    }

    public function index(Request $request)
    {
        $applications = $this->service->getAll($request);

        return response()->successJson(['applications' => $applications]);
    }

    public function update(Request $request, $id)
    {
//        dd($request->all());
        return $this->service->update($request,$id);
    }
    public function confirmApp($id){
        return $this->service->getAll();
    }

    public function show($id){
        return $this->service->getShow($id);
    }

    public function store(Request $request)
    {

        return $this->service->getStore($request);
    }

    public function checkStatusApplication(Request $request)
    {
        $application = $this->service->checkStatusApplication($request->all());

        if($application) return response()->successJson(['application' => $application]);

        return response()->errorJson('Application not found', 404);
    }
}
