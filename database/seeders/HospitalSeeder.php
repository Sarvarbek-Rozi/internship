<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hospital::create([
            'name' => 'AKFA MEDLINE MChJ',
            'region_id' => 17,
            'city_id' => 201,
            'tin' => 3423123123123,
            'director_id'=>1,
        ]);
    }
}
