<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Miembro;
use App\Models\TelefonoMiembro;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Importa la fachada Validator


class MiembroController extends Controller
{


    public function index()
    {
        //Pagina inicio
        $datos = Miembro::all();
        return view('miembro.index')->with([
            'datos' => $datos
        ]);
    }

    public function create()
    {
        //Formulario donde se agrega datos
        return view('miembro.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'correo' => 'required|unique:miembro',
            'dui' => 'required|unique:miembro',
            'nombres' => 'required|min:3',
            'apellidos' => 'required|min:3',
        ],[
            'correo.unique' => 'Este correo ya ha sido ingresado.',
            'dui.unique' => 'Este DUI ya ha sido ingresado.'
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
        $miembros->estado = 1;
        $miembros->save();

        $contador = $request->post('con');


        for ($i = 1; $i <= $contador; $i++) {
            $telefonos = new TelefonoMiembro();
            $telefonos->telefono = $request->post('telefono' . $i);
            $telefonos->idMiembro = $idPersonalizado;
            $telefonos->save();
        }

        $datos = Miembro::all();
        // Configura la variable de sesión de éxito
        Session::flash('success', 'Agregado exitosamente!');
        return view('miembro.index')->with([
            'datos' => $datos,
        ]);
    }

    public function edit($id)
    {
        $miembroEdit = Miembro::find($id);
        $datos = Miembro::all();
        //Busca en la tabla Telefono_miembro el idMiembro para modificar
        $telefonos = TelefonoMiembro::where('idMiembro', $miembroEdit->idMiembro)->get();

        return view('miembro.index')->with([
            'miembroEdit' => $miembroEdit,
            'datos' => $datos,
            'telefonos' => $telefonos
        ]);
    }

    public function update(Request $request, $id)
    {
        $miembro = Miembro::find($id);
    
        // Valida si los campos únicos (correo y dui) están en la BD
        $request->validate([

            'correo' => 'required|unique:miembro,correo,' . $id . ',idMiembro',
            'dui' => 'required|min:10|unique:miembro,dui,' . $id . ',idMiembro',
            'nombres' => 'required|min:3',
            'apellidos' => 'required|min:3',
        ],[
            'correo.unique' => 'Este correo ya ha sido ingresado.',
            'dui.unique' => 'Este DUI ya ha sido ingresado.'
        ]);
    
        // Actualiza los datos en la BD
        $miembro->dui = $request->post('dui');
        $miembro->nombres = $request->post('nombres');
        $miembro->apellidos = $request->post('apellidos');
        $miembro->correo = $request->post('correo');
        $miembro->save();
    
        $contador = $request->post('con');
        for ($i = 1; $i <= $contador; $i++) {
            $nuevoTelefono = $request->post('telefono' . $i);
            $telefonoId = $request->input('boton' . $i);
            // Genera dinámicamente la regla de validación para cada campo de teléfono
            $validationRules['telefono' . $i] = 'unique:telefono_miembro,telefono,' . $telefonoId . ',idTelefono';
    
            // Aplica las reglas de validación generadas dinámicamente
            try {
                $request->validate($validationRules);
    
                // Busca el teléfono por su ID en la base de datos
                $telefono = TelefonoMiembro::find($telefonoId);
    
                if ($telefono) {
                    // El teléfono existe en la base de datos, actualiza su valor
                    $telefono->telefono = $nuevoTelefono;
                    $telefono->save();
                } else {
                    // Sino, entonces crea un nuevo registro
                    $telefonos = new TelefonoMiembro();
                    $telefonos->telefono = $request->post('telefono' . $i);
                    $telefonos->idMiembro = $id;
                    $telefonos->save();
                }
            } catch (ValidationException $e) {
                // Captura la excepción de validación
                $errors = $e->validator->getMessageBag();
                return redirect()->route("miembro.edit", $id)->withErrors($errors)->withInput();
            }
        }
    
        return redirect()->route("miembro.index");
    }
    

    public function destroy($id)
    {
        $miembros = Miembro::find($id);
        $miembros->estado = '0';
        $miembros->save();
        $datos = Miembro::all();
        return view('miembro.index')->with([
            'datos' => $datos
        ]);
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

    public function ObtenerTelefonos($id)
    {

        $telefonos = TelefonoMiembro::where('idMiembro', $id)->pluck('telefono');

        return response()->json($telefonos);
    }

    public function validarTelefono(Request $request)
    {
        // Realiza la validación del número de teléfono aquí
        $validator = Validator::make($request->all(), [
            'telefono' => 'required|numeric|unique', // Agrega las reglas de validación necesarias
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Devuelve los errores en formato JSON
        }

        return response()->json(['message' => 'Número de teléfono válido']); // Si la validación es exitosa
    }
}
