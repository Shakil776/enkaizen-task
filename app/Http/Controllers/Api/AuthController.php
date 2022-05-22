<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use JWTAuth;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // login
    public function login(Request $request) 
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required'
        ]);

        // send validate message
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 200);
        }

        // if (Auth::check()){
        //     $user = User::find(Auth::user()->id);
        // }
        
        // // check password
        // if (!Hash::check($request->password, $user->password)) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Invalid Credentials!'
        //     ], 401);
        // }

        try {
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized Users.'
                ], 401);
            }

            return $this->respondWithToken($token);
            
        } catch (JWTException $e) {
            
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);
        }
    }

    protected function respondWithToken($token) 
    {
        $user = User::select('id', 'name', 'email', 'mobile', 'profile_image')->where('id', Auth::guard('api')->id())->first();

        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 200);
    }
}
