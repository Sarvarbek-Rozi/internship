<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth:api', ['except' => ['email']]);
        $this->response = [
            'success' => true,
            'result' => [],
            'error' => []
        ];
    }


    public function login()
    {
//        dd('kelli');
        $credentials = request(['email', 'password']);
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $this->response['success'] = true;
        $this->response['result'] = $this->withToken($token);
        return response()->json($this->response);
    }
    protected function withToken($token)
    {
        $user = Auth::user();

        return [
            'access_token' => $token,
            'user' => $user,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ];
    }
    protected function withUser()
    {
        $user = Auth::user();

        return [
            'user' => $user,
        ];
    }


    public function me(): \Illuminate\Http\JsonResponse
    {

        $user = Auth::user();
        $user->region;
        $user->city;
        $user->roles;
        $user = ['user' => $user];
        $this->response['result'] = $user;
        return response()->json($this->response);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $guard = 'api';
        auth()->logout();
        Auth::guard($guard)->logout();
        return response()->json($this->response);
    }


    public function refresh(): \Illuminate\Http\JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }


    protected function respondWithToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
