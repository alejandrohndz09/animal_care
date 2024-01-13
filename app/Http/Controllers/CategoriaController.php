<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view('inventario.categoria.index')->with('categorias', $categorias);
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
            'categoria' => 'required|unique:categoria|min:4', // Puedes ajustar las reglas de validación según tus necesidades
        ],[
            'categoria.unique' => 'Esta categoría ya ha sido utilizada.',
        ]);

        $categoria = new Categoria();
        $categoria->idCategoria = $this->generarId();
        $categoria->categoria = $request->post('categoria');
        $alert = array(
            'type' => 'success',
            'message' => 'El registro se ha guardado exitosamente',
        );

        session()->flash('alert', $alert);
        $categoria->save();

        return back()->with('success', 'Guardado con éxito');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $categoria = Categoria::find($id);
        return view('inventario.categoria.index')->with([
            'categorias' => Categoria::all(),
            'categoria' => $categoria,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'categoria' => 'required|unique:categoria,categoria,' . $id . ',idCategoria',
        ],[
            'categoria.unique' => 'Esta categoría ya ha sido utilizada.',
        ]);

        $categoria = Categoria::find($id);

        $categoria->categoria = $request->post('categoria');

        $categoria->save();
        $alert = array(
            'type' => 'success',
            'message' => 'El registro se ha actualizado exitosamente',
        );

        session()->flash('alert', $alert);
        return redirect()->route('categorias.index')->with('categorias', Categoria::all());
    }
    public function destroy($id)
    {
        $categoria = Categoria::find($id);

        if ($categoria->recursos->isEmpty()) {
            $categoria->delete();
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

        return view('inventario.categoria.index')->with([
            'categorias' => Categoria::all(),
        ]);
    }

    public function generarId()
    {
        // Obtener el último registro de la tabla "categoria"
        $ultimoCategoria = Categoria::latest('idCategoria')->first();

        if (!$ultimoCategoria) {
            // Si no hay registros previos, comenzar desde CA0001
            $nuevoId = 'CA0001';
        } else {
            // Obtener el número del último idCategoria
            $ultimoNumero = intval(substr($ultimoCategoria->idCategoria, 2));

            // Incrementar el número para el nuevo registro
            $nuevoNumero = $ultimoNumero + 1;

            // Formatear el nuevo idCategoria con ceros a la izquierda
            $nuevoId = 'CA' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
        }

        return $nuevoId;
    }
}
