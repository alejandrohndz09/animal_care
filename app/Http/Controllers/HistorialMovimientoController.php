<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HistorialMovimientoController extends Controller
{
    public function index()
    {
        $Movimientos = Movimiento::all();
        return view('inventario.historialMovimientos.index')->with([
            'movimientos' => $Movimientos
        ]);
    }

    public function show(Request $request)
    {
        // Validar las fechas
        $request->validate([
            'tipoMovimiento' => [
                'required',
                'not_in:Seleccione', // Asegura que no sea el valor por defecto
            ],
            'fechaInicio' => [
                'required',
                'date',
            ],
            'fechaFin' => [
                'required',
                'date',
                'after_or_equal:fechaInicio',
                'different:fechaInicio',
            ],
        ], [
            'tipoMovimiento.required' => 'El campo Tipo de movimiento es obligatorio.',
            'tipoMovimiento.not_in' => 'Seleccione una opción válida para Tipo de movimiento.',
            'fechaFin.after_or_equal' => 'La fecha fin debe ser igual o posterior a la fecha de inicio y a la fecha actual.',
            'fechaFin.different' => 'Las fechas de inicio y fin deben ser diferentes.',
        ]);

        // Obtener los datos del formulario
        $tipoMovimiento = $request->input('tipoMovimiento');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
  
        // Tu lógica de consulta
        $movimientos = Movimiento::where('tipoMovimiento', $tipoMovimiento)
            ->whereBetween('fechaMovimento', [$fechaInicio, $fechaFin])
            ->get();
        // Resto del código...

        return view('inventario.historialMovimientos.index')->with(
            [
                'movimientos' => $movimientos,
                'tipoMovimiento' => $tipoMovimiento,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,
            ]
        );
    }

    public function pdf(Request $request)
    {

        // Obtener los datos del formulario
        $tipoMovimiento = $request->input('tipoMovimiento');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');

        // Tu lógica de consulta
        $movimientos = Movimiento::where('tipoMovimiento', $tipoMovimiento)
            ->whereBetween('fechaMovimento', [$fechaInicio, $fechaFin])
            ->get();
     

        // dd($historialVacunas);
        $pdf = PDF::loadView('inventario.historialMovimientos.pdf', compact('movimientos'));

       // return $pdf->stream();
        return $pdf->download('Movimientos.pdf');
    }
}
