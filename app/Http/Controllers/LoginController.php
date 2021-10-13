<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Postmark\PostmarkClient;

class LoginController extends Controller
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
            if(!$user = User::where('email', $request->get('email'))->first())
                return response()->json(['message'=>'Invalid Email!'], 404);

            return response()->json([ 'message' => 'Valid User!', 'uuid' => $user->uuid, 'name' => $user->name]);
        }
        catch(\Exception $e){
            return $e->getMessage();
        }
    }

}
