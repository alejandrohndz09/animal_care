<?php

namespace App\Http\Controllers;

use App\Models\Especie;
use App\Models\EspecieModelo;
use Illuminate\Http\Request;

class EspecieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $especie =  Especie::all();
        return view('especie.especie', ['especie' => $especie]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('especie.especie');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['especie' => 'required|unique:especie']);

        $ultimoRegistro = Especie::latest('idEspecie')->first();

        $siguienteIncremento = $ultimoRegistro ? (int) substr($ultimoRegistro->idEspecie, -4) + 1 : 1;

        // Crea el ID personalizado concatenando "MB" y el incremento
        $idPersonalizado = "MB" . str_pad($siguienteIncremento, 5, '0', STR_PAD_LEFT);

        //guardar en la base
        $especie = new Especie();
        $especie->idEspecie = $this->generarId();
        $especie->especie = $request->post('especie');

        $especie->save();

       
        return back()->with('success', 'Guardado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EspecieModelo  $especieModelo
     * @return \Illuminate\Http\Response
     */
    public function show(EspecieModelo $especieModelo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EspecieModelo  $especieModelo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $especieEdit = Especie::find($id);
       $especie= Especie::all();
       return view('especie.especie')->with
       (['especieEdit'=> $especieEdit,'especie'=>$especie ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EspecieModelo  $especieModelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    $especie = Especie::find($id);
    $request->validate([
        'especie'=> 'required|unique:especie,especie,'.$id.',idEspecie'
    ]);
    //actualizar datos en bd
    $especie->especie=$request->post('especie');
    $especie->save();
    return redirect()->route("especie.especie");
    }

    public function generarId()
    {
        // Obtener el último registro de la tabla "Espacio"
        $ultimaEspecie = Especie::latest('idEspecie')->first();

        if (!$ultimaEspecie) {
            // Si no hay registros previos, comenzar desde AN0001
            $nuevoId = 'ES0001';
        } else {
            // Obtener el número del último idEspecie
            $ultimoNumero = intval(substr($ultimaEspecie->idEspecie, 3));

            // Incrementar el número para el nuevo registro
            $nuevoNumero = $ultimoNumero + 1;

            // Formatear el nuevo idESpecie con ceros a la izquierda
            $nuevoId = 'ES' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
        }

        return $nuevoId;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EspecieModelo  $especieModelo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $especie=Especie::find($id);
        $especie->save();
        return back()->with('success', 'Eliminado con éxito');
               
    }
}
