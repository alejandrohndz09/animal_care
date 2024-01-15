<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Movimiento;
use App\Models\Recurso;
use App\Models\Unidadmedida;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{

    public function index()
    {
        $movimientos = Movimiento::orderByDesc('fechaMovimento')->get();
        return view('inventario.movimiento.index')->with('Movimientos',$movimientos);
    }
    public function Create()
    {
    }

    public function store(Request $request)
    {

        $request->validate([
            'fecha' => 'required|date|after_or_equal' . $this->fechaMinima(),
            'tipoMovimiento' => 'required|in:Ingreso,Salida',
            'isDonado' => 'required_if:tipoMovimiento,Ingreso|in:Sí,No',
            'donanteE' => 'required_if:isDonado,Sí|exists:donante,idDonante',
            'recurso' => 'required|exists:recurso,idRecurso',
            'valor' => 'required|numeric|min:1',
            'concepto' => 'required|min:10',
        ], [
            'movimiento.unique' => 'Esta descripción ya ha sido utilizada.',
            'unidad.required' => 'El campo unidad de medida es requerido.',
        ]);

        //Guardar en BD
        $Movimiento = new Movimiento();
        $Movimiento->idMovimiento = $this->generarId();
        $Movimiento->movimiento = $request->post('movimiento');
        $Movimiento->idUnidadMedida = $request->post('unidad');
        $Movimiento->idCategoria = $request->post('categoria');
        $Movimiento->cantidad = 0;
        $Movimiento->estado = 1;
        $Movimiento->save();

        $alert = array(
            'type' => 'success',
            'message' => 'El registro se ha guardado exitosamente',
        );

        session()->flash('alert', $alert);
        $Movimiento->save();

        return back()->with('success', 'Guardado con éxito');

    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $MovimientoEdit = Movimiento::find($id);
        $Movimientos = Movimiento::where('estado', 1)->get();

        return view('inventario.movimiento.index')->with([
            'Movimientos' => $Movimientos,
            'MovimientoEdit' => $MovimientoEdit,
        ]);
    }

    public function update(Request $request, $id)
    {
        //Valida si estan en la BD excluyendo al registro modificado
        $request->validate([
            'movimiento' => 'required|unique:movimiento,movimiento,' . $id . ',idMovimiento',
            'categoria' => 'required',
            'unidad' => 'required',
        ], [
            'movimiento.unique' => 'Esta descripción ya ha sido utilizada.',
            'unidad.required' => 'El campo unidad de medida es requerido.',
        ]);

        $movimiento = Movimiento::find($id);
        $movimiento->movimiento = $request->post('movimiento');
        $movimiento->idUnidadMedida = $request->post('unidad');
        $movimiento->idCategoria = $request->post('categoria');
        $movimiento->save();
        $alert = array(
            'type' => 'success',
            'message' => 'El registro se ha modificado exitosamente',
        );

        session()->flash('alert', $alert);

        return redirect()->route('movimientos.index')->with('Movimientos', Movimiento::where('estado', 1)->get());
    }

    public function destroy($id)
    {
        $movimiento = Movimiento::find($id);
        $movimiento->estado = 0;
        
        

        if ($movimiento->movimientos->isEmpty()) {
            $movimiento->save();
            $alert = array(
                'type' => 'success',
                'message' => 'El registro se ha dado de baja exitosamente',
            );
            session()->flash('alert', $alert);
            
        } else {
            $alert = array(
                'type' => 'error',
                'message' => 'No se puede dar de baja al registro porque tiene datos asociados',
            );
            session()->flash('alert', $alert);
        }

        return redirect()->route('movimientos.index')->with('Movimientos', Movimiento::where('estado', 1)->get());
        
    }
    private function fechaMinima()
    {
        $fechaActual = now(); // O Carbon::now() si no has usado now() antes
        $fechaResultado = $fechaActual->subDays(15);
        return $fechaResultado->format('Y-m-d');
    }

    public function obtenerUnidad($recurso)
    {
        // Obtén las razas relacionadas con la especie seleccionada
        $recurso = Recurso::where('idRecurso', $recurso)->first();
        // Devuelve las razas en formato JSON
        return response()->json($recurso->unidadmedida);
    }

    public function generarId()
    {
        // Obtener el último registro de la tabla "animal"
        $ultimoRegistro = Movimiento::latest('idMovimiento')->first();

        if (!$ultimoRegistro) {
            // Si no hay registros previos, comenzar desde AN0001
            $nuevoId = 'RC0001';
        } else {
            // Obtener el número del último id
            $ultimoNumero = intval(substr($ultimoRegistro->idMovimiento, 2));

            // Incrementar el número para el nuevo registro
            $nuevoNumero = $ultimoNumero + 1;

            // Formatear el nuevo idAnimal con ceros a la izquierda
            $nuevoId = 'RC' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
        }

        return $nuevoId;
    }
}
