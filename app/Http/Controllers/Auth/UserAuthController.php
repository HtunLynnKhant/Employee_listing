<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    public function register(Request $request){
        $data=$request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|comfirmed'
        ]);
        $data['password']=bcrypt($request->password);
        $user=User::create($data);
        $token=$user->createToken('API Token')->accessToken;
        return response(['user'=>$user,'token'=>$token]);
    }
    public function login (Request $request){
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Incorrect username or password. 
            Please try again']);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;

        return response(['user' => auth()->user(), 'token' => $token]);

    }
}

