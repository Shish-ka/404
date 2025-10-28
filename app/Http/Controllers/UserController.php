<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'login' => ['required', 'unique:users,login'],
            'password' => ['required', 'min:6'],
            'email' => ['required', 'email', 'unique:users,email'],
        ]);

        if($validated->fails()) {
            return $validated->errors();
        }

        $user = User::create([
            'login' => $request->login,
            'password' => $request->password,
            'email' => $request->email
        ]);

        Auth::login($user);
        $token = Auth::user()->createToken('api-token');

        return $token->plainTextToken;
    }

    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'login' => ['required'],
            'password' => ['required'],
        ]);

        if($validated->fails()) {
            return $validated->errors();
        }

        if(Auth::attempt($request->only('login', 'password'))) {
            Auth::user()->tokens()->delete();
            return Auth::user()->createToken('api-token')->plainTextToken;
        }
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
