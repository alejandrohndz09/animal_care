<?php

namespace App\Http\Controllers;

use App\Models\Adopcion;
use Illuminate\Http\Request;

class AdopcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Formulario donde se agrega datos
        $adopciones = Adopcion::all();
        return view('adopcion.index')->with([
            'adopciones' => $adopciones,
        ]);
    }
    public function getAdopciones()
    {
        $adopciones = Adopcion::with('animal')->where('estado', 1)->get();
        
        return response()->json($adopciones);
    }
    public function store(Request $request)
    {
        $request->validate([
            // 'idAnimal' => 'required|unique:adopcion,idAnimal',
            // 'albergue' => 'required',
            'fecha' => 'required|date|before_or_equal:today',
            'estado' => 'required',
        ], [
            'idAnimal.unique' => 'Ya existe un adopcion de este animal.',
            'idAnimal.required' => 'El campo animal es requerido.',
            'albergue.required' => 'El campo albergue es requerido.',
            'fecha.before_or_equal' => 'La fecha ingresada no debe ser mayor a la de ahora.',
        ]);

        // Obtén el último registro de la tabla para determinar el siguiente incremento
        $ultimoRegistro = Adopcion::latest('idAdopcion')->first();

        // Calcula el siguiente incremento
        $siguienteIncremento = $ultimoRegistro ? (int) substr($ultimoRegistro->idMiembro, -4) + 1 : 1;

        // Crea el ID personalizado concatenando "MB" y el incremento
        $idPersonalizado = "EX" . str_pad($siguienteIncremento, 5, '0', STR_PAD_LEFT);

        //Guardar en BD
        $adopcion = new Adopcion();
        $adopcion->idAdopcion = $idPersonalizado;
        $adopcion->idAnimal = $request->post('animal');
        $adopcion->idAlvergue = $request->post('albergue');
        $adopcion->fechaIngreso = $request->post('fecha');
        $adopcion->estadoGeneral = $request->post('estado');
        $adopcion->estado = 1;
        $adopcion->save();

        return redirect()->route('adopcion.index');
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $adopcion = Adopcion::find($id);
        $adopciones = Adopcion::all();
        return view('adopcion.index')->with([
            'adopcion' => $adopcion,
            'adopciones' => $adopciones,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'idAnimal' => 'required|unique:miembro,idAnimal,' . $id . ',idAdopcion',
            'albergue' => 'required',
            'fecha' => 'required|date|before_or_equal:today',
            'estado' => 'required',
        ], [
            'idAnimal.unique' => 'Ya existe un adopcion de este animal.',
            'idAnimal.required' => 'El campo animal es requerido.',
            'albergue.required' => 'El campo albergue es requerido.',
            'fecha.before_or_equal' => 'La fecha ingresada no debe ser mayor a la de ahora.',
        ]);

        $adopcion = Adopcion::find($id);

        $adopcion->idAnimal = $request->post('animal');
        $adopcion->idAlvergue = $request->post('albergue');
        $adopcion->fechaIngreso = $request->post('fecha');
        $adopcion->estadoGeneral = $request->post('estado');
        $adopcion->save();

        return redirect()->route('adopcion.index');
    }

    public function destroy($id)
    {
        $adopcion = Adopcion::find($id);
        $adopcion->estado = '0';
        $adopcion->save();
        return redirect()->route('adopcion.index');
    }

    public function alta($id)
    {
        $adopcion = Adopcion::find($id);
        $adopcion->estado = '1';
        $adopcion->save();
        return redirect()->route('adopcion.index');
    }
}
