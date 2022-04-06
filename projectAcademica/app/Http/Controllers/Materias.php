<?php

namespace App\Http\Controllers;

use App\Models\materia;
use Illuminate\Http\Request;

class Materias extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return materia::get();//select * from materia
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
        $id = materia::create($request->all())->id;//insert into materia...
        return response()->json(['id'=>$id], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function show(materia $materia)
    {
        return $materia;//select * from materia where id = $id
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function edit(materia $materia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, materia $materia)
    {
        $materia->update($request->all()); //update materia set ... where id = $id
        return response()->json(['id'=>true], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function destroy(materia $materia)
    {
        $materia->delete();//delete from materia where id = $id
        return response()->json(['id'=>$materia->id], 200);
    }
}
