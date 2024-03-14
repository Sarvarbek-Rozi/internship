<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class DoktorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctor = User::query()->where('role_id',2)->get();
        return $doctor;


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $createdoc = User::create([
                'name'=>$request->name,
                'role_id'=>2,
                'email'=>$request->email,
                'password'=>$request->password
            ]);
        return response('Doktor qo`shildi');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $doctor)
    {
        return $doctor;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $doctor)
    {
        $doctor->update([
            'name'=>$request->name,
            'role_id'=>2,
            'email'=>$request->email,
            'password'=>$request->password,
        ]);
        return ('Doktor ma`lumotlari yangilandi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $doctor)
    {
        $doctor->delete();
        return ($doctor['id'].' chi idlik doktor o`chirildi');
    }
}
