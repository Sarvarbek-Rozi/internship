<?php


namespace App\Services;


use App\Models\City;
use App\Repositories\CityRepository;

class CityService extends BaseService
{
    protected $filter_fields;

    public function __construct(CityRepository $repo)
    {
        $this->repo = $repo;
        $this->filter_fields = ['name' => ['type' => 'string'], 'username' => ['type' => 'string'], 'status' => ['type' => 'number']];
        $this->relation = [];
    }

    public function getQuery(){
        return City::query();
    }
}
