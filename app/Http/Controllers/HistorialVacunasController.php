<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Expediente;
use App\Models\Historialvacuna;
use Illuminate\Http\Request;

class HistorialVacunasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'vacuna' => 'required', // Puedes ajustar las reglas de validación según tus necesidades
            'fecha' => 'required|before_or_equal:today',
            'dosis' => 'required',
        ], [
            'foto.required' => 'La Fotografía es necesaria.',
            'fecha.before_or_equal' => 'La fecha ingresada no debe ser mayor a la de ahora.',
        ]);

        // Obtén el último registro de la tabla para determinar el siguiente incremento
        $ultimoRegistro = Historialvacuna::latest('idHistVacuna')->first();

        // Calcula el siguiente incremento
        $siguienteIncremento = $ultimoRegistro ? (int) substr($ultimoRegistro->idHistVacuna, -4) + 1 : 1;

        // Crea el ID personalizado concatenando "HV" y el incremento
        $idPersonalizado = "HV" . str_pad($siguienteIncremento, 5, '0', STR_PAD_LEFT);

        $newHistorialVacuna = new Historialvacuna();
        $newHistorialVacuna->idHistVacuna = $idPersonalizado;
        $newHistorialVacuna->fechaAplicacion = $request->input('fechaAplicacion');
        $newHistorialVacuna->dosis = $request->input('dosis');
        $newHistorialVacuna->idVAcuna = $request->input('vacuna');
        $newHistorialVacuna->idExpediente = $request->input('idExpediente');
        $newHistorialVacuna->save();

        return view('animal.detalles')->with([
            'animal' => Animal::find($request->input('idAnimal')),
            'registrado' => Expediente::where('idAnimal', $request->input('idAnimal'))->get(),
            'estado' => Expediente::where('idAnimal', $request->input('idAnimal'))->value('estadoGeneral'),
            'idExpediente' => Expediente::where('idAnimal', $request->input('idAnimal'))->value('idExpediente'),
        ]);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
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
