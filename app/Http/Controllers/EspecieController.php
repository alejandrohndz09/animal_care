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

        //guardar en la base
        $especie = new Especie();
        $especie->idEspecie = $this->generarId();
        $especie->especie = $request->post('especie');

        $especie->save();


        $alert = array(
            'type' => 'success',
            'message' => 'El registro se ha agregado exitosamente',
        );

        session()->flash('alert', $alert);

        return back()->with('success', 'Guardado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EspecieModelo  $especieModelo
     * @return \Illuminate\Http\Response
     */
    public function show(Especie $especieModelo)
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
        $especie = Especie::all();
        return view('especie.especie')->with(['especieEdit' => $especieEdit, 'especie' => $especie]);
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
            'especie' => 'required|unique:especie,especie,' . $id . ',idEspecie'
        ]);
        //actualizar datos en bd
        $especie->especie = $request->post('especie');
        $especie->save();


        $alert = array(
            'type' => 'success',
            'message' => 'El registro se ha modificado exitosamente',
        );

        session()->flash('alert', $alert);


        return $this->index();
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
        $especie = Especie::find($id);

        if ($especie->razas->isEmpty()) {
            $especie->delete();
            $alert = array(
                'type' => 'success',
                'message' => 'El registro se ha eliminado exitosamente'
            );
            session()->flash('alert', $alert);
        } else {
            $alert = array(
                'type' => 'error',
                'message' => 'No se puede eliminar el registro porque tiene datos asociados'
            );

            session()->flash('alert', $alert);
        }
        return $this->index();
    }
}
