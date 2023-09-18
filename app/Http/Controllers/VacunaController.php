<?php

namespace App\Http\Controllers;

use App\Models\Vacuna;
use Illuminate\Http\Request;

class VacunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vacuna =  Vacuna::all();
        return view('vacuna.vacuna', ['vacuna' => $vacuna]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vacuna.vacuna');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['vacuna' => 'required|unique:vacuna']);

        $ultimoRegistro = Vacuna::latest('idVacuna')->first();

        $siguienteIncremento = $ultimoRegistro ? (int) substr($ultimoRegistro->idVacuna, -4) + 1 : 1;

        // Crea el ID personalizado concatenando "MB" y el incremento
        $idPersonalizado = "MB" . str_pad($siguienteIncremento, 5, '0', STR_PAD_LEFT);

        //guardar en la base
        $vacuna = new Vacuna();
        $vacuna->idVacuna = $this->generarId();
        $vacuna->vacuna = $request->post('vacuna');

        $vacuna->save();

       
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
        $vacunaEdit = Vacuna::find($id);
        $vacuna= Vacuna::all();
        return view('vacuna.vacuna')->with
        (['vacunaEdit'=> $vacunaEdit,'vacuna'=>$vacuna ]);
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
        $vacuna = Vacuna::find($id);
    $request->validate([
        'vacuna'=> 'required|unique:vacuna,vacuna,'.$id.',idvacuna'
    ]);
    //actualizar datos en bd
    $vacuna->vacuna=$request->post('vacuna');
    $vacuna->save();
    return $this->index();
    }

    public function generarId()
    {
        // Obtener el último registro de la tabla "Espacio"
        $ultimaVacuna = Vacuna::latest('idVacuna')->first();

        if (!$ultimaVacuna) {
            // Si no hay registros previos, comenzar desde VA0001
            $nuevoId = 'VA0001';
        } else {
            // Obtener el número del último idVacuna
            $ultimoNumero = intval(substr($ultimaVacuna->idVacuna, 3));

            // Incrementar el número para el nuevo registro
            $nuevoNumero = $ultimoNumero + 1;

            // Formatear el nuevo idESpecie con ceros a la izquierda
            $nuevoId = 'VA' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
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
        $vacuna=Vacuna::find($id);
        $vacuna->delete();

        
        return back()->with('success', 'Eliminado con éxito');
               
    }
}
