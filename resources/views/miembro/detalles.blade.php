@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/cards.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/jsHistorialV.js') }}"></script>
    <script src="{{ asset('js/validaciones/jsHistorialP.js') }}"></script>
@endsection
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-5 py-4">
                <div class="row mt-3">
                    <div
                        style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom:5px; border-bottom: 2px solid rgba(0, 0, 0, 0.1);">
                        <div style=" width:100%;margin: 0; display: flex; gap: 5px; align-items: center; ">
                            <button class="button btn-transparent" style="width: 30px;padding: 15px 5px" type="button"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-pp="tooltip" data-bs-placement="top" title="Volver"
                                onclick="window.location.href='/miembro'">
                                <i class="svg-icon fas fa-chevron-left" style="color: #4c4c4c"></i>
                            </button>
                            <h1>{{ Auth::user()->miembro->idMiembro == $miembro->idMiembro ? 'Tu Perfil' : 'Detalle de Miembro' }}
                            </h1>
                        </div>

                    </div>
                    <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                        <div class="row">
                            <div class="col-xl-4" style="margin: auto 0;">
                                <div
                                    style="margin-bottom:35px; width: 100%; height: auto; display:flex; justify-content: center; align-items: center; overflow: hidden;margin-top: 10%">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                        alt="user" class="picture"style="width: 55%; height: 100%; " />

                                </div>
                            </div>
                            <div class="col-xl-8">
                                <div
                                    style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                    <h1 class="mb-8">
                                        {{ 'Código: ' . $miembro->idMiembro }}
                                    </h1>


                                </div>
                                <br>
                                <div class="row mt-1" style="justify-content: center;">

                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input name="nombres" id="nombres" class="inputField" type="text"
                                                    value="{{ $miembro->nombres }}" readonly>
                                                <label class="inputFieldLabel" for="nombre">Nombres:</label>
                                                <i class="inputFieldIcon fas fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input name="apellidos" id="apellidos" class="inputField" type="text"
                                                    value="{{ $miembro->apellidos }}" readonly>
                                                <label class="inputFieldLabel" for="apellidos">Apellidos:</label>
                                                <i class="inputFieldIcon fas fa-pencil"></i>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input name="nombres" id="dui" class="inputField" type="text"
                                                    value="{{ $miembro->dui }}" readonly>
                                                <label class="inputFieldLabel" for="dui">DUI:</label>
                                                <i class="inputFieldIcon fas fa-id-card"></i>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input name="correo" id="correo" class="inputField" type="text"
                                                    value="{{ $miembro->correo }}" readonly>
                                                <label class="inputFieldLabel" for="correo">Correo</label>
                                                <i class="inputFieldIcon fas fa-envelope"></i>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        @foreach ($miembro->telefono_miembros as $tel)
                                            <div class="col-xl-6">
                                                <div class="inputContainer">
                                                    <input name="telefonos[]" id="telefonos[]" class="inputField"
                                                        type="text" value="{{ $tel->telefono }}" readonly>
                                                    <label class="inputFieldLabel" for="telefonos[]">Teléfono:</label>
                                                    <i class="inputFieldIcon fas fa-phone"></i>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if (Auth::user()->rol == 1 && Auth::user()->miembro->idMiembro != $miembro->idMiembro)
                                        @if ($miembro->usuarios->count() == 0)
                                            <button type="buttom" class="button button-pri" style="width: 160px"
                                                data-bs-toggle="modal" data-bs-target="#asignarUsuario">
                                                <i class="svg-icon fas fa-user-plus"></i>
                                                <span class="lable">
                                                    Asignar Usuario
                                                </span>
                                            </button>
                                        @else
                                            @if ($miembro->usuarios->first()->estado != 0 && $miembro->usuarios->first()->estado != 3)
                                                <button type="submit" class="button button-red" style="width: auto"
                                                    onclick="window.location.href = '{{ url('deshabilitar-usuario/' . $miembro->usuarios->first()->idUsuario) }}'">
                                                    <i class="svg-icon fas fa-user-minus"></i>
                                                    <span class="lable">
                                                        Deshabilitar Usuario
                                                    </span>
                                                </button>
                                            @else
                                                <button type="submit" class="button button-green" style="width: auto"
                                                    onclick="window.location.href = '{{ url('habilitar-usuario/' . $miembro->usuarios->first()->idUsuario) }}'">
                                                    <i class="svg-icon fas fa-user-check"></i>
                                                    <span class="lable">
                                                        Habilitar Usuario
                                                    </span>
                                                </button>
                                            @endif
                                        @endif
                                    @endif
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @include('miembro.modalesDetalle')
@endsection
