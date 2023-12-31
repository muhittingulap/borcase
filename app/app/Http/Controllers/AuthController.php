<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // validation control
        $validator = Validator::make(
            [
                'email' => $request->email,
                'password' => $request->password,
            ],
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        if ($validator->fails()) {
            return $this->error('Warning', 401, [
                "errors" => $validator->errors()
            ]);
        }

        // user control
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error('Warning', 401, [
                "errors" => ["The provided credentials are incorrect."]
            ]);
        }

        // laravel login 
        if (Auth::login($user)) {
            $request->session()->regenerate();
        }

        // Same device deleted old token
        $user->tokens()->where('name', "api")->delete();
        $token = explode('|', $user->createToken("api")->plainTextToken)[1];

        return $this->success([
            "auth" => [
                "token" => $token,
            ],
            "detail" => [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
            ],
        ]);
    }

    public function me(Request $request)
    {
        if (!$request->bearerToken()) {
            return $this->error('Warning', 401, [
                "errors" => ["Bearer Token Not Found !"]
            ]);
        }

        return $this->success([
            "auth" => [
                "token" => $request->bearerToken(),
            ],
            "detail" => [
                "id" => $request->user()->id,
                "name" => $request->user()->name,
                "email" => $request->user()->email,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        if (!$request->bearerToken()) {
            return $this->error('Warning', 401, [
                "errors" => ["Bearer Token Not Found !"]
            ]);
        }
        $request->session()->flush();
        $request->user()->tokens()->delete();
        return $this->success([]);
    }
}
