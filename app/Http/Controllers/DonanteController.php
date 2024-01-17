<?php

namespace App\Http\Controllers;

use App\Models\Donante;
use App\Models\TelefonoDonante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonanteController extends Controller
{

    public function index()
    {
        $donantes = Donante::all();
        return view('inventario.donante.index')->with([
            'donantes' => $donantes
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'dui' => 'required|unique:donante,dui',
            'nombres' => 'required|min:3',
            'apellidos' => 'required|min:3',
        ], [
            'dui.unique' => 'Este DUI ya ha sido ingresado.',
        ]);

        // if ($request->has('esMayorDeEdad') == '1') {
        //     // Si el campo 'esMayorDeEdad' está marcado, habilita la validación del campo 'dui'.
        //     $request->validate([
        //         'dui' => 'required|unique:miembro',
        //     ], [
        //         'dui.required' => 'El campo DUI es requerido.',
        //         'dui.unique' => 'Este DUI ya ha sido ingresado.',
        //     ]);
        // }

        // Obtén el último registro de la tabla para determinar el siguiente incremento
        $ultimoRegistro = donante::latest('idDonante')->first();

        // Calcula el siguiente incremento
        $siguienteIncremento = $ultimoRegistro ? (int) substr($ultimoRegistro->idDonante, -4) + 1 : 1;

        // Crea el ID personalizado concatenando "MB" y el incremento
        $idPersonalizado = "DO" . str_pad($siguienteIncremento, 5, '0', STR_PAD_LEFT);

        //Guardar en BD
        $donante = new Donante();
        $donante->idDonante = $idPersonalizado;
        $donante->dui = $request->post('dui');
        $donante->nombres = $request->post('nombres');
        $donante->apellidos = $request->post('apellidos');
        $donante->estado = 1;
        $donante->save();

        $telefonosAd = $request->input('telefonosAd');
        $telefonosAAsociar = [];

        foreach ($telefonosAd as $telefono) {
            $telefonosAAsociar[] = ['telefono' => $telefono];
        }

        $donante->telefono_donantes()->createMany($telefonosAAsociar);


        $donantes = Donante::all();
        return view('inventario.donante.index')->with([
            'donantes' => $donantes
        ]);
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $donanteEdit = Donante::where('idDonante', $id)->first();
        $donantes = Donante::all();

        return view('inventario.donante.index')->with([
            'donanteEdit' => $donanteEdit,
            'donantes' => $donantes,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dui' => 'required|unique:donante,dui,' . $id . ',idDonante',
            'nombres' => 'required|min:3',
            'apellidos' => 'required|min:3',
        ], [
            'dui.unique' => 'Este DUI ya ha sido ingresado.',
        ]);

        // Inicia una transacción para garantizar la integridad de los datos

        $donante = Donante::find($id);

        $donante->dui = $request->input('dui');
        $donante->nombres = $request->input('nombres');
        $donante->apellidos = $request->input('apellidos');
        
        $donante->save();

        // Actualiza o elimina los teléfonos existentes asociados al donante
        $telefonoIds = $request->input('telefonoIds', []);
        $telefonosAd = $request->input('telefonosAd', []);

        foreach ($donante->telefono_donantes as $telefono) {
            if (!in_array($telefono->idTelefono, $telefonoIds)) {
                $telefono->delete();
            }
        }

        // Asocia o actualiza los nuevos teléfonos
        foreach ($telefonosAd as $index => $telefono) {
            $telefonoId = isset($telefonoIds[$index]) ? $telefonoIds[$index] : null;

            if ($telefonoId) {
                // Actualiza el teléfono existente
                $telefonoDonante = TelefonoDonante::find($telefonoId);
                $telefonoDonante->telefono = $telefono;
                $telefonoDonante->save();
            } else {
                // Crea un nuevo teléfono
                $telefonoDonante = new TelefonoDonante();
                $telefonoDonante->telefono = $telefono;
                $donante->telefono_donantes()->save($telefonoDonante);
            }
        }
        $donantes = Donante::all();
        return view('inventario.donante.index')->with([
            'donantes' => $donantes
        ]);
    }

    public function destroy($id)
    {
        Donante::where('idDonante', $id)->delete();
        $donantes = Donante::all();
        return view('inventario.donante.index')->with([
            'donantes' => $donantes
        ]);
    }

    public function DarBaja($id)
    {
        $donante = Donante::find($id);
        $donante->estado = '0';
        $donante->save();
        $donantes = Donante::all();
        return view('inventario.donante.index')->with([
            'donantes' => $donantes
        ]);
    }

    public function DarAlta($id)
    {
        $donante = Donante::find($id);
        $donante->estado = '1';
        $donante->save();
        $donantes = Donante::all();
        return view('inventario.donante.index')->with([
            'donantes' => $donantes
        ]);
    }

    public function ObtenerTelefonos($id)
    {

        $telefonos = TelefonoDonante::where('idDonante', $id)->pluck('telefono');

        return response()->json($telefonos);
    }
}
