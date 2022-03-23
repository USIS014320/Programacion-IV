<?php

namespace App\Http\Controllers;

use App\Models\alumno;
use Illuminate\Http\Request;

class Alumno extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return alumno::get();//sellect * from alumno
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
        $id = Alumno::create($request->all())->id;//insert into alumno...
        return response()->json($id, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function show(alumno $alumno)
    {
        return $alumno;//sellect * from alumno where id = $id
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function edit(alumno $alumno)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, alumno $alumno)
    {
        $alumno->update($request->all());//update alumno set... where id = $id
        return response()->json($request->id, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function destroy(alumno $alumno)
    {
        $alumno->delete();//delete from alumno where id = $id
        return response()->json(null, 204);
    }
}
