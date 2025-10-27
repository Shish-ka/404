<?php

namespace App\Http\Controllers;

use App\Http\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }
}
