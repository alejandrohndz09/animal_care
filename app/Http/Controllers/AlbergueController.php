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
        ], [
            'direccion.unique' => 'Esta dirección ya ha sido utilizada.',
        ]);

        //Guardar en BD
        $Albergue = new Alvergue();
        $Albergue->idAlvergue = $this->generarId();
        $Albergue->direccion = $request->post('direccion');
        $Albergue->idMiembro = $request->post('miembro');
        $Albergue->estado = 1;
        $Albergue->save();

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
        return view('albergue.detalle')->with([
            'albergue' => Alvergue::find($id),
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
            'direccion' => 'required|unique:alvergue,direccion,' . $id . ',idAlvergue',
            'miembro' => 'required'
        ], [
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
        $Albergue->estado = 0;
        $Albergue->save();

        return redirect()->route('albergue.index');
    }

    public function alta($id)
    {
        $Albergue = Alvergue::find($id);
        $Albergue->estado = 1;
        $Albergue->save();
        return redirect()->route('albergue.index');
    }

    public function generarId()
    {
        // Obtener el último registro de la tabla "animal"
        $ultimoRegistro = Alvergue::latest('idAlvergue')->first();

        if (!$ultimoRegistro) {
            // Si no hay registros previos, comenzar desde AN0001
            $nuevoId = 'AL0001';
        } else {
            // Obtener el número del último id
            $ultimoNumero = intval(substr($ultimoRegistro->idAlvergue, 2));

            // Incrementar el número para el nuevo registro
            $nuevoNumero = $ultimoNumero + 1;

            // Formatear el nuevo idAnimal con ceros a la izquierda
            $nuevoId = 'AL' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
        }

        return $nuevoId;
    }
}
