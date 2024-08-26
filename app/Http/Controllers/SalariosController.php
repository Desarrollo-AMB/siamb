<?php

namespace App\Http\Controllers;

use App\Models\Salarios;
use App\Http\Requests\StoreSalariosRequest;
use App\Http\Requests\UpdateSalariosRequest;

class SalariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreSalariosRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSalariosRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Salarios  $salarios
     * @return \Illuminate\Http\Response
     */
    public function show(Salarios $salarios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Salarios  $salarios
     * @return \Illuminate\Http\Response
     */
    public function edit(Salarios $salarios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSalariosRequest  $request
     * @param  \App\Models\Salarios  $salarios
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSalariosRequest $request, Salarios $salarios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salarios  $salarios
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salarios $salarios)
    {
        //
    }
}
