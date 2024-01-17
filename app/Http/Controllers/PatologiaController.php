<?php

namespace App\Http\Controllers;

use App\Models\Patologia;
use App\Models\Patologium;
use Illuminate\Http\Request;

class PatologiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patologia =  Patologium::all();
        return view('patologia.patologia', ['patologia' => $patologia]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patologia.patologia');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['patologia' => 'required|unique:patologia']);

        $ultimoRegistro = Patologium::latest('idPatologia')->first();

        $siguienteIncremento = $ultimoRegistro ? (int) substr($ultimoRegistro->idPatologia, -4) + 1 : 1;

        // Crea el ID personalizado concatenando "PA" y el incremento
        $idPersonalizado = "PA" . str_pad($siguienteIncremento, 5, '0', STR_PAD_LEFT);

        //guardar en la base
        $patologia = new Patologium();
        $patologia->idPatologia = $this->generarId();
        $patologia->patologia = $request->post('patologia');

        $patologia->save();


        
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
        $patologiaEdit = Patologium::find($id);
        $patologia = Patologium::all();
        return view('patologia.patologia')->with(['patologiaEdit' => $patologiaEdit, 'patologia' => $patologia]);
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

        $patologia = Patologium::find($id);
        $request->validate([
            'patologia' => 'required|unique:patologia,patologia,' . $id . ',idPatologia'
        ]);
        //actualizar datos en bd
        $patologia->patologia = $request->post('patologia');
        $patologia->save();

        
        $alert = array(
            'type' => 'success',
            'message' => 'El registro se ha modificado exitosamente',
        );

        session()->flash('alert', $alert);

        return redirect()->route("patologia.index");
    }

    public function generarId()
    {
        // Obtener el último registro de la tabla "Espacio"
        $ultimaPatologia = Patologium::latest('idPatologia')->first();

        if (!$ultimaPatologia) {
            // Si no hay registros previos, comenzar desde PA0001
            $nuevoId = 'PA0001';
        } else {
            // Obtener el número del último idPatologia
            $ultimoNumero = intval(substr($ultimaPatologia->idPatologia, 3));

            // Incrementar el número para el nuevo registro
            $nuevoNumero = $ultimoNumero + 1;

            // Formatear el nuevo idPatologia con ceros a la izquierda
            $nuevoId = 'PA' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
        }

        return $nuevoId;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patologia = Patologium::find($id);

        $patologia->delete();
        
        $alert = array(
            'type' => 'success',
            'message' => 'El registro se ha eliminado exitosamente',
        );

        session()->flash('alert', $alert);

        return redirect()->route("patologia.index");
    }
}
