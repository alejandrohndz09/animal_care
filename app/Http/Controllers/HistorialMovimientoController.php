<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;

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

        $tipoMovimiento = $request->input('tipoMovimiento');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');

        $movimientos = Movimiento::where('tipoMovimiento', $tipoMovimiento)
            ->whereBetween('fechaMovimento', [$fechaInicio, $fechaFin]); // Cambia 10 al número de elementos por página que desees

        // Devolver una vista parcial en lugar de la vista completa
        return view('inventario.historialMovimientos.index', compact('movimientos'));
    }
}
