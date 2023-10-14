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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'vacuna' => 'required',
            'fechaAplicacion' => 'required|before_or_equal:today',
            'dosis' => 'required',
        ], [
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

        // Redirige al usuario a la página deseada
        $expController = new ExpedienteController();
        $expController->show($request->input('idAnimal'));

        // Devuelve una respuesta JSON de éxito
        return response()->json(['success' => true, 'message' => 'Guardado con éxito']);
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
