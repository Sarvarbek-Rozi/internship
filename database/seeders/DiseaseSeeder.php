<?php

namespace Database\Seeders;

use App\Models\Disease;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diseases = [
            ['id' => '1' ,'name' => "Giyoxvandlikka ruju qoʼygan"],
            ['id' => '2' ,'name' => "Ichkilikka ruju qoʼygan"],
            ['id' => '3' ,'name' => "Ruxiy kasallik"],
            ['id' => '4' ,'name' => "Koronavirus bilan bogʼlik"],
            ['id' => '5' ,'name' => "Oʼtkir yurak yetishmovchiligi"],
            ['id' => '6' ,'name' => "Yuqumli kasallik"],
            ['id' => '7' ,'name' => "Endokrin"],
            ['id' => '8' ,'name' => "Semizlik"],
            ['id' => '9' ,'name' => "Parazitar"],
            ['id' => '10' ,'name' => "Jinsiy"],
            ['id' => '11' ,'name' => "Qon kasalliklari"],
            ['id' => '12' ,'name' => "Asab tizimi"],
            ['id' => '13' ,'name' => "OIV va OITS"],
            ['id' => '14' ,'name' => "Infektsion"],
            ['id' => '15' ,'name' => "Boshqa turli"],


        ];
        DB::table('diseases')->insert($diseases);
    }
}
