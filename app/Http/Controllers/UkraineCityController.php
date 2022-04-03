<?php

namespace App\Http\Controllers;

use App\Models\UkraineCity;
use Illuminate\Http\Request;

class UkraineCityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UkraineCity::all();
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
     * @param  \App\Models\UkraineCity  $ukraineCity
     * @return \Illuminate\Http\Response
     */
    public function show(UkraineCity $ukraineCity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UkraineCity  $ukraineCity
     * @return \Illuminate\Http\Response
     */
    public function edit(UkraineCity $ukraineCity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UkraineCity  $ukraineCity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UkraineCity $ukraineCity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UkraineCity  $ukraineCity
     * @return \Illuminate\Http\Response
     */
    public function destroy(UkraineCity $ukraineCity)
    {
        //
    }
}
