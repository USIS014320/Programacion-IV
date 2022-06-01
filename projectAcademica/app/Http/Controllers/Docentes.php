<?php

namespace App\Http\Controllers;

use App\docente;
use Illuminate\Http\Request;

class Docentes extends Controller
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
        return docente::get(); //select * from docentes
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
        $id = Docente::create($request->all())->id; //insert into docentes...
        return response()->json(['id'=>$id], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function show(docente $docente)
    {
        return $docente; //select * from docentes where id = $id
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function edit(docente $docente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, docente $docente)
    {
        $docente->update($request->all()); //update docentes set... where id = $id
        return response()->json(['id'=>$request->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function destroy(docente $docente)
    {
        $docente->delete(); //delete from docentes where id = $id
        return response()->json(['id'=>$docente->id], 200);
    }
}
