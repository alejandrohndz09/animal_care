<?php

namespace App\Http\Controllers;

use App\Models\Raza;
use App\Models\Raza;
use Illuminate\Http\Request;

class RazaControlador extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $razas = Raza::all();
        return view('raza.index')->with('razas', $razas);
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
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:3000', // Puedes ajustar las reglas de validación según tus necesidades
            'nombre' => 'required|min:3',
            'especie' => 'required',
            'fecha' => 'required|date|before_or_equal:today',
            'raza' => 'required',
            'sexo' => 'required|in:Hembra,Macho',
        ], [
            'foto.required' => 'La Fotografía es necesaria.',
            'fecha.before_or_equal' => 'La fecha ingresada no debe ser mayor a la de ahora.',
        ]);

        $raza = new Raza();
        $raza->idRaza = $this->generarId();
        $raza->nombre = $request->post('nombre');
        $raza->fechaNacimiento = $request->post('fecha');
        $raza->idRaza = $request->post('raza');
        $raza->sexo = $request->post('sexo');
        $raza->estado = 1;
        $raza->particularidad = $request->post('particularidad');
        $raza->estado =1;
        if ($request->hasFile('foto')) {
            $imagen = $request->file('foto');
            $nombreImagen = $raza->idRaza . '.' . $imagen->getClientOriginalExtension();
            $rutaImagen = public_path('imagenes'); // Ruta donde deseas guardar la imagen
            $imagen->move($rutaImagen, $nombreImagen);
            // Aquí puedes guardar $nombreImagen en tu base de datos o realizar otras acciones necesarias.
            $raza->imagen = 'imagenes/' . $nombreImagen;
        }
        $raza->save();

        return back()->with('success', 'Guardado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $raza = Raza::find($id);
        return view('raza.index')->with([
            'razas' => Raza::where('estado', 1)->get(),
            'raza' => $raza
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'foto' => 'image|mimes:jpeg,png,jpg|max:3000', // Puedes ajustar las reglas de validación según tus necesidades
             'nombre' => 'required|min:3',
             'especie' => 'required',
             'fecha' => 'required|date|before_or_equal:today',
             'raza' => 'required',
             'sexo' => 'required|in:Hembra,Macho',
         ], [
             'fecha.before_or_equal' => 'La fecha ingresada no debe ser mayor a la de ahora.',
         ]);
 
         $raza = Raza::find($id);
         
         $raza->nombre = $request->post('nombre');
         $raza->fechaNacimiento = $request->post('fecha');
         $raza->idRaza = $request->post('raza');
         $raza->sexo = $request->post('sexo');
         $raza->particularidad = $request->post('particularidad');
         if ($request->hasFile('foto')) {
             $imagen = $request->file('foto');
             $nombreImagen = $raza->idRaza . '.' . $imagen->getClientOriginalExtension();
             $rutaImagen = public_path('imagenes'); // Ruta donde deseas guardar la imagen
             $imagen->move($rutaImagen, $nombreImagen);
             // Aquí puedes guardar $nombreImagen en tu base de datos o realizar otras acciones necesarias.
             $raza->imagen='imagenes/' . $nombreImagen;
         }
         $raza->save();
 
         return redirect()->route('raza.index')->with([
            'razas' => Raza::where('estado', 1)->get(),
            'success' => 'Guardado con éxito'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $raza = Raza::find($id);
        $raza->estado=0;
        $raza->save();
        
        return view('raza.index')->with([
            'razas' => Raza::where('estado', 1)->get()
        ]);
    }

    public function generarId()
    {
        // Obtener el último registro de la tabla "raza"
        $ultimoRaza = Raza::latest('idRaza')->first();

        if (!$ultimoRaza) {
            // Si no hay registros previos, comenzar desde AN0001
            $nuevoId = 'AN0001';
        } else {
            // Obtener el número del último idRaza
            $ultimoNumero = intval(substr($ultimoRaza->idRaza, 2));

            // Incrementar el número para el nuevo registro
            $nuevoNumero = $ultimoNumero + 1;

            // Formatear el nuevo idRaza con ceros a la izquierda
            $nuevoId = 'AN' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
        }

        return $nuevoId;
    }
    public static function calcularEdad($fechaNacimiento)
    {
        $fechaNacimiento = new \DateTime($fechaNacimiento);
        $hoy = new \DateTime();

        $diferencia = $hoy->diff($fechaNacimiento);

        $edadEnAnios = $diferencia->y;
        $edadEnMeses = $diferencia->m;

        $edadTexto = '';

        if ($edadEnAnios > 0) {
            $edadTexto .= $edadEnAnios == 1 ? '1 año' : "$edadEnAnios años";
        }

        if ($edadEnMeses > 0) {
            if ($edadEnAnios > 0) {
                $edadTexto .= ' con ';
            }

            $edadTexto .= $edadEnMeses == 1 ? '1 mes' : "$edadEnMeses meses";
        }

        if (empty($edadTexto)) {
            $edadTexto = 'Menos de 1 mes';
        }

        return $edadTexto;
    }

    public function obtenerRazas($especie)
    {
        // Obtén las razas relacionadas con la especie seleccionada
        $razas = Raza::where('idEspecie', $especie)->get();
        // Devuelve las razas en formato JSON
        return response()->json($razas);
    }
}
