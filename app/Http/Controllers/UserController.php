<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
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

        if(!$token = auth('user')->attempt($credentials)){
            return response()->json(['error'=>'Wrong Email/Password'],401);
        }

        return response()->json(['token'=>$token]);
    }


    public  function index(Request $request, User $user){
        return $user->all();
    }

    public function register(Request $request,User $user){

//        dd($request->all());
        $request->validate([
            'username' => 'required |unique:users',
            'phone' => 'unique:users',
            'email' => 'email|unique:users',
            'password' => 'required',
            'c_password' => 'required |same:password',
        ]);

        $user = $user->create([
            'username' =>$request->username,
            'phone' =>  $request->phone,
            'email' =>  $request->email,
            'password' => bcrypt($request->password),
        ]);

//        $user->username = $request->username;
        return response($user);

    }


    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {

    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
    }


}
