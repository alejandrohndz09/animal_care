<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Donante;
use App\Models\Movimiento;
use App\Models\Recurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovimientoController extends Controller
{

    public function index()
    {
        $movimientos = Movimiento::orderByDesc('fechaMovimento')->get();
        $donates = Donante::all();
        return view('inventario.movimiento.index')->with('Movimientos', $movimientos)->with('donantes', $donates);
    }
    public function Create()
    {
    }

    public function store(Request $request)
    {

        $recursoId = $request->post('recurso');
        $recurso = Recurso::find($recursoId);
        
        // Sumar las cantidades de ingresos
        $totalIngresos = $recurso->movimientos()->where('tipoMovimiento', 'Ingreso')->sum('valor');

        // Restar las cantidades de salidas
        $totalSalidas = $recurso->movimientos()->where('tipoMovimiento', 'Salida')->sum('valor');

        // Calcular el saldo total
        $saldoTotal = $totalIngresos - $totalSalidas;

        // Validar si la cantidad supera al saldo total
        $request->validate([
            'fecha' => 'required|date|after_or_equal:' . $this->fechaMinima(),
            'tipoMovimiento' => 'required|in:Ingreso,Salida',
            'isDonado' => 'required_if:tipoMovimiento,Ingreso|in:Sí,No',
            'donanteE' => 'required_if:isDonado,Sí',
            'recurso' => 'required|exists:recurso,idRecurso',
            'valor' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) use ($saldoTotal) {
                    // Comprobar si el valor es mayor que el saldo total
                    if ($value > $saldoTotal) {
                        $fail("La cantidad ingresada supera el saldo total disponible.");
                    }
                },
            ],
            'concepto' => 'required|min:10',
        ], [
            // Otras reglas de validación y mensajes personalizados
        ]);


        //Guardar en BD
        $Movimiento = new Movimiento();
        $Movimiento->idMovimiento = $this->generarId();
        $Movimiento->descripcion = $request->post('concepto');
        $Movimiento->fechaMovimento = $request->post('fecha');
        $Movimiento->tipoMovimiento = $request->post('tipoMovimiento');
        $Movimiento->valor = $request->post('valor');
        $Movimiento->idMiembro =  Auth::user()->idMiembro;
        $Movimiento->idRecurso = $request->post('recurso');
        $Movimiento->idDonante = $request->input('donanteE');

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
        $Movimientos = Movimiento::all();
        $donantes = Donante::all();

        return view('inventario.movimiento.index')->with([
            'Movimientos' => $Movimientos,
            'MovimientoEdit' => $MovimientoEdit,
            'donantes' => $donantes
        ]);
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'fecha' => 'required|date|after_or_equal:' . $this->fechaMinima(),
        //     'tipoMovimiento' => 'required|in:Ingreso,Salida',
        //     'isDonado' => 'required_if:tipoMovimiento,Ingreso|in:Sí,No',
        //     'donanteE' => 'required_if:isDonado,Sí|exists:donante,idDonante',
        //     'recurso' => 'required|exists:recurso,idRecurso',
        //     'valorlabel' => 'required|numeric|min:1',
        //     'concepto' => 'required|min:10',
        // ], [
        //     // 'movimiento.unique' => 'Esta descripción ya ha sido utilizada.',
        //     // 'unidad.required' => 'El campo unidad de medida es requerido.',
        // ]);

        $movimiento = Movimiento::find($id);
        //Guardar en BD
        $movimiento->descripcion = $request->post('concepto');
        $movimiento->fechaMovimento = $request->post('fecha');
        // dd($request->post('fecha'));
        $movimiento->tipoMovimiento = $request->post('tipoMovimiento');
        $movimiento->valor = $request->post('valor');
        $movimiento->idMiembro =  Auth::user()->idMiembro;
        $movimiento->idRecurso = $request->post('recurso');
        $movimiento->idDonante = $request->post('donanteE');

        $movimiento->save();

        $alert = array(
            'type' => 'success',
            'message' => 'El registro se ha modificado exitosamente',
        );

        session()->flash('alert', $alert);
        $donates = Donante::all();
        return redirect()->route('movimientos.index')->with('Movimientos', Movimiento::all())->with('donantes', $donates);;
    }

    public function destroy($id)
    {
        $movimiento = Movimiento::find($id);
        $movimiento->delete();
        return redirect()->route('movimientos.index')->with('Movimientos', Movimiento::all());
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
