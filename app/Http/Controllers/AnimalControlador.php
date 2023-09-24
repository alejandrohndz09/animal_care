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
        $animales = Animal::where('estado', 1)->get();
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

        $animal = new Animal();
        $animal->idAnimal = $this->generarId();
        $animal->nombre = $request->post('nombre');
        $animal->fechaNacimiento = $request->post('fecha');
        $animal->idRaza = $request->post('raza');
        $animal->sexo = $request->post('sexo');
        $animal->estado = 1;
        $animal->particularidad = $request->post('particularidad');
        $animal->estado = 1;
        if ($request->hasFile('foto')) {
            $imagen = $request->file('foto');
            $nombreImagen = $animal->idAnimal . '.' . $imagen->getClientOriginalExtension();
            $rutaImagen = public_path('imagenes'); // Ruta donde deseas guardar la imagen
            $imagen->move($rutaImagen, $nombreImagen);
            // Aquí puedes guardar $nombreImagen en tu base de datos o realizar otras acciones necesarias.
            $animal->imagen = 'imagenes/' . $nombreImagen;
        }
        $alert = array(
            'type' => 'success',
            'message' =>'El registro se ha guardado exitosamente'
        );
        
        session()->flash('alert',$alert);
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
        $animal = Animal::find($id);
        return view('animal.index')->with([
            'animales' => Animal::where('estado', 1)->get(),
            'animal' => $animal
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
 
         $animal = Animal::find($id);
         
         $animal->nombre = $request->post('nombre');
         $animal->fechaNacimiento = $request->post('fecha');
         $animal->idRaza = $request->post('raza');
         $animal->sexo = $request->post('sexo');
         $animal->particularidad = $request->post('particularidad');
         if ($request->hasFile('foto')) {
             $imagen = $request->file('foto');
             $nombreImagen = $animal->idAnimal . '.' . $imagen->getClientOriginalExtension();
             $rutaImagen = public_path('imagenes'); // Ruta donde deseas guardar la imagen
             $imagen->move($rutaImagen, $nombreImagen);
             // Aquí puedes guardar $nombreImagen en tu base de datos o realizar otras acciones necesarias.
             $animal->imagen='imagenes/' . $nombreImagen;
         }
         $animal->save();
         $alert = array(
            'type' => 'success',
            'message' =>'El registro se ha actualizado exitosamente'
        );
        
        session()->flash('alert',$alert);
         return redirect()->route('animal.index')->with([
            'animales' => Animal::where('estado', 1)->get(),
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
        $animal = Animal::find($id);        
        if($animal->expedientes->isEmpty()){
          $animal->estado=0;
           $animal->save(); 
           $alert = array(
            'type' => 'success',
            'message' =>'El registro se ha eliminado exitosamente'
            );
        session()->flash('alert',$alert);
        }else{
            $alert = array(
                'type' => 'errror',
                'message' =>'No se puede eliminar el registro porque tiene datos asociados'
            );
            
            session()->flash('alert',$alert);
        }
        return view('animal.index')->with([
            'animales' => Animal::where('estado', 1)->get()
        ]);
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

    public function alta($id)
    {
        $miembros = Animal::find($id);
        $miembros->estado = '1';
        $miembros->save();
        return view('animal.index')->with([
            'animales' => Animal::where('estado', 1)->get()
        ]);
    }
}
