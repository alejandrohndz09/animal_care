<?php

namespace App\Http\Controllers;

use App\Mail\RecuperarClaveMail;
use App\Models\Miembro;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    // protected $guard = 'usuario';

    public function show()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required',
            'clave' => 'required',
        ]);
        //primero intentara recuperar al usuario (si es que decidio ungresar con este dato)
        $user = Usuario::with('miembro')->where('usuario', $request->usuario)->first();
        //Sino se entenderá que decidió ingresar con el correo, entoces recupera al miembro y luego
        //al usuario asosciado a este.
        
        if ($user == null) {
            $miembro = Miembro::where('correo', $request->usuario)->first();
            if ($miembro && !$miembro->usuarios->isEmpty()) {
                $user = $miembro->usuarios->first();
                $user->miembro = $miembro;
            }
        }


        if ($user && $user->miembro->estado != 0 &&
            Hash::check($request->clave, $user->clave)) {
            if ($user->estado == 2) {
                return view('usuario.actualizarClave')->with([
                    'usuario' => $user,
                ]);
            } else if ($user->miembro->estado == 1) {
                Auth::login($user);

                $request->session()->regenerate();
                $alert = array(
                    'type' => 'success',
                    'message' => '¡Bienvenido/a, ' . Auth::user()->usuario . '!',
                );

                session()->flash('alert', $alert);
                return redirect('/');
            }
        } else {
            $alert = array(
                'type' => 'error',
                'message' => 'Credenciales incorrectas',
            );

            session()->flash('alert', $alert);
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/');
    }

    public function cambiarClaveTemporal(Request $request)
    {

        $usuario = Usuario::find($request->post('usuario'));
        $usuario->estado = 1;
        $usuario->clave = Hash::make($request->post('clave1'));
        $usuario->save();
        Auth::login($usuario);
        $request->session()->regenerate();
        $alert = array(
            'type' => 'success',
            'message' => '¡Bienvenido/a, ' . Auth::user()->usuario . '!',
        );

        session()->flash('alert', $alert);
        return redirect('/');

    }

    public function recuperarClaveMail(Request $request)
    {
        $correo = $request->post('correo');

        $miembro = Miembro::where('correo', $correo)->first();
        if ($miembro && !$miembro->usuarios->isEmpty()) {
            $usuario = $miembro->usuarios->first();
            $token = Str::random(8);
            $usuario->token = Hash::make($token);
            $usuario->save();
            $mail = new RecuperarClaveMail($usuario, $token);
            Mail::to($request->post('correo'))->send($mail);

            $alert = array(
                'type' => 'info',
                'message' => 'Se ha enviado un código de seguridad, por favor verifique su correo.',
            );

            session()->flash('alert', $alert);

            return view('usuario.codigoSeguridad')->with([
                'usuario' => $usuario,
            ]);
        } else {
            $alert = array(
                'type' => 'warning',
                'message' => 'Este correo no esta asociado a ningun usuario',
            );

            session()->flash('alert', $alert);
            return redirect()->back();
        }
    }

    public function verificarToken($token,$id)
    {
        $usuario = Usuario::find($id);
        // Verifica si se encontró un usuario con el token proporcionado

        $valido = Hash::check($token, $usuario->token) ? 1 : 0;
        return response()->json(['valido' => $valido,
            'codEncrypt' => bcrypt($token),
            'usuar' => Usuario::where('token', bcrypt($token))->first()]);
    }

    public function recuperarClave(Request $request)
    {
        $user = Usuario::find($request->post('usuario'))->first();

        return view('usuario.actualizarClave')->with([
            'usuario' => $user,
            'opcion' => 1,
        ]);

    }
}
