<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class   UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user= User::create([
            'name' => 'Sarvarbek Ro`zimurodov',
            'role_id' => 1,
            'email' => 'srozimurodov1203@gmail.com',
            'password'=>Hash::make('sarvar1203'),
        ]);
//            $user->role()->attach([1]);

        $user2 = User::create([
            'name' => 'Dilshodbek Ro`zimurodov',
            'role_id' => 2,
            'email' => 'srozimurodov12@gmail.com',
            'password'=>Hash::make('sarvar1203'),
        ]);
//        $user2->role()->attach([2]);

    }
}
