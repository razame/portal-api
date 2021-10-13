<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function details(Request $request)  {
        return $request->user();
    }

    public function changeEmail(Request $request)  {

        //validate incoming request
        $this->validate($request,
            [
                'old_email'     => 'required|email',
                'email'         => 'required|email|unique:users'
            ],
            [
                'old_email.required'    => 'Current Email is Required',
                'old_email.email'       => 'Current Email format is incorrect',

                'email.required'        => 'New Email is Required',
                'email.email'           => 'New Email format is incorrect',
            ]
        );

        $user = User::where('email', $request->get('old_email'))->first();

        if(!$user){
            return response()->json(['error' => 'Invalid Email'], 404);
        }

        if($user->update(['email'=>$request->get('email')]))
            return response()->json(['email' => $request->get('email')]);

        return response()->json(['error' => 'Something went wrong!'], 404);
    }

}
