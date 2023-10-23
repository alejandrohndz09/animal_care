<?php

namespace App\Http\Controllers;

use App\Models\Historialvacuna;
use App\Models\Vacuna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\XmlConfiguration\Group;

class HistorialVacunasController extends Controller
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
        // Validar la solicitud
        $request->validate([
            'vacuna' => 'required',
            'fechaAplicacion' => 'required|before_or_equal:today',
            'dosis' => 'required',
        ], [
            'fecha.before_or_equal' => 'La fecha ingresada no debe ser mayor a la de ahora.',
        ]);

        if ($request->input('operacion') == 'Agregar') {

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

            $alert = array(
                'type' => 'success',
                'message' => 'El registro se ha guardado exitosamente'
            );

            session()->flash('alert', $alert);
            // // Redirige al usuario a la página deseada
             return redirect()->action([ExpedienteController::class, 'show'], ['expediente' => $request->input('idAnimal')]);

        } elseif ($request->input('operacion') == 'modificar') {

            $HistorialVacuna = Historialvacuna::find($request->input('idHistVacuna'));

            // Actualiza los datos en la BD
            $HistorialVacuna->fechaAplicacion = $request->post('fechaAplicacion');
            $HistorialVacuna->dosis = $request->post('dosis');
            $HistorialVacuna->idVAcuna = $request->input('vacuna');
            $HistorialVacuna->save();

            $expController = new ExpedienteController();
            $expController->show($request->input('idAnimal'));

            //   // Redirige al usuario a la página deseada
            //   return redirect()->action([ExpedienteController::class, 'show'], ['expediente' => $request->input('idAnimal')]);
        }
    }


    public function show($id)
    {
    }


    public function edit($id)
    {
        $historial = HistorialVacuna::with('vacuna')->find($id);

        return response()->json($historial);
    }

    public function destroy($id)
    {
        $HistorialVacuna = Historialvacuna::find($id);
        $HistorialVacuna->delete();
    }

    public function cargarListaDatos($id)
    {
        $datos = HistorialVacuna::where('idVacuna', $id)
            ->select('dosis', 'fechaAplicacion', 'idHistVacuna')
            ->get();

        return response()->json($datos);
    }

    public function cargarHistoriales($id)
    {

        $datos = DB::table('historialVacuna')
            ->join('vacuna', 'historialVacuna.idVacuna', '=', 'vacuna.idVacuna')
            ->where('historialVacuna.idExpediente', $id)
            ->select('vacuna.vacuna', 'vacuna.idVacuna', 'historialVacuna.idHistVacuna', 'historialVacuna.fechaAplicacion', 'historialVacuna.dosis', 'historialVacuna.idExpediente', 'historialVacuna.idHistVacuna')
            ->groupBy('vacuna.vacuna', 'vacuna.idVacuna', 'historialVacuna.idHistVacuna', 'historialVacuna.fechaAplicacion', 'historialVacuna.dosis', 'historialVacuna.idExpediente')
            ->get();

        return response()->json($datos);
    }

    public function ObtenerVacunas()
    {
        $datos = Vacuna::all();

        return response()->json($datos);
    }
}
