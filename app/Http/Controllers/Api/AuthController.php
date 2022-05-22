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
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // send validate message
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 422);
        }

        // check user email exists or not
        $user = User::where('email', '=', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Credentials!'
            ], 422);
        }

        // check password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Credentials!'
            ], 422);
        }

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

    // register
    public function register(Request $request) 
    {

        $data = $request->all();

        //valid credential
        $validator = Validator::make($data, [
            'name' => 'string',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|min:11',
            'profile_image' => 'nullable|image|max:5000',
            'password' => 'required|string|min:6',
        ]);

        // send validate message
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 422);
        }

        // store user information
        $user = new User();
        $user->name = $request->get('name') ?? "";
        $user->email = $request->get('email') ?? "";
        $user->mobile = $request->get('mobile') ?? "";
        $user->password = Hash::make($request->get('password')) ?? "";
        $user->save();

        try {
            if (!($user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registration not successfull.'
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'Registration successfull.',
                'user' =>  $user
            ], 201);
            
        } catch (JWTException $e) {
            
            return response()->json([
                'success' => false,
                'message' => 'Registration not successfull.',
            ], 422);
        } 
    }

    // logout
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json([
            'success' => true,
            'message' => 'Logout Successfull.',
        ], 200);
    }

    // profile
    public function profile() {
        $user = Auth::guard('api')->user();
        return response()->json([
            'success' => true,
            'user' => $user
        ], 200);
    }

    // token response
    protected function respondWithToken($token) 
    {
        $user = User::select('id', 'name', 'email', 'mobile', 'profile_image')->where('id', Auth::guard('api')->id())->first();

        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $user
        ], 200);
    }
}
