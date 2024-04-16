<?php

namespace App\Services;

use App\Models\Disease;
use App\Repositories\DiseaseRepository;

class DiseaseService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new DiseaseRepository();
    }

    public function getAll(){
        return Disease::all();
    }

}
