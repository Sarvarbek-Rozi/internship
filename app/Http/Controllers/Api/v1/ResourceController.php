<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SmsController;
use App\Models\PhoneCode;
use App\Models\Region;
use App\Models\User;
use App\Services\CityService;
use App\Services\DiseaseService;
use App\Services\RegionService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResourceController extends Controller
{
    private $userService;
    private $regionService;
    private $cityService;

    private $diseaseService;

    public function __construct(RegionService $regionService, CityService $cityService, DiseaseService $diseaseService,UserService $userService)
    {
        $this->userService = $userService;
        $this->regionService = $regionService;
        $this->cityService = $cityService;
        $this->diseaseService = $diseaseService;

    }
    public function users(User $user)
    {
        $users = $this->userService->getAll();
        return response()->successJson(['users' => $users]);
    }
    public function regions(Region $region)
    {
        $regions = $this->regionService->getAll();
        return response()->successJson(['regions' => $regions]);
    }

    public function cities(Request $request)
    {

        $cities = $this->cityService->getQuery();
        if (!empty($request->all()['region_id'])) {
            $cities->where('region_id', $request->all()['region_id']);
        }

        $cities = $cities->get();
        return response()->successJson(['cities' => $cities]);
    }
 public function diseases(DiseaseService $diseases)
 {
     $diseases= $this->diseaseService->getAll();
     return response()->successJson(['diseases' => $diseases]);
 }
    public function getCode($phone = null)
    {
        $code = rand(11111, 99999);
        PhoneCode::updateOrCreate(['phone' => $phone],['code' => $code]);
        $message = 'Ushbu kod sizga bazani test qilish uchun yuborildi: ' . $code;

        $details = SmsController::send($phone, $message);


        if (!$details['result']['success']) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => "Смс жунатилмади"
            ], 200);
        } else {
            return response()->json([
                "success" => true,
                "data" => ['code' => $code],
                "message" => "SMS created and sent successfully"
            ], 200);
        }
    }
    public function confirmSms(Request $request)
    {
        $attibutes = $request->all();

        $validator = Validator::make($attibutes, [
            'phone' => 'required',
            'code' => 'required|max:5'
        ]);

        if ($validator->fails()) {
            return response()->errorJson('Code does not match', 422);
        }
        $phone_code = PhoneCode::where(['phone' => $attibutes['phone'], 'code' => $attibutes['code']])->first();

        if($phone_code) {
            $phone_code->delete();
            return response()->successJson('Success!, Code match');
        } else {
            return response()->errorJson('Code does not match',422);
        }
    }

}
