<?php

namespace App\Http\Controllers;

use App\Models\UnidadMedida;
use Illuminate\Http\Request;

class UnidadMedidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unidadMedidas = UnidadMedida::all();
        return view('inventario.unidadMedida.index')->with('unidadMedidas', $unidadMedidas);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'unidadMedida' => 'required|unique:unidadMedida',
            'simbolo' => 'required|unique:unidadmedida,simbolo|max:10',
            'categoria'=>'required'
        ],[
            'unidadMedida.unique' => 'Esta unidad de medida ya ha sido utilizada.',
        ]);

        $unidadMedida = new UnidadMedida();
        $unidadMedida->idUnidadMedida = $this->generarId();
        $unidadMedida->unidadMedida = $request->post('unidadMedida');
        $unidadMedida->simbolo = $request->post('simbolo');
        if($request->post('categoria')!=-1){
            $unidadMedida->idCategoria = $request->post('categoria');
        }
        $alert = array(
            'type' => 'success',
            'message' => 'El registro se ha guardado exitosamente',
        );

        session()->flash('alert', $alert);
        $unidadMedida->save();

        return back()->with('success', 'Guardado con éxito');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $unidadMedida = UnidadMedida::find($id);
        return view('inventario.unidadMedida.index')->with([
            'unidadMedidas' => UnidadMedida::all(),
            'unidadMedida' => $unidadMedida,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'unidadMedida' => 'required|unique:unidadmedida,unidadMedida,' . $id . ',idUnidadMedida',
            'simbolo' => 'required|unique:unidadmedida,simbolo,' . $id . ',idUnidadMedida|max:10',
            'categoria'=>'required'
        ],[
            'unidadMedida.unique' => 'Esta categoría ya ha sido utilizada.',
        ]);

        $unidadMedida = UnidadMedida::find($id);

        $unidadMedida->unidadMedida = $request->post('unidadMedida');
        if($request->post('categoria')==-1){
            $unidadMedida->idCategoria = null;
        }else{
            $unidadMedida->idCategoria = $request->post('categoria');
        }
        $unidadMedida->save();
        $alert = array(
            'type' => 'success',
            'message' => 'El registro se ha actualizado exitosamente',
        );

        session()->flash('alert', $alert);
        return redirect()->route('unidadMedidas.index')->with('unidadMedidas', UnidadMedida::all());
    }
    public function destroy($id)
    {
        $unidadMedida = UnidadMedida::find($id);

        if ($unidadMedida->recursos->isEmpty()) {
            $unidadMedida->delete();
            $alert = array(
                'type' => 'success',
                'message' => 'El registro se ha eliminado exitosamente',
            );
            session()->flash('alert', $alert);
        } else {
            $alert = array(
                'type' => 'error',
                'message' => 'No se puede eliminar el registro porque tiene datos asociados',
            );
            session()->flash('alert', $alert);
        }

        return view('inventario.unidadMedida.index')->with([
            'unidadMedidas' => UnidadMedida::all(),
        ]);
    }

    public function generarId()
    {
        // Obtener el último registro de la tabla "unidadMedida"
        $ultimoUnidadMedida = UnidadMedida::latest('idUnidadMedida')->first();

        if (!$ultimoUnidadMedida) {
            // Si no hay registros previos, comenzar desde CA0001
            $nuevoId = 'UM0001';
        } else {
            // Obtener el número del último idUnidadMedida
            $ultimoNumero = intval(substr($ultimoUnidadMedida->idUnidadMedida, 2));

            // Incrementar el número para el nuevo registro
            $nuevoNumero = $ultimoNumero + 1;

            // Formatear el nuevo idUnidadMedida con ceros a la izquierda
            $nuevoId = 'UM' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
        }

        return $nuevoId;
    }
}
