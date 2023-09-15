<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alvergue;
use App\Models\Miembro;
use Illuminate\Http\Request;

class AlbergueController extends Controller
{

    public function index()
    {
        $miembros = Miembro::all();
        $albergues = Alvergue::all();
        return view('albergue.index')->with([
            'collection' => $miembros,
            'Albergues' => $albergues,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        // Obtén el último registro de la tabla para determinar el siguiente incremento
        $ultimoRegistro = Alvergue::latest('idAlvergue')->first();

        // Calcula el siguiente incremento
        $siguienteIncremento = $ultimoRegistro ? (int) substr($ultimoRegistro->idMiembro, -4) + 1 : 1;

        // Crea el ID personalizado concatenando "MB" y el incremento
        $idPersonalizado = "AL" . str_pad($siguienteIncremento, 5, '0', STR_PAD_LEFT);

        //Guardar en BD
        $miembros = new Alvergue();
        $miembros->idAlvergue = $idPersonalizado;
        $miembros->direccion = $request->post('direccion');
        $miembros->idMiembro = $request->post('miembro');
        $miembros->save();

        $miembros = Miembro::all();
        $Albergues = Alvergue::all();
        return view('albergue.index')->with([
            'collection' => $miembros,
            'Albergues' => $Albergues,
            "success", "Actualizado con exito!"
        ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $AlbergueEdit = Alvergue::find($id);
        $miembros = Miembro::all();
        $Albergues = Alvergue::all();

        return view('albergue.index')->with([
            'collection' => $miembros,
            'Albergues' => $Albergues,
            'AlbergueEdit' => $AlbergueEdit
        ]);
    }

    public function update(Request $request, $id)
    {
        $albergue = Alvergue::find($id);


        //Actualiza los datos en la BD
        $albergue->direccion = $request->post('direccion');
        $albergue->idMiembro = $request->post('miembro');
        $albergue->save();


        $miembros = Miembro::all();
        $albergues = Alvergue::all();

        return view('albergue.index')->with([
            'collection' => $miembros,
            'Albergues' => $albergues,
            "success", "Actualizado con exito!"
        ]);
    }

    public function destroy($id)
    {
        $Albergue = Alvergue::find($id);
        if (!$Albergue) {
            return response()->json(['message' => 'El teléfono no se encontró o ya fue eliminado.'], 404);
        }

        $Albergue->delete();

        return response()->json(['message' => 'Teléfono eliminado con éxito.']);
    }
}
