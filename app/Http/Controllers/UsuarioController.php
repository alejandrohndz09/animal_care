<?php

namespace App\Http\Controllers;

use App\Mail\CredencialesMail;
use App\Models\Miembro;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    public function store(Request $request)
    {
        $usuario = new Usuario();
        $usuario->idUsuario = $this->generarId();
        $usuario->idMiembro = $request->post('miembro');
        $usuario->rol = $request->post('rol');
        $claveGenerada = $this->generarClave();
        $usuario->clave = Hash::make($claveGenerada);
        $usuario->usuario = $this->generarNombreUsuario(Miembro::find($request->post('miembro')));
        $usuario->estado = 2;
        $mail = new CredencialesMail($usuario, $claveGenerada);
        Mail::to($usuario->miembro->correo)->send($mail);
        $alert = array(
            'type' => 'success',
            'message' => 'Se ha asignado el usuario y enviado las credenciales al miembro exitosamente',
        );

        session()->flash('alert', $alert);
        $usuario->save();

        return back()->with('success', 'Guardado con éxito');
    }

    public function deshabilitar($id)
    {
        $usuario = Usuario::find($id);

       
        $estado = $usuario->estado == 1 ? 0 : 3;
        $usuario->estado = $estado;
        $usuario->save();
        $alert = array(
            'type' => 'success',
            'message' => 'Se ha deshabilitado el usuario exitosamente',
        );
        session()->flash('alert', $alert);

        return redirect()->back();
    }

    public function habilitar($id)
    {
        $usuario = Usuario::find($id);
        $usuario->estado = $usuario->estado == 0 ? 1 : 2;
        $usuario->save();
        $alert = array(
            'type' => 'success',
            'message' => 'Se ha habilitado el usuario exitosamente',
        );
        session()->flash('alert', $alert);

        return back();
    }

    public function generarNombreUsuario(Miembro $miembro)
    {
        // Obtener el primer nombre y el primer apellido en minúsculas
        $primerNombre = strtolower(explode(' ', $miembro->nombres)[0]);
        $primerApellido = strtolower(explode(' ', $miembro->apellidos)[0]);

        // Formar el nombre de usuario
        $nombreUsuario = $primerNombre . $primerApellido;

        // Verificar si el nombre de usuario ya existe
        $correlativo = 1;
        while (Usuario::where('usuario', $nombreUsuario)->exists()) {
            // Si ya existe, incrementar el correlativo y volver a intentar
            $correlativo++;
        }
        return $nombreUsuario . str_pad($correlativo, 2, '0', STR_PAD_LEFT);
    }
    public function generarId()
    {
        // Obtener el último registro de la tabla "usuario"
        $ultimoUsuario = Usuario::latest('idUsuario')->first();

        if (!$ultimoUsuario) {
            // Si no hay registros previos, comenzar desde CA0001
            $nuevoId = 'US0001';
        } else {
            // Obtener el número del último idUsuario
            $ultimoNumero = intval(substr($ultimoUsuario->idUsuario, 2));

            // Incrementar el número para el nuevo registro
            $nuevoNumero = $ultimoNumero + 1;

            // Formatear el nuevo idUsuario con ceros a la izquierda
            $nuevoId = 'US' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
        }

        return $nuevoId;
    }

    public function generarClave()
    {
        // Generar una clave aleatoria
        $claveAleatoria = Str::random(8); // Puedes ajustar la longitud según tus necesidades

        return $claveAleatoria;
    }
}
