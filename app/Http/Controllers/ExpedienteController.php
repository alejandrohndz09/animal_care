<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Expediente;
use Illuminate\Http\Request;

class ExpedienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Formulario donde se agrega datos
        $expedientes = Expediente::all();
        $expediente = null;
        return view('expediente.index')->with([
            'expedientes' => $expedientes,
            'expediente' => $expediente
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'animal' => 'required',
            'albergue' => 'required',
            'fecha' => 'required',
            'estado' => 'required',
        ], [
            'animal.required' => 'El campo animal es requerido.',
            'albergue.required' => 'El campo albergue es requerido.',
        ]);

        // Obtén el último registro de la tabla para determinar el siguiente incremento
        $ultimoRegistro = Expediente::latest('idExpediente')->first();

        // Calcula el siguiente incremento
        $siguienteIncremento = $ultimoRegistro ? (int) substr($ultimoRegistro->idMiembro, -4) + 1 : 1;

        // Crea el ID personalizado concatenando "MB" y el incremento
        $idPersonalizado = "EX" . str_pad($siguienteIncremento, 5, '0', STR_PAD_LEFT);

        //Guardar en BD
        $miembros = new Expediente();
        $miembros->idExpediente = $idPersonalizado;
        $miembros->idAnimal = $request->post('animal');
        $miembros->idAlvergue = $request->post('albergue');
        $miembros->fechaIngreso = $request->post('fecha');
        $miembros->estadoGeneral = $request->post('estado');
        $miembros->estado = 1;
        $miembros->save();

        return redirect()->route('expediente.index');
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $expediente = Expediente::find($id);
        $expedientes = Expediente::all();
        return view('expediente.index')->with([
            'expediente' => $expediente,
            'expedientes' => $expedientes
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
