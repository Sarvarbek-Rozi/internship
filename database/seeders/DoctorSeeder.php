<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctor= Doctor::create([
            'user_id'=>1,
            "region_id"=>13,
            "city_id"=>86,
            "hospital_id"=>1,
            "disease_id"=>4,
            "description"=>"Lorem Ipsum is simply dummy text of the printing and typesetting industry."
        ]);

        $doctor2= Doctor::create([
            'user_id'=>2,
            "region_id"=>11,
            "city_id"=>60,
            "hospital_id"=>1,
            "disease_id"=>6,
            "description"=>"Lorem Ipsum is simply dummy text of the printing and typesetting industry."
        ]);
    }
}
