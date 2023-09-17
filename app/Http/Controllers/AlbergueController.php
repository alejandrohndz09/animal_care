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
        $albergues = Alvergue::all();
        return view('albergue.index')->with([
            'Albergues' => $albergues
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'direccion' => 'required|unique:alvergue',
            'miembro' => 'required'
        ],[
            'direccion.unique' => 'Esta dirección ya ha sido utilizada.',
        ]);

        //Guardar en BD
        $miembros = new Alvergue();
        $miembros->idAlvergue = $this->generarId();
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


        //Valida si estan en la BD excluyendo al registro modificado
        $request->validate([
            'direccion' => 'required|unique:alvergue,direccion,'. $id . ',idAlvergue',
            'miembro' => 'required'
        ],[
            'direccion.unique' => 'Esta dirección ya ha sido utilizada.',
        ]);

        $albergue = Alvergue::find($id);

        //Actualiza los datos en la BD
        $albergue->direccion = $request->post('direccion');
        $albergue->idMiembro = $request->post('miembro');
        $albergue->save();

        return redirect()->route("albergue.index");
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

    public function generarId()
    {
        // Obtener el último registro de la tabla "animal"
        $ultimoAnimal = Alvergue::latest('idAlvergue')->first();

        if (!$ultimoAnimal) {
            // Si no hay registros previos, comenzar desde AN0001
            $nuevoId = 'AL0001';
        } else {
            // Obtener el número del último idAnimal
            $ultimoNumero = intval(substr($ultimoAnimal->idAnimal, 2));

            // Incrementar el número para el nuevo registro
            $nuevoNumero = $ultimoNumero + 1;

            // Formatear el nuevo idAnimal con ceros a la izquierda
            $nuevoId = 'AL' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
        }

        return $nuevoId;
    }
}
