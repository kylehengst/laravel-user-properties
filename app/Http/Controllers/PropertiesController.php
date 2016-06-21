<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Property;
use Auth;
use Validator;

class PropertiesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api',['except'=>'index']);
    }

    /**
     * Display a listing properties
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Property::owner($request->input('user_id'))
            ->distance($request->input('latitude'),$request->input('longitude'),$request->input('radius'))
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $property = Property::where('user_id',Auth::guard('api')->user()->id)->findOrFail($id);

        // setup validation
        $validation = Validator::make($request->all(),[
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        // return any errors
        if($validation->fails()){
            return response(['errors'=>$validation->errors()->all()], 400);
        }

        // update
        $property->update($request->all());

        return response(['property'=>$property->toArray()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
