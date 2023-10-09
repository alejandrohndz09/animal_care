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
            // 'idAnimal' => 'required|unique:expediente,idAnimal',
            // 'albergue' => 'required',
            'fecha' => 'required|date|before_or_equal:today',
            'estado' => 'required',
        ], [
            'idAnimal.unique' => 'Ya existe un expediente de este animal.',
            'idAnimal.required' => 'El campo animal es requerido.',
            'albergue.required' => 'El campo albergue es requerido.',
            'fecha.before_or_equal' => 'La fecha ingresada no debe ser mayor a la de ahora.',
        ]);

        // Obtén el último registro de la tabla para determinar el siguiente incremento
        $ultimoRegistro = Expediente::latest('idExpediente')->first();

        // Calcula el siguiente incremento
        $siguienteIncremento = $ultimoRegistro ? (int) substr($ultimoRegistro->idMiembro, -4) + 1 : 1;

        // Crea el ID personalizado concatenando "MB" y el incremento
        $idPersonalizado = "EX" . str_pad($siguienteIncremento, 5, '0', STR_PAD_LEFT);

        //Guardar en BD
        $expediente = new Expediente();
        $expediente->idExpediente = $idPersonalizado;
        $expediente->idAnimal = $request->post('animal');
        $expediente->idAlvergue = $request->post('albergue');
        $expediente->fechaIngreso = $request->post('fecha');
        $expediente->estadoGeneral = $request->post('estado');
        $expediente->estado = 1;
        $expediente->save();

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
        $request->validate([
            'idAnimal' => 'required|unique:miembro,idAnimal,' . $id . ',idExpediente',
            'albergue' => 'required',
            'fecha' => 'required|date|before_or_equal:today',
            'estado' => 'required',
        ], [
            'idAnimal.unique' => 'Ya existe un expediente de este animal.',
            'idAnimal.required' => 'El campo animal es requerido.',
            'albergue.required' => 'El campo albergue es requerido.',
            'fecha.before_or_equal' => 'La fecha ingresada no debe ser mayor a la de ahora.',
        ]);

        $expediente = Expediente::find($id);

        $expediente->idAnimal = $request->post('animal');
        $expediente->idAlvergue = $request->post('albergue');
        $expediente->fechaIngreso = $request->post('fecha');
        $expediente->estadoGeneral = $request->post('estado');
        $expediente->save();

        return redirect()->route('expediente.index');
    }

    public function destroy($id)
    {
        $expediente = Expediente::find($id);
        $expediente->estado = '0';
        $expediente->save();
        return redirect()->route('expediente.index');
    }
    
    public function alta($id)
    {
        $expediente = Expediente::find($id);
        $expediente->estado = '1';
        $expediente->save();
        return redirect()->route('expediente.index');
    }
}
