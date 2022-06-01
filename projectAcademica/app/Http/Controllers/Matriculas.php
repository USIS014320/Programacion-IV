<?php

namespace App\Http\Controllers;

use App\Matricula;
use Illuminate\Http\Request;

class Matriculas extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Matricula::get(); //retorna todos los registros
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
        //$id = Matricula::create($request->all())->id; //
        $matricula = Matricula::create(); //crea un registro vacio en la tabla matriculas
        $matricula->idMatricula = $request->idMatricula;
        $matricula->idAlumno = $request->alumno['id'];
        $matricula->ciclo = $request->ciclo;
        $matricula->save(); //guarda el registro

        return response()->json(['id'=>$matricula->id], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function show(Matricula $matricula)
    {
        return $matricula; //retorna un registro
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function edit(Matricula $matricula)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matricula $matricula)
    {
        //$matricula->update($request->all());
        $matricula->idMatricula = $request->idMatricula;
        $matricula->idAlumno = $request->alumno['id'];
        $matricula->ciclo = $request->ciclo;
        $matricula->save(); //guarda el registro
        return response()->json(['id'=>$request->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matricula $matricula)
    {
        $matricula->delete();
        return response()->json(['id'=>$matricula->id], 200);
    }
}
