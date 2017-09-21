<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    
    private $fs;
    
    public function __construct()
    {
        $this->fs = App::make('Illuminate\Filesystem\Filesystem');
        $this->path = base_path('resources/lang');
    }

    
    public function checkAuth(Request $request)
    {
        // setting the credentials array
        $credentials = [
        'email'     => $request->input('email'),
        'password'  => $request->input('password'),
        'status'    => '0'
        ];

        // if the credentials are wrong
        if (!Auth::attempt($credentials)) {
            return response('Username password does not match', 403);
        }
        User::where('email',$request->input('email'))->update([
            'loginStatus'    => 1
            ]);
        return response(Auth::user(), 201);
    }

    public function logoutuser(Request $request)
    {
        User::where('id',$request->input('id'))->update([
            'loginStatus'    => 0
            ]);
        return response(Auth::user(), 201);
    }


    public function signup(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'usertype'      => 'required',
            'email'         => 'required|unique:users|max:255|min:8',
            'password'      => 'required',
            'dob'           => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 401);
        }

        $datavalue = [
        'usertype'      => $request->input('usertype'),
        'name'          => $request->input('name'),
        'email'         => $request->input('email'),
        'password'      => \Hash::make($request->input('password')),
        'gender'        => $request->input('gender'),
        'dob'           => date("Y-m-d", strtotime($request->input('dob'))),
        'mobile'        => $request->input('mobile'),
        'ipaddress'     => $request->input('ipaddress'),
        'api_token'     => str_random(60)
        ];

        $query = User::create($datavalue);
        if($query)
        {
            return response(Auth::user(), 201);
        }
        else
        {
            return response('Error, Please Try Again.', 403);
        }
    }
}