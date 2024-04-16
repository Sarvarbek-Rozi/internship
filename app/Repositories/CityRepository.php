<?php


namespace App\Repositories;


use App\Models\City;

class CityRepository extends BaseRepository
{
    public function __construct(City $entity)
    {
        $this->entity = $entity;
    }

}
