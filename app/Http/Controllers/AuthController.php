<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
use Validator;
use Hash;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $rules = array(
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'no_telepon' => 'required|string|min:10',
            'password' => 'required|string|min:6|confirmed',
            // 'role' => 'required|max:1',
        );

        $cek = Validator::make($request->all(),$rules);

        if ($cek->fails()) {
            $errorString = implode("," , $cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $user = User::create([
                'name'=>$request->name,
                'password'=>bcrypt($request->password),
                'email'=>$request->email,
                'no_telepon'=>$request->no_telepon,
            ]);

            if($user){
                $user->assignRole('user');
                $role = 'user';
            }else{
                return response()->json([
                    'status'=>'Failed',
                    'message'=>'Failed'
                ], 422);
            }
        }

        $token = $user->createToken('regToken')->plainTextToken;

        return response()->json([
            'status'    => 'Success',
            'message'   => 'Success Registering Account',
            'role'      => $role,
            'user'      => $user,
            'token'     => $token
        ]);
    }
    public function login(Request $request)
    {
        $rules = array(
            'email'=> 'required|string|email',
            'password'=> 'required|string|min:6'
        );

        $cek = Validator::make($request->all(),$rules);

        if ($cek->fails()) {
            $errorString = implode("," , $cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $user = User::where('email',$request->email)->first();

            if(!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);      
            }

            $token = $user->createToken('userAccess')->plainTextToken;
            $role  = $user->getRoleNames();

            return response()->json([
                'status'    => 'Success',
                'message'   => 'Success Signing in Account',
                'role'      => $role,
                'user'      => $user,
                'token'     => $token
            ]);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    
}
