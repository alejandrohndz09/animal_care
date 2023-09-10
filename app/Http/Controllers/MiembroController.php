<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Miembro;
use App\Models\TelefonoMiembro;
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
        $request->validate([
            'correo' => 'unique:miembro',
            'dui' => 'unique:miembro'
        ]);

        // Obtén el último registro de la tabla para determinar el siguiente incremento
        $ultimoRegistro = Miembro::latest('idMiembro')->first();

        // Calcula el siguiente incremento
        $siguienteIncremento = $ultimoRegistro ? (int) substr($ultimoRegistro->idMiembro, -4) + 1 : 1;

        // Crea el ID personalizado concatenando "MB" y el incremento
        $idPersonalizado = "MB" . str_pad($siguienteIncremento, 5, '0', STR_PAD_LEFT);

        //Guardar en BD
        $miembros = new Miembro();
        $miembros->idMiembro = $idPersonalizado;
        $miembros->dui = $request->post('dui');
        $miembros->nombres = $request->post('nombres');
        $miembros->apellidos = $request->post('apellidos');
        $miembros->correo = $request->post('correo');
        $miembros->estado = 0;
        $miembros->save();

        $contador = $request->post('con');


        for ($i = 1; $i <= $contador; $i++) {
            $telefonos = new TelefonoMiembro();
            $telefonos->telefono = $request->post('telefono' . $i);
            $telefonos->idMiembro = $idPersonalizado;
            $telefonos->save();
        }

        return redirect()->route("miembros.index")->with("success", "Agregado con exito!");
    }

    public function edit($id)
    {
        $miembroEdit = Miembro::find($id);
        $datos = Miembro::all();
        $telefonos = TelefonoMiembro::where('idMiembro', $miembroEdit->idMiembro)->get();

        return view('miembro.index')->with('miembroEdit', $miembroEdit)->with('datos', $datos)->with('telefonos', $telefonos);
    }

    public function update(Request $request, $id)
    {

        $miembros = Miembro::find($id);


        //Valida si estan en la BD
        $request->validate([
            'correo' => 'unique:miembro,correo,' . $id . ',idMiembro',
            'dui' => 'unique:miembro,dui,' . $id . ',idMiembro'
        ]);

        //Actualiza los datos en la BD
        $miembros->dui = $request->post('dui');
        $miembros->nombres = $request->post('nombres');
        $miembros->apellidos = $request->post('apellidos');
        $miembros->correo = $request->post('correo');
        $miembros->save();


        $contador = $request->post('con');
        // dd($request->post('con'));
        for ($i = 2; $i <= $contador; $i++) {

            $nuevoTelefono = $request->post('telefono' . $i);
            // Busca el teléfono por su número de teléfono en la base de datos
            $telefono = TelefonoMiembro::where('telefono', $nuevoTelefono)->first();

            if ($telefono) {
                // El teléfono existe en la base de datos, actualiza su valor
                $telefono->telefono = $nuevoTelefono;
                $telefono->save();
            } else {
                //Sino entonces crea un nuevo registro
                $telefonos = new TelefonoMiembro();
                $telefonos->telefono = $request->post('telefono' . $i);
                $telefonos->idMiembro = $id;
                $telefonos->save();
            }
        }




        return redirect()->route("miembros.index")->with("success", "Actualizado con exito!");
    }

    public function destroy($id)
    {
        $miembros = Miembro::find($id);
        $miembros->estado = '1';
        $miembros->save();
    }

    public function destroyTelefono($telefonoId)
    {
        $telefono = TelefonoMiembro::find($telefonoId);

        if (!$telefono) {
            return response()->json(['message' => 'El teléfono no se encontró o ya fue eliminado.'], 404);
        }

        $telefono->delete();

        return response()->json(['message' => 'Teléfono eliminado con éxito.']);
    }
}
