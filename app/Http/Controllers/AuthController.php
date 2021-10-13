<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function register(Request $request) : JsonResponse
    {
        //validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users'
        ]);

        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }

    }


    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function login(Request $request) : JsonResponse
    {
        try{
            if(!$user = User::where('email', $request->get('email'))->first())
                return response()->json(['message'=>'Invalid Email!'], 404);

            return response()->json([ 'message' => 'Valid User!', 'uuid' => $user->uuid, 'name' => $user->name]);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

//    /**
//     * Get a JWT via given credentials.
//     *
//     * @param  Request  $request
//     * @return JsonResponse
//     */
//    public function login(Request $request) : JsonResponse
//    {
//        //validate incoming request
//        $this->validate($request, [
//            'email' => 'required|string',
//            'name'  => 'required|string',
//        ]);
//
//        $credentials = $request->only(['email', 'password']);
//
//        if (! $token = Auth::attempt($credentials)) {
//            return response()->json(['message' => 'Unauthorized'], 401);
//        }
//
//        return $this->respondWithToken($token);
//    }

}
