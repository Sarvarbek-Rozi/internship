<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'id' => 1,
            'name' => 'Director',
            'display_name' => 'Shifoxona Rahbari',
            'description' => 'Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.',
            ]);
        Role::create([
            'id' => 2,
            'name' => 'doktor',
            'display_name' => 'Shifoxona Doktori',
            'description' => 'Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.',
        ]);
    }
}
