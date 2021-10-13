<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function register(Request $request) : JsonResponse {

        if(User::where('email', $request->get('email'))->first())
            return response()->json(['message'=>'User with this Email already exists!'], 409);

        $user = User::create($request->only('email', 'name'));

        if(!$user)
            return response()->json(['message'=>'Please try again!'], 400);

        return response()->json(['message'=>'User registered successfully'], 201);

    }

}
