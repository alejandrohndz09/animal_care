<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Recurso;
use App\Models\Unidadmedida;
use Illuminate\Http\Request;

class RecursoController extends Controller
{

    public function index()
    {
        $recursos = Recurso::where('estado', 1)->get();
        return view('inventario.recurso.index')->with('Recursos',$recursos);
    }
    public function Create()
    {
    }

    public function store(Request $request)
    {

        $request->validate([
            'recurso' => 'required|unique:recurso',
            'categoria' => 'required',
            'unidad' => 'required',
        ], [
            'recurso.unique' => 'Esta descripción ya ha sido utilizada.',
            'unidad.required' => 'El campo unidad de medida es requerido.',
        ]);

        //Guardar en BD
        $Recurso = new Recurso();
        $Recurso->idRecurso = $this->generarId();
        $Recurso->recurso = $request->post('recurso');
        $Recurso->idUnidadMedida = $request->post('unidad');
        $Recurso->idCategoria = $request->post('categoria');
        $Recurso->cantidad = 0;
        $Recurso->estado = 1;
        $Recurso->save();

        $alert = array(
            'type' => 'success',
            'message' => 'El registro se ha guardado exitosamente',
        );

        session()->flash('alert', $alert);
        $Recurso->save();

        return back()->with('success', 'Guardado con éxito');

    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $RecursoEdit = Recurso::find($id);
        $Recursos = Recurso::where('estado', 1)->get();

        return view('inventario.recurso.index')->with([
            'Recursos' => $Recursos,
            'RecursoEdit' => $RecursoEdit,
        ]);
    }

    public function update(Request $request, $id)
    {
        //Valida si estan en la BD excluyendo al registro modificado
        $request->validate([
            'recurso' => 'required|unique:recurso,recurso,' . $id . ',idRecurso',
            'categoria' => 'required',
            'unidad' => 'required',
        ], [
            'recurso.unique' => 'Esta descripción ya ha sido utilizada.',
            'unidad.required' => 'El campo unidad de medida es requerido.',
        ]);

        $recurso = Recurso::find($id);
        $recurso->recurso = $request->post('recurso');
        $recurso->idUnidadMedida = $request->post('unidad');
        $recurso->idCategoria = $request->post('categoria');
        $recurso->save();

        return redirect()->route('recursos.index')->with('Recursos', Recurso::where('estado', 1)->get());
    }

    public function obtenerUnidades($categoria)
    {
        // Obtén las unidades relacionadas con la categoria seleccionada
        $unidades = Unidadmedida::where('idCategoria', $categoria)->orWhere('idCategoria', null)->get();
        // Devuelve las razas en formato JSON
        return response()->json($unidades);
    }

    public function destroy($id)
    {
        $recurso = Recurso::find($id);
        $recurso->estado = 0;
        
        

        if ($recurso->movimientos->isEmpty()) {
            $recurso->save();
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

        return view('inventario.recurso.index')->with([
            'Recursos' => Recurso::where('estado',0)->get(),
        ]);
        
    }

    public function alta($id)
    {
        $Recurso = Recurso::find($id);
        $Recurso->estado = 1;
        $Recurso->save();
        return redirect()->route('recurso.index');
    }

    public function generarId()
    {
        // Obtener el último registro de la tabla "animal"
        $ultimoRegistro = Recurso::latest('idRecurso')->first();

        if (!$ultimoRegistro) {
            // Si no hay registros previos, comenzar desde AN0001
            $nuevoId = 'RC0001';
        } else {
            // Obtener el número del último id
            $ultimoNumero = intval(substr($ultimoRegistro->idRecurso, 2));

            // Incrementar el número para el nuevo registro
            $nuevoNumero = $ultimoNumero + 1;

            // Formatear el nuevo idAnimal con ceros a la izquierda
            $nuevoId = 'RC' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
        }

        return $nuevoId;
    }
}
