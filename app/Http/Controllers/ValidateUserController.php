<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Postmark\PostmarkClient;
use Tymon\JWTAuth\Facades\JWTAuth;

class ValidateUserController extends Controller
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

    public function handle(Request $request) {

        try{
            if(!$user = User::where('uuid', $request->get('uuid'))->first())
                return response()->json(['message'=>'Invalid Email!'], 404);


            if (!$userToken = JWTAuth::fromUser($user)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }

            return response()->json([ 'message' => 'Valid User!', 'name' => $user->name, 'email'=>$user->email, 'bearer_token'=>$userToken ]);
        }
        catch(\Exception $e){
            return $e->getMessage();
        }
    }

}
