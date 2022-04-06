<?php

namespace App\Http\Controllers;

use App\Models\matricula;
use Illuminate\Http\Request;

class Matriculas extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return matricula::get();//select * from matricula
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
        $id = matricula::create($request->all())->id;//insert into matricula...
        return response()->json(['id'=>$id], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function show(matricula $matricula)
    {
        return $matricula;//select * from matricula where id = $id
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function edit(matricula $matricula)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, matricula $matricula)
    {
        $matricula->update($request->all()); //update matricula set... where id = $id
        return response()->json(['id'=>$request->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function destroy(matricula $matricula)
    {
        $matricula->delete();//delete from matricula where id = $id
        return response()->json(['id'=>$matricula->id], 200);
    }
}
