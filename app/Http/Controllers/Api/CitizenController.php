<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Repositories\Api\CitizenRepository;
use App\Services\Api\CitizenService;
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    private $service;
    private $repo;
    protected $response;

    public function __construct()
    {
        $this->service = new CitizenService();
        $this->repo = new CitizenRepository();

//        $this->middleware('permission:faqs.index')->only(['index']);
//        $this->middleware('permission:citizens.create')->only(['store']);
//        $this->middleware('permission:citizens.show')->only(['show']);
//        $this->middleware('permission:citizens.update')->only(['update']);
//        $this->middleware('permission:citizens.delete')->only(['destroy']);
    }
    public function index(Request $request)
    {
        $citizens = $this->service->getAll($request);

        return response()->successJson(['citizens' => $citizens]);
    }

    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    public function show($id)
    {
        $citizens = $this->service->show($id);
        $this->response['result'] = [
            'citizen' =>  $citizens
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
    public function  getPassport(Request $request){
        if(!empty($request->passport) && !empty($request->tin)) {
            $data = $this->service->getPassport($request->passport, $request->tin);

            $user = $this->repo->getAuth();
            $citizen = [
                'last_name' => $data['result'][0]['surname'],
                "first_name" => $data['result'][0]['name'],
                "patronymic" => $data['result'][0]['patronym'],
                "birth_date" => date('d.m.Y', strtotime($data['result'][0]['birth_date'])),
//                'region_id' => $user->region_id,
//                'city_id' => $user->id,
//                "address" => $data['result'][0]['birth_place'],
//                "passport" => $data['result'][0]['pnfl'],
                "id" => null
            ];

        }
        return response()->successJson(['citizen' => $citizen]);
}
}
