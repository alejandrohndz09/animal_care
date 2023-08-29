@extends('layouts.master')

@section('scripts')
<script src="{{ asset('js/Jsmiembro.js') }}"></script>
@endsection

@section('content')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
    
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div style=" width: 100%;display: flex;align-items: center;justify-content: space-between;">
                    <h1>Animales</h1>
                    {{-- <button class="btn button-pri">
                        <i class="fas fa-plus"></i>
                        <span class="lable">Agregar nuevo registro</span>
                    </button> --}}
                </div>

                <div class="row mt-3">
                    <div class="col-xl-7">
                        <table>
                            <thead>
                                <tr class="head">
                                    <th></th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Correo</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($datos as $item)
                                    <tr>
                                        <td>
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                                alt="user" class="picture" />
                                        </td>
                                        <td>{{ $item->nombres }}</td>
                                        <td>{{ $item->apellidos }}</td>
                                        <td>{{ $item->correo }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-xl-5">
                        <form action="{{ route('miembros.store') }}" method="POST">
                            @csrf
                            <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                                <h3 style="padding: -5px 0px !important;">Registro miembro</h3>
                                <form action="post">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input required="required" name="nombres" class="inputField"
                                                    placeholder="Nombres" type="text" autocomplete="false">
                                                <label class="inputFieldLabel" for="nombre">Nombres del miembro</label>
                                                <i class="inputFieldIcon fas fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input required="required" id="fecha" name="apellidos"
                                                    class="inputField" autocomplete="false" placeholder="Apellidos"
                                                    type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="inputContainer">
                                        <input required="required" id="fecha" class="inputField" name="correo"
                                            autocomplete="false" placeholder="Correo" type="email">
                                        <label class="inputFieldLabel" for="fecha">Correo</label>
                                        <i class="inputFieldIcon fas fa-envelope"></i>
                                    </div>

                                    <div class="row" id="telefono-container">
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input class="inputField form-control telefono" type="tel"
                                                    maxlength="18" value="+503 " name="telefonos"
                                                    oninput="formatPhoneNumber(this)"
                                                    onkeydown="return restrictToNumbersAndHyphen(event)">
                                                <label class="inputFieldLabel" for="telefono">Telefono</label>
                                                <i class="inputFieldIcon fas fa-phone"></i>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <button type="button" class="button button-pri" id="add-telefono">
                                                <i class="svg-icon fas fa-plus"></i>
                                            </button>
                                        </div>

                                    </div>


                                    <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                        <button type="reset" class="button button-sec">
                                            <i class="svg-icon fas fa-rotate-right"></i>
                                            <span class="lable">Cancelar</span>
                                        </button>
                                        <a href="{{ route('miembros.index') }}">
                                            <button type="submit" class="button button-pri">
                                                <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                                <span class="lable">Guardar</span>
                                            </button>
                                        </a>

                                    </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



        </main>
    </div>
@endsection
