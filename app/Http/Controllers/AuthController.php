<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
// use Auth;

class AuthController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['login','signup','GetPassword','ResetPassword']]);
    }

    public function login(Request $request)
    {
        $validateData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email or Password Invalid'], 401);
        }

        return $this->respondWithToken($token);
    }

    
    public function GetPassword($email){  //get password
        return response('fref');
    }

    public function ResetPassword(Request $request){ //change password
        echo "<script>
        console.log('hello');
        </script>";
        return response('fref');

        exit();

        $validatedData = $request->validate([
            'email' => 'required|max:255|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $userData = DB::table('users')->where('email',$request->email)->exists();

        if(!$userData){  //return false if email does not exits
            $serverResponse = array(
                'status' => 'false',
                'message' => 'Invalid Email Address'
            );
            return response()->json($serverResponse);
        }

            $data = array();
            $data['password'] = Hash::make($request->password);
            $user = DB::table('users')->where('email',$request->email)->update($data); //update all data in database

        
            $serverResponse = array(
                'status' => 'true',
                'message' => 'Password Updated Successfully'
            );
            return response()->json($serverResponse);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function signup(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        $data = array(); 
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        DB::table('users')->insert($data);

        return $this->login($request);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'user_id' => auth()->user()->id
        ]);
    }
}
