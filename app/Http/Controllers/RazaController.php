<?php

namespace App\Http\Controllers;

use App\Models\Raza;
use Illuminate\Http\Request;

class RazaController extends Controller
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
            'especie' => 'required',
            'raza' => 'required|min:3|unique:raza'
            
        ], [
            'raza.unique' => 'Esta raza ya ha sido ingresada.',
        ]);

        $raza = new Raza();
        $raza->idRaza = $this->generarId();
        $raza->raza = $request->post('raza');
        $raza->idEspecie = $request->post('especie');
        
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
            'razas' => Raza::all(),
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
             'especie' => 'required',
             'raza' => 'required|min:3|unique:raza,raza,'.$id.',idRaza'
             
         ], [
             'raza.unique' => 'Esta raza ya ha sido ingresada.',
         ]);
 
         $raza = Raza::find($id);
         
         $raza->idEspecie = $request->post('especie');
         $raza->raza = $request->post('raza');
         $raza->save();
 
         return redirect()->route('raza.index')->with([
            'razas' => Raza::all(),
            'success' => 'Modificado con éxito'
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
        
        
        if($raza->animals->isEmpty()){
            $raza->delete();
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
        return view('raza.index')->with([
            'razas' => Raza::all()
        ]);
    }

    public function generarId()
    {
        // Obtener el último registro de la tabla "raza"
        $ultimoRaza = Raza::latest('idRaza')->first();

        if (!$ultimoRaza) {
            // Si no hay registros previos, comenzar desde AN0001
            $nuevoId = 'RAZ001';
        } else {
            // Obtener el número del último idRaza
            $ultimoNumero = intval(substr($ultimoRaza->idRaza, 3));

            // Incrementar el número para el nuevo registro
            $nuevoNumero = $ultimoNumero + 1;

            // Formatear el nuevo idRaza con ceros a la izquierda
            $nuevoId = 'RAZ' . str_pad($nuevoNumero, 3, '0', STR_PAD_LEFT);
        }

        return $nuevoId;
    }
   
}
