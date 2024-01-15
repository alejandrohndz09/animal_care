<?php

namespace App\Http\Controllers;

use App\Models\Adopcion;
use App\Models\Adoptante;
use App\Models\Expediente;
use App\Models\Hogar;
use App\Rules\EmptyIf503;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $adopciones = Adopcion::where('estado', 1)->orderByDesc('aceptacion')
            ->orderByDesc('fechaTramiteInicio')->get();
        return view('adopcion.index')->with([
            'adopciones' => $adopciones,
        ]);
    }

    public function create()
    {
        if (session('expElegido')) {
            $expElegido = session('expElegido');
        } else {
            $expElegido = null;
        }

        if (session('adElegido')) {
            $adElegido = session('adElegido');
        } else {
            $adElegido = null;
        }
        return view('adopcion.form')->with(
            [
                'expElegido' => $expElegido,
                'adElegido' => $adElegido,
            ]
        );
    }

    public function store(Request $request)
    {
        if (empty($request->input('idAdoptante'))) {

            $request->validate([
                'expA' => 'required|exists:expediente,idExpediente',
                'required_if:idAdoptante,' . request('idAdoptante') . '|exists:adoptante,idAdoptante',
                'nombres' => 'required|min:3',
                'apellidos' => 'required|min:3',
                'dui' => [
                    'required',
                    Rule::unique('adoptante', 'dui'),
                    Rule::unique('miembro', 'dui'),
                    Rule::unique('donante', 'dui'),
                ],
                'telefonosAd' => 'required|array|distinct',
                'telefonosAd.*' => [
                    'required',
                    Rule::unique('telefono_adoptante', 'telefono'),
                    Rule::unique('telefono_miembro', 'telefono'),
                    Rule::unique('telefono_donante', 'telefono'),
                    new EmptyIf503,
                ],
                'direccion' => 'required|unique:hogar,direccion',
                'tamanioHogar' => 'required|in:Grande,Mediano,Pequeño',
                'companiaHumana' => 'required|numeric|min:1',
                'isCompaniaAnimal' => 'required|in:Sí,No',
                'companiaAnimal' => 'required_if:isCompaniaAnimal,Sí|numeric|min:1',

            ], [
                'required' => 'Este campo es requerido.',
                'expA.required' => 'No ha seleccionado nigún expediente.',
                'expA.exist' => 'El expediente especificado no se ha encontrado, seleccione uno de nuevo.',
                'idAdoptante.exist' => 'El adoptante especificado no se ha encontrado, seleccione uno de nuevo o regístrelo.',
                'telefonosAd.*.unique' => 'Este número ya ha sido ingresado.',
                'dui.unique' => 'Este dui ya ha sido ingresado.',
                'direccion.unique' => 'Esta dirección ya ha sido ingresada.',
            ]);
        } else {
            $request->validate([
                'expA' => 'required|exists:expediente,idExpediente',
                'idAdoptante' => 'required_if:idAdoptante,' . request('idAdoptante') . '|exists:adoptante,idAdoptante',
                'nombres' => 'required|min:3',
                'apellidos' => 'required|min:3',
                'dui' => [
                    'required',
                    'unique:adoptante,dui,' . request('idAdoptante') . ',idAdoptante',
                    'unique:miembro,dui',
                    'unique:donante,dui',
                ],
                'telefonosAd' => 'required|array|distinct',
                'telefonosAd.*' => [
                    'required',
                    'unique:telefono_adoptante,telefono,' . request('idAdoptante') . ',idAdoptante',
                    'unique:telefono_miembro,telefono',
                    'unique:telefono_donante,telefono',
                    new EmptyIf503,
                ],
                'direccion' => 'required|unique:hogar,direccion,' . request('idHogar') . ',idHogar',
                'tamanioHogar' => 'required|in:Grande,Mediano,Pequeño',
                'companiaHumana' => 'required|numeric|min:1',
                'isCompaniaAnimal' => 'required|in:Sí,No',
                'companiaAnimal' => 'required_if:isCompaniaAnimal,Sí|numeric|min:1',

            ], [
                'required' => 'Este campo es requerido.',
                'expA.required' => 'No ha seleccionado nigún expediente.',
                'expA.exist' => 'El expediente especificado no se ha encontrado, seleccione uno de nuevo.',
                'idAdoptante.exist' => 'El adoptante especificado no se ha encontrado, seleccione uno de nuevo o regístrelo.',
                'telefonosAd.*.unique' => 'Este número ya ha sido ingresado.',
                'dui.unique' => 'Este dui ya ha sido ingresado.',
                'direccion.unique' => 'Esta dirección ya ha sido ingresada.',
            ]);
        }

        // si no se ha elegido un adoptante registrado...
        if (empty($request->input('idAdoptante'))) {

            DB::beginTransaction();
            try {
                // Crea un nuevo registro en la tabla de hogar
                $hogar = Hogar::create([
                    'idHogar' => $this->generarIdHogar(),
                    'direccion' => $request->input('direccion'),
                    'companiaHumana' => $request->input('companiaHumana'),
                    'companiaAnimal' => $request->input('isCompaniaAnimal') == 'Sí' ? $request->input('companiaAnimal') : 0,
                    'tamanioHogar' => $request->input('tamanioHogar'),
                    'estado' => 1,
                ]);
                // Crea un nuevo registro en la tabla de adoptantes
                $adoptante = Adoptante::create([
                    'idAdoptante' => $this->generarIdAdoptante(),
                    'nombres' => $request->input('nombres'),
                    'apellidos' => $request->input('apellidos'),
                    'dui' => $request->input('dui'),
                    'idHogar' => $hogar->idHogar,
                    'estado' => 1,
                    // Otros atributos de la tabla de adoptantes
                ]);
                $telefonosAd = $request->input('telefonosAd');
                $telefonosAAsociar = [];

                foreach ($telefonosAd as $telefono) {
                    $telefonosAAsociar[] = ['telefono' => $telefono];
                }

                $adoptante->telefono_adoptantes()->createMany($telefonosAAsociar);

                // Crea un nuevo registro en la tabla de adopciones
                $adoption = Adopcion::create([
                    'idAdopcion' => $this->generarIdAdopcion(),
                    'fechaTramiteInicio' => date('Y-m-d'),
                    'idAdoptante' => $adoptante->idAdoptante,
                    'idExpediente' => $request->input('expA'),
                    'aceptacion' => 0,
                    'estado' => 1,
                ]);
                Expediente::where('idExpediente', $request->input('expA'))->update(['estadoGeneral' => 'En proceso de adopción']);
                // Confirma la transacción
                DB::commit();
                $alert = array(
                    'type' => 'success',
                    'message' => 'Operación exitosa',
                );
                session()->flash('alert', $alert);
                return redirect('/adopcion/' . $adoption->idAdopcion)
                    ->with($alert);
            } catch (\Exception $e) {
                // En caso de error, realiza un rollback de la transacción
                DB::rollBack();
                $alert = array(
                    'type' => 'error',
                    'message' => 'Operación fallida',
                );
                session()->flash('alert', $alert);
                return back()
                    ->withInput()
                    ->with('error', 'Error al guardar los registros.');
            }
        } else {
            DB::beginTransaction();
            try {
                $adoption = Adopcion::create([
                    'idAdopcion' => $this->generarIdAdopcion(),
                    'fechaTramiteInicio' => date('Y-m-d'),
                    'idAdoptante' => $request->input('idAdoptante'),
                    'idExpediente' => $request->input('expA'),
                    'aceptacion' => 0,
                    'estado' => 1,
                ]);
                Expediente::where('idExpediente', $request->input('expA'))->update(['estadoGeneral' => 'En proceso de adopción']);
                // Confirma la transacción
                DB::commit();

                $alert = array(
                    'type' => 'success',
                    'message' => 'Operación exitosa',
                );
                session()->flash('alert', $alert);
                return redirect('/adopcion/' . $adoption->idAdopcion)
                    ->with($alert);
            } catch (\Exception $e) {
                // En caso de error, realiza un rollback de la transacción
                DB::rollBack();
                $alert = array(
                    'type' => 'error',
                    'message' => 'Operación fallida' . $e->getMessage(),
                );
                session()->flash('alert', $alert);
                return back()
                    ->withInput()
                    ->with('error', 'Error al guardar los registros.');
            }
        }
    }

    public function show($id)
    {
        return view('adopcion.form')->with('adopcion', Adopcion::find($id));
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

    public function baja($id)
    {


        $adopcion = Adopcion::find($id);
        $adopcion->estado = 0;
        $expediente = $adopcion->expediente;

        if ($expediente) {
            $expediente->estadoGeneral = $adopcion->expediente->idAlvergue != null ? 'Albergado' : 'Controlado';
            $expediente->save();
        }
        $adopcion->delete();
        $alert = array(
            'type' => 'success',
            'message' => 'Operación exitosa',
        );
        session()->flash('alert', $alert);

        return redirect()->route('adopcion.index')->with($alert);
    }

    public function alta($id)
    {
        $adopcion = Adopcion::find($id);
        $adopcion->estado = '1';
        $adopcion->save();
        return redirect()->route('adopcion.index');
    }

    public function aprobarAdopcion($id)
    {
        DB::beginTransaction();

        try {
            $adopcion = Adopcion::find($id);
            $adopcion->aceptacion = '1';
            $adopcion->fechaTramiteFin = date('Y-m-d');
            $expediente = $adopcion->expediente;

            if ($expediente) {
                $expediente->estadoGeneral = 'Adoptado';
                $expediente->save();
            }
            $adopcion->save();

            DB::commit();

            $alert = array(
                'type' => 'success',
                'message' => 'Operación exitosa',
            );
            session()->flash('alert', $alert);

            return back()->with($alert);
        } catch (\Exception $e) {
            DB::rollBack();

            $alert = array(
                'type' => 'error',
                'message' => 'Error en la operación',
            );
            session()->flash('alert', $alert);

            return back()->with($alert);
        }
    }

    public function denegarAdopcion($id)
    {
        DB::beginTransaction();

        try {
            $adopcion = Adopcion::find($id);
            $adopcion->aceptacion = '2';
            $adopcion->fechaTramiteFin = date('Y-m-d');
            $expediente = $adopcion->expediente;

            if ($expediente) {
                $expediente->estadoGeneral = $adopcion->expediente->idAlvergue != null ? 'Albergado' : 'Controlado';
                $expediente->save();
            }
            $adopcion->save();

            DB::commit();

            $alert = array(
                'type' => 'success',
                'message' => 'Operación exitosa',
            );
            session()->flash('alert', $alert);

            return back()->with($alert);
        } catch (\Exception $e) {
            DB::rollBack();

            $alert = array(
                'type' => 'error',
                'message' => 'Error en la operación',
            );
            session()->flash('alert', $alert);

            return back()->with($alert);
        }
    }

    public function revertirDecisionAdopcion($id)
    {
        $adopcion = Adopcion::find($id);

        foreach ($adopcion->expediente->adopcions as $a) {
            if ($a->aceptacion == 0 && $a->idAdopcion != $adopcion->idAdopcion) {
                $alert = array(
                    'type' => 'error',
                    'message' => 'Este expediente ya tiene un trámite pendiente',
                );
                session()->flash('alert', $alert);
                return back();
            }
        }

        DB::beginTransaction();

        try {

            $adopcion->aceptacion = '0';
            $adopcion->fechaTramiteFin = null;
            $expediente = $adopcion->expediente;

            if ($expediente) {
                $expediente->estadoGeneral = 'En proceso de adopción';
                $expediente->save();
            }
            $adopcion->save();

            DB::commit();

            $alert = array(
                'type' => 'info',
                'message' => 'Se ha revertido la decisión.',
            );
            session()->flash('alert', $alert);

            return back()->with($alert);
        } catch (\Exception $e) {
            DB::rollBack();

            $alert = array(
                'type' => 'error',
                'message' => 'Error en la operación',
            );
            session()->flash('alert', $alert);

            return back()->with($alert);
        }
    }

    public function getExp_AdDElegido($idExpediente, $idAdoptante)
    {

        $expediente = Expediente::find($idExpediente);
        $adoptante = Adoptante::find($idAdoptante);

        return redirect('/adopcion/create')->with(
            [
                'expElegido' => $expediente,
                'adElegido' => $adoptante,
            ]
        );
    }

    public function generarIdAdoptante()
    {
        // Obtener el último registro de la tabla "ADOPTANTE"
        $ultimoAdoptante = Adoptante::latest('idAdoptante')->first();
        if (!$ultimoAdoptante) {
            // Si no hay registros previos, comenzar desde AD0001
            $nuevoId = 'AD0001';
        } else {
            // Obtener el número del último idAdoptante
            $ultimoNumero = intval(substr($ultimoAdoptante->idAdoptante, 2));

            // Incrementar el número para el nuevo registro
            $nuevoNumero = $ultimoNumero + 1;
            // Formatear el nuevo idAnimal con ceros a la izquierda
            $nuevoId = 'AD' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
        }

        return $nuevoId;
    }

    public function generarIdHogar()
    {
        // Obtener el último registro de la tabla "ADOPTANTE"
        $ultimoHogar = Hogar::latest('idHogar')->first();
        if (!$ultimoHogar) {
            // Si no hay registros previos, comenzar desde AD0001
            $nuevoId = 'HG0001';
        } else {
            // Obtener el número del último idHogar
            $ultimoNumero = intval(substr($ultimoHogar->idHogar, 2));
            // Incrementar el número para el nuevo registro
            $nuevoNumero = $ultimoNumero + 1;
            // Formatear el nuevo idAnimal con ceros a la izquierda
            $nuevoId = 'HG' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
        }

        return $nuevoId;
    }

    public function generarIdAdopcion()
    {
        // Obtener el último registro de la tabla "ADOPCION"
        $ultimoAnimal = Adopcion::latest('idAdopcion')->first();

        if (!$ultimoAnimal) {
            // Si no hay registros previos, comenzar desde ADC0001
            $nuevoId = 'ADC0001';
        } else {
            // Obtener el número del último idAdopcion
            $ultimoNumero = intval(substr($ultimoAnimal->idAdopcion, 3));
            // Incrementar el número para el nuevo registro
            $nuevoNumero = $ultimoNumero + 1;

            // Formatear el nuevo idAnimal con ceros a la izquierda
            $nuevoId = 'ADC' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
        }

        return $nuevoId;
    }

    public function getAdopciones()
    {
        $adopciones = Adopcion::with('expediente.animal')->where('estado', 1)->orderby('aceptacion')
            ->orderByDesc('fechaTramiteInicio')->get();
        return response()->json($adopciones);
    }

    public function getExpedientesSinAdopcion()
    {
        $expedientes = Expediente::with('animal')
            ->where('estado', 1)
            ->where('estadoGeneral', 'Controlado')
            ->orWhere('estadoGeneral', 'Albergado')
            ->get();

        return response()->json($expedientes);
    }

    public function pdf($id)
    {
        $adopcion = Adopcion::find($id);

        // dd($historialVacunas);
        $pdf = PDF::loadView(
            'adopcion.pdf',
            [
                'adopcion' => $adopcion,
            ]
        );

        return $pdf->stream();
    }
}
