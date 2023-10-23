<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Historialpatologium;
use App\Models\Patologia;
use App\Models\Patologium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorialPatologiasController extends Controller
{

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
        $request->validate([
            'idPatologia' => 'required',
            'detalles' => 'required',
            'fechaDiagnostico' => 'required|before_or_equal:today',
            'estado' => 'required'
        ], [
            'fechaDiagnostico.before_or_equal' => 'La fecha ingresada no debe ser mayor a la de ahora.',
            'idPatologia' => 'El campo patología es requerido'
        ]);

        if ($request->input('operacionPatologia') == 'Agregar') {

            // Obtén el último registro de la tabla para determinar el siguiente incremento
            $ultimoRegistro = Historialpatologium::latest('idHistpatologia')->first();

            // Calcula el siguiente incremento
            $siguienteIncremento = $ultimoRegistro ? (int) substr($ultimoRegistro->idHistPatologia, -4) + 1 : 1;

            // Crea el ID personalizado concatenando "HV" y el incremento
            $idPersonalizado = "HP" . str_pad($siguienteIncremento, 5, '0', STR_PAD_LEFT);

            $newHistorialVacuna = new Historialpatologium();
            $newHistorialVacuna->idHistPatologia = $idPersonalizado;
            $newHistorialVacuna->fechaDiagnostico = $request->input('fechaDiagnostico');
            $newHistorialVacuna->estado = $request->input('estado');
            $newHistorialVacuna->datalles = $request->input('detalles');
            $newHistorialVacuna->idPatologia = $request->input('idPatologia');
            $newHistorialVacuna->idExpediente = $request->input('idExpediente');
            $newHistorialVacuna->save();

            // $alert = array(
            //     'type' => 'success',
            //     'message' => 'El registro se ha guardado exitosamente'
            // );

            // session()->flash('alert', $alert);
            // Redirige al usuario a la página deseada
             return redirect()->action([ExpedienteController::class, 'show'], ['expediente' => $request->input('idAnimal')]);

        } elseif ($request->input('operacion') == 'modificar') {

            $HistorialPatologia = Historialpatologium::find($request->input('idHistVacuna'));

            // Actualiza los datos en la BD
            $HistorialPatologia->fechaDiagnostico = $request->input('fechaDiagnostico');
            $HistorialPatologia->estado = $request->input('estado');
            $HistorialPatologia->idVacuna = $request->input('idPatologia');
            $HistorialPatologia->save();

            //     //   // Redirige al usuario a la página deseada
            //     //   return redirect()->action([ExpedienteController::class, 'show'], ['expediente' => $request->input('idAnimal')]);
        }
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

    public function ObtenerPatologias()
    {
        $datos = Patologium::all();

        return response()->json($datos);
    }

    public function obtenerPatologiasGuardadas($id)
    {
        $patologiasRelacionadas = Patologium::whereHas('historialpatologia.expediente.animal', function ($query) use ($id) {
            $query->where('idAnimal', $id);
        })->get();
        return response()->json($patologiasRelacionadas);
    }
}
