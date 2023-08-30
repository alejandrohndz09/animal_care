<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Miembro;
use Illuminate\Http\Request;

class MiembroController extends Controller
{

    public function index()
    {
        //Pagina inicio
        $datos = Miembro::all();
        return view('miembro.index')->with('datos', $datos);
    }

    public function create()
    {
        //Formulario donde se agrega datos
        return view('miembro.index');
    }
    
    public function store(Request $request)
    {
        // Obtén el último registro de la tabla para determinar el siguiente incremento
        $ultimoRegistro = Miembro::latest('idMiembro')->first();

        // Calcula el siguiente incremento
        $siguienteIncremento = $ultimoRegistro ? (int) substr($ultimoRegistro->idMiembro, -4) + 1 : 1;

        // Crea el ID personalizado concatenando "MB" y el incremento
        $idPersonalizado = "MB" . str_pad($siguienteIncremento, 5, '0', STR_PAD_LEFT);

        $miembros = new Miembro();
        $miembros->idMiembro = $idPersonalizado;
        $miembros->nombres = $request->post('nombres');
        $miembros->apellidos = $request->post('apellidos');
        $miembros->correo = $request->post('correo');
        $miembros->estado = 0;
        $miembros->save();

        return redirect()->route("miembros.index")->with("success", "Agregado con exito!");
    }

    public function show($id)
    {
        //Obtiene un registro en especifico de una tabla
    }
    public function edit($id)
    {
        //Trae los datos que seran editados y los coloca en un formulario
        $miembros = Miembro::find($id);
        $datos = Miembro::all();
        return view('miembro.index', [
            'miembros' => $miembros,
            'datos' => $datos
        ]);
    }

    public function update(Request $request, $id)
    {
        //Actualiza los datos en la BD
        $miembros = Miembro::find($id);
        $miembros->nombres = $request->post('nombres');
        $miembros->apellidos = $request->post('apellidos');
        $miembros->correo = $request->post('correo');
        $miembros->save();

        return redirect()->route("miembros.index")->with("success", "Actualizado con exito!");
    }

    public function destroy($id)
    {
        //
    }
}
