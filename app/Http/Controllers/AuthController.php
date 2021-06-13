<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginUser;
use App\Http\Requests\Auth\StoreUser;
use Carbon\Carbon;
use App\User;

class AuthController extends Controller
{
     /**
     * Create user
     *
     * @param  \App\Http\Requests\Auth\StoreUser  $request
     * @return \Illuminate\Http\Response
     */
    public function register(StoreUser $request)
    {     
        $attributes['name']     = $request->name;
        $attributes['email']    = $request->email;
        $attributes['mobile_no']= $request->mobile;
        $attributes['password'] = bcrypt($request->password);
        
        $user = User::create($attributes);

        return response()->json(['message' => $request], 201);
    }
      
    public function login(LoginUser $request)
    {    
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json(['message' => 'Unauthorized'], 401);

        $user = $request->user();
        $token = $user->createToken('Personal Access Token')->plainTextToken;
                
        return response()->json(['access_token' => $token,'token_type' => 'Bearer'],200);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function logout(Request $request)    
    {
        $user = $request->user()->tokens()->delete();        
       
        return response()->json(['message' => 'Successfully logged out'],200);
    }
}
