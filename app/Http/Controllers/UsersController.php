<?php

namespace App\Http\Controllers;

use App\Events\UserWasCreated;
use Illuminate\Http\Request;
use Validator;
use Faker\Generator;

use App\Http\Requests;
use App\User;
use App\Property;
use Auth;

class UsersController extends Controller
{

    /**
     * Store a new user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // setup validation
        $validation = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:3',
        ]);

        // return any errors
        if($validation->fails()){
            return response(['errors'=>$validation->errors()->all()], 400);
        }

        // create unique api token
        do {
            $api_token = str_random(60);
        } while (User::where('api_token', $api_token)->first() instanceof User);

        // add user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'api_token' => $api_token,
            'password' => $request->input('password'),
        ]);

        // we have just added a user
        event(new UserWasCreated($user));

        return response(['errors'=>false,'token'=>$api_token], 201);
    }


    /**
     * Signin a user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signin(Request $request)
    {
        $credentials = $request->only(['email','password']);

        // setup validation
        $validation = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // return any errors
        if($validation->fails()){
            return response(['errors'=>$validation->errors()->all()], 400);
        }

        // try to authorise
        if(!Auth::attempt($credentials)){
            return response(['errors'=>['Unable to authenticate with those credentials']], 401);
        }

        return response(['token'=>Auth::user()->api_key]);

    }

}
