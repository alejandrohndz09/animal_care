<?php

namespace App\Http\Controllers;

use App\Models\Miembro;
use App\Models\Usuario;
use App\Mail\RecuperarClaveMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

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
                    'usuario' => $user
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
        
        $usuario = Usuario::find($request->post('correo'));
        
        $mail = new RecuperarClaveMail($usuario, $claveGenerada);
        Mail::to($usuario->miembro->correo)->send($mail);
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

    public function recuperarClave(Request $request)
    {
        
        $usuario = Usuario::find($request->post('correo'));
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
}
