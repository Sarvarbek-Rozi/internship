<?php
namespace App\Http\Controllers\Api;
use App\Repositories\CitizenRepository;
use App\Services\CitizenService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class CitizenController extends Controller
{
    private $service;
    private $repo;
    protected $response;
//    const RESOURCE_URL_MVD = 'https://resource1.mehnat.uz/services';

    public function __construct()
    {
        $this->service = new CitizenService();
        $this->repo = new CitizenRepository();

//        $this->middleware('permission:faqs.index')->only(['index']);
        $this->middleware('permission:citizens.create')->only(['store']);
        $this->middleware('permission:citizens.show')->only(['show']);
        $this->middleware('permission:citizens.update')->only(['update']);
        $this->middleware('permission:citizens.delete')->only(['destroy']);
    }
    public function index(Request $request)
    {
        $citizens = $this->service->getAll($request);
        return response(['citizen' => $citizens]);
    }

    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    public function show($id)
    {
        $citizens = $this->service->show($id);
        $this->response['result'] = [
            ' citizen' =>  $citizens
        ];
        return response()->json($this->response);
    }

    public function update(Request $request, $id)
    {
        $result = $this->service->update($request, $id);
        if($result['status'] == 409) {
            return response()->errorJson($result['msg'], 200, [], [], 'db');
        }
        if($result['status'] == 422) {
            return response()->errorJson($result['msg'], 200, $result['error'], [], 'db');
        }
        return response()->successJson($result);
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
