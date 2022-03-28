<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
use Validator;
use Hash;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $rules = array(
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        );

        $cek = Validator::make($request->all(),$rules);

        if ($cek->fails()) {
            $errorString = implode(",",$cek->messages()->all());
            return redirect()->route('login')->with('warning',$errorString);
        } else {
            if(Auth::attempt($request->only('email','password'))) {
                $user = User::where('email', $request->email)->first();
                // $roles = $user->getRoleNames();
                // if($roles[0] == 'admin'){
                    return redirect()->route('dashboard');
                // }else{
                    // return redirect()->route('dashboardUser');
                // }
            }else{
                return redirect()->route('login')->with('warning',"email atau password anda salah");
            }
            
        }
        
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    
}
