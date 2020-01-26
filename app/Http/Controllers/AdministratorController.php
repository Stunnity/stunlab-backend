<?php

namespace App\Http\Controllers;

use App\Administrator;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class AdministratorController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
   //
    }







    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request)
    {
        $credentials = $request->only(['username','password']);


        if(!$token = auth('admin')->attempt($credentials)){
            return response()->json(['error'=>'Wrong Email/Password'],404);
        }
//        dd(auth('admin')->check());
        return response()->json(['error'=>false,'token'=>$token]);
    }




    public function logout(Request $request){
            if(auth('admin')->logout())
                return response()->json(['status'=>'success','message'=>'logout'],200);

            return response()->json(['status'=>'failed','message'=>'logout'],400);
    }

    /**
     * register Admin
     *
     */

    public function register(Request $request, Administrator $admin)
    {

        $request->validate([
            'username' => 'required |unique:administrators|min:10',
            'provider_providerName' => 'unique:administrators',
            'email' => 'email|unique:administrators',
            'phone' => 'unique:administrators',
            'password' => 'required|min:10',
            'c_password' => 'required |same:password',
            'description' => 'required |min:200|string'
        ]);
//
//         dd($request->all());
//        dd('yes');

        $admin = $admin->create([
            'username' => $request->username,
            'provider_providerName' =>  $request->provider_providerName,
            'phone' => $request->phone,
            'email' =>  $request->email,
            'password' => bcrypt($request->password),
            'description' => $request->description,
        ]);

//        $admin->username = $request->username;
        return response($admin);
    }



}
