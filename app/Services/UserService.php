<?php

namespace App\Services;

use App\Models\Disease;
use App\Models\User;
use App\Repositories\DiseaseRepository;
use App\Repositories\UserRepository;

class UserService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function getAll(){
        return User::all();
    }

}
