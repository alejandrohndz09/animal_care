<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Raza;
use Illuminate\Http\Request;

class AnimalControlador extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $animales=Animal::where('estado',1)->get();
        $animales = Animal::all();
        return view('animal.index')->with('animales', $animales);
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
            'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Puedes ajustar las reglas de validación según tus necesidades
            'nombre' => 'required',
            'especie' => 'required',
            'fecha' => 'required|date|before_or_equal:today',
            'raza' => 'required',
            'sexo' => 'required|in:Hembra,Macho'
        ]);

        $animal = new Animal();
        $animal->idAnimal = $this->generarId();
        $animal->nombre = $request->post('nombre');
        $animal->fechaNacimiento = $request->post('fecha');
        $animal->raza = $request->post('raza');
        $animal->sexo = $request->post('sexo');

        // Obtener el archivo de imagen
        $imagen = $request->file('imagen');
        // Generar un nombre único para la imagen
        $nombreImagen = $animal->idAnimal;
        // Guardar la imagen en el directorio de almacenamiento
        $imagen->move(public_path('imagenes'), $nombreImagen);
        // Puedes almacenar la ruta de la imagen en la base de datos si es necesario
        $animal->imagen = 'imagenes/' . $nombreImagen;

        $animal->save();

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generarId()
    {
        // Obtener el último registro de la tabla "animal"
        $ultimoAnimal = Animal::latest('idAnimal')->first();

        if (!$ultimoAnimal) {
            // Si no hay registros previos, comenzar desde AN0001
            $nuevoId = 'AN0001';
        } else {
            // Obtener el número del último idAnimal
            $ultimoNumero = intval(substr($ultimoAnimal->idAnimal, 2));

            // Incrementar el número para el nuevo registro
            $nuevoNumero = $ultimoNumero + 1;

            // Formatear el nuevo idAnimal con ceros a la izquierda
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
