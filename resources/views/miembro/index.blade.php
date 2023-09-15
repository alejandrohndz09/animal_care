@extends('layouts.master')



@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/Jsmiembro.js') }}"></script>
@endsection
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div style=" width: 100%;display: flex;align-items: center;justify-content: space-between;">

                </div>

                <div class="row mt-3">
                    <div class="col-xl-7">
                        <div
                            style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h1>Miembros </h1>
                            <input id="searchInput" class="inputField card" style="width: 50% " autocomplete="off"
                                placeholder="🔍︎ Buscar" type="search">
                        </div>
                        <table>
                            <thead>
                                <tr class="head">
                                    <th style="width: 10%"></th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Correo</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody id="tableBody">

                                @foreach ($datos as $item)
                                    @if ($item->estado == 1)
                                        <tr>
                                            <td style="width: 10%">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                                    alt="user" class="picture" />
                                            </td>
                                            <td>{{ $item->nombres }}</td>
                                            <td>{{ $item->apellidos }}</td>
                                            <td>{{ $item->correo }} </td>
                                            <td>
                                                <div
                                                    style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                                    <a id="btnmodificar" href="edit/{{ $item->idMiembro }}" type="button"
                                                        class="button button-blue" data-id="{{ $item->idMiembro }}">
                                                        <i class="svg-icon fas fa-pencil"></i>
                                                        <span class="lable"></span>
                                                    </a>

                                                    <button type="button" class="button button-red"data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalToggle"
                                                        data-id="{{ $item->idMiembro }}" data-nombre="{{ $item->nombres }}"
                                                        data-apellido="{{ $item->apellidos }}"
                                                        data-correo="{{ $item->correo }}">
                                                        <i class="svg-icon fas fa-trash"></i>
                                                        <span class="lable"></span>
                                                    </button>

                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div id="pagination">

                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">

                            <h3 style="padding: -5px 0px !important;">
                                {{ isset($miembroEdit) ? 'Editar Registro' : 'Nuevo registro' }}
                            </h3>
                            <form
                                action="{{ isset($miembroEdit) ? url('miembro/update/' . $miembroEdit->idMiembro) :  route('miembros.store') }}"
                                id="miFormulario" name="form" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($miembroEdit))
                                    @method('PUT') <!-- Utilizar el método PUT para la actualización -->
                                @endif

                                <!-- Input DUI -->
                                <div class="col-xl-9">
                                    <div class="inputContainer">
                                        <input name="dui" type="text"
                                            value="{{ isset($miembroEdit) ? $miembroEdit->dui : old('dui') }}"
                                            class="inputField" placeholder="00000000-0" type="text" autocomplete="off"
                                            oninput="validarDui(this)">
                                        <label class="inputFieldLabel" for="dui">DUI</label>
                                        <i class="inputFieldIcon fas fa-id-card"></i>
                                        <small style="color:red" class="error-message"></small>
                                        @error('dui')
                                            <small style="color:red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Input Nombres -->
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="inputContainer">
                                            <input name="nombres" id="nombres" class="inputField" placeholder="Nombres"
                                                type="text" autocomplete="off"
                                                value="{{ isset($miembroEdit) ? $miembroEdit->nombres : old('nombres') }}">
                                            <label class="inputFieldLabel" for="nombre">Nombres</label>
                                            <i class="inputFieldIcon fas fa-user"></i>
                                            <small style="color:red" class="error-message"></small>
                                        </div>
                                    </div>
                                    <!-- Input Apellidos -->
                                    <div class="col-xl-6">
                                        <div class="inputContainer">
                                            <input name="apellidos" class="inputField" autocomplete="off"
                                                placeholder="Apellidos" type="text"
                                                value="{{ isset($miembroEdit) ? $miembroEdit->apellidos : old('apellidos') }}">
                                            <small style="color:red" class="error-message"></small>
                                        </div>
                                    </div>
                                </div>
                                <!-- Input Correo -->
                                <div class="inputContainer">
                                    <input class="inputField" name="correo" autocomplete="off" placeholder="Correo"
                                        type="email"
                                        value="{{ isset($miembroEdit) ? $miembroEdit->correo : old('correo') }}">
                                    <label class="inputFieldLabel">Correo</label>
                                    <i class="inputFieldIcon fas fa-envelope"></i>
                                    <small style="color:red" class="error-message"></small>
                                    @error('correo')
                                        <small style="color:red">{{ $message }}o</small>
                                    @enderror
                                </div>

                                <!-- Condicional para verificar si esta modificando o agregando telefonos -->
                                @if (empty($miembroEdit))

                                    <input type="hidden" name="con" id="con" value="1">

                                    <div class="row" id="telefono-container">
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input class="inputField form-control telefono" value="+503 "
                                                    id="tel" name="telefono1" type="text"
                                                    oninput="validarInput(this)">
                                                <label class="inputFieldLabel" for="telefono">Teléfono</label>
                                                <i class="inputFieldIcon fas fa-phone"></i>
                                                <small style="color:red" class="error-message"></small>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <button type="button" class="button button-pri" id="add-telefono">
                                                <i class="svg-icon fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <!-- Sirve para verificar si tiene o no telefonos el miembro -->
                                    @if ($telefonos->count() > 0)
                                        <!-- Contador para el total de telefonos que pueda tener el miembro -->
                                        @php
                                            $contador = 1;
                                        @endphp

                                        <!-- Guarda en un data los telefonos para eliminar verificar si el telefono son de la BD  -->
                                        <div class="row" id="telefono-container"
                                            data-objeto="{{ json_encode($telefonos) }}">

                                            <!-- Recorre los telefonos que pueda tener el miembro y los muestra-->
                                            @foreach ($telefonos as $item)
                                                <div class="row" id="remove">
                                                    <div class="col-xl-6">
                                                        <div class="inputContainer">
                                                            <input class="inputField form-control telefono" id="tel"
                                                                name="telefono{{ $contador }}" type="text"
                                                                oninput="validarInput(this)"
                                                                @if (old('telefono') === null) value="{{ $item->telefono }}"
                                                             @else
                                                             value="{{ old('telefono') }}" @endif>
                                                            @if ($contador == 1)
                                                                <label class="inputFieldLabel"
                                                                    for="telefono">Telefono</label>
                                                                <i class="inputFieldIcon fas fa-phone"></i>
                                                            @endif
                                                            @error('telefono')
                                                                <small style="color:red">El telefono ya ha sido
                                                                    registrado</small>
                                                            @enderror
                                                            <small style="color:red" class="error-message"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6" id="idTelefonos">
                                                        <!-- Valida si es el primer input agrega el icono de suma  -->
                                                        @if ($contador === 1)
                                                            <input type="hidden" name="boton{{ $contador }}"
                                                                value="{{ $item->idTelefono }}">
                                                            <button type="button" class="button button-pri"
                                                                id="add-telefono">
                                                                <i class="svg-icon fas fa-plus"></i>
                                                            </button>
                                                        @else
                                                            <input type="hidden" name="boton{{ $contador }}"
                                                                value="{{ $item->idTelefono }}">
                                                            <button type="button" class="btn btn-danger remove-telefono"
                                                                data-telefono-id="{{ $item->idTelefono }}">
                                                                <i class="svg-icon fas fa-circle-xmark"></i>
                                                            </button>
                                                        @endif

                                                    </div>
                                                </div>
                                        </div>
                                        @php
                                            $contador++;
                                        @endphp
                                    @endforeach

                                    <input type="hidden" name="con" id="con" value="{{ $contador - 1 }}">
                                @else
                                    <input type="hidden" name="con" id="con" value="1">
                                    <div class="row" id="telefono-container">
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input class="inputField form-control telefono" value="+503 "
                                                    id="tel" name="telefono1" type="text"
                                                    oninput="validarInput(this)">
                                                <label class="inputFieldLabel" for="telefono">Teléfono</label>
                                                <i class="inputFieldIcon fas fa-phone"></i>
                                                <small style="color:red" class="error-message"></small>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <button type="button" class="button button-pri" id="add-telefono">
                                                <i class="svg-icon fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                         


                                <!-- Botones para la vista -->
                                <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                    <button type="submit" class="button button-pri">
                                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                        <span class="lable">
                                            @if (isset($miembroEdit))
                                                Modificar
                                            @else
                                                Guardar
                                            @endif
                                        </span>
                                    </button>
                                    <button onclick="{{ url('miembros') }}" class="button button-red">
                                        <i class="svg-icon fas fa-rotate-right"></i>
                                        <span class="lable">Cancelar</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para la eliminacion de elementos de la lista-->
            <form action="" id="form-edit" name="form">
                @csrf
                <div class="modal fade" id="exampleModalToggle" aria-hidden="true"
                    aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalToggleLabel">Desea eliminar este registro?</h5>

                            </div>
                            <div class="modal-body">
                                <!-- Aquí puedes mostrar los detalles del registro utilizando el id -->
                                <p>Nombres: <span id="modalRecordNombre"></span></p>
                                <p>Apellidos: <span id="modalRecordApellido"></span></p>
                                <p>Correo: <span id="modalRecordCorreo"></span></p>
                            </div>
                            <div class="modal-footer">
                                <button id="confirmar" type="button" class="btn btn-primary"> Eliminar</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
            </form>
        </main>
    </div>
@endsection
