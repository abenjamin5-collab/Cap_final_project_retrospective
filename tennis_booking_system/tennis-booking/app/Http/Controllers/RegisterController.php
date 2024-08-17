<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
     /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
      $request->validate([  
            'firstName' => 'required',
            'lastName' => 'required' ,
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required|in:coach,student' 
            ]);
        
   
       
        $user = User::create([
         'first_name' => $request->firstName,
         'last_name' => $request->lastName,
         'email' => $request->email,
         'password' => bcrypt($request->password),
         'role' => $request->role 
        ]);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['user'] =  $user;
   
        return response()->json(['message' => 'User successfully registered', 'data' => $success]);
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([  
 
            'email' => 'required|email',
            'password' => 'required'
          
            ]);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['user'] =  $user;
   
            return response()->json(['message' => 'User logged In', 'data' => $success]);
        } 
        else{ 
           return response()->json(['message' => 'User not logged In'], 400);
        } 
    }
}
