@extends('layouts.master')



@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/Jsmiembro.js') }}"></script>
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
                                    <th></th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Correo</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody id="tableBody">

                                @foreach ($datos as $item)
                                    @if ($item->estado == 0)
                                        <tr>
                                            <td>
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

                            @if (isset($miembroEdit))
                                <h3 style="padding: -5px 0px !important;">Modificar Registro</h3>
                                <form action="{{ route('miembros.update', $miembroEdit) }}" id="miFormulario"
                                    name="form" method="POST">
                                    @csrf
                                    @method('PUT') <!-- Utilizar el método PUT para la actualización -->

                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input name="nombres" id="nombres" class="inputField"
                                                    placeholder="Nombres" type="text" autocomplete="off"
                                                    value="{{ $miembroEdit->nombres }}">
                                                <label class="inputFieldLabel" for="nombre">Nombres del miembro</label>
                                                <i class="inputFieldIcon fas fa-user"></i>
                                                <small style="color:red" class="error-message"></small>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input name="apellidos" class="inputField" autocomplete="off"
                                                    placeholder="Apellidos" type="text"
                                                    value="{{ $miembroEdit->apellidos }}">
                                                <small style="color:red" class="error-message"></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="inputContainer">
                                        <input class="inputField" name="correo" autocomplete="off" placeholder="Correo"
                                            type="email"
                                            @if (old('correo') === null) value="{{ $miembroEdit->correo }}"
                                           @else
                                           value="{{ old('correo') }}" @endif>
                                        <label class="inputFieldLabel" for="fecha">Correo</label>
                                        <i class="inputFieldIcon fas fa-envelope"></i>
                                        <small style="color:red" class="error-message"></small>
                                        @error('correo')
                                            <small style="color:red">El correo ya ha sido registrado</small>
                                        @enderror
                                    </div>

                                    @foreach ($telefonos as $item)
                                        <input type="hidden" name="contador" id="contador" value="1">
                                        <div class="row" id="telefono-container">
                                            <div class="col-xl-6">
                                                <div class="inputContainer">
                                                    <input class="inputField form-control telefono"
                                                        @if ($telefonos === null) value="+503 "
                                                    @else
                                                    value="{{ $item->telefono }}" @endif
                                                        id="tel" name="telefono1" type="text"
                                                        oninput="validarInput(this)">
                                                    <label class="inputFieldLabel" for="telefono">Telefono</label>
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
                                    @endforeach


                                    <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                        <button type="submit" class="button button-pri">
                                            <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                            <span class="lable">Modificar</span>
                                        </button>
                                        <a href="{{ route('miembros.index') }}" class="button button-red">
                                            <i class="svg-icon fas fa-rotate-right"></i>
                                            <span class="lable">Cancelar</span>

                                        </a>

                                    </div>

                                </form>
                            @else
                                <h3 style="padding: -5px 0px !important;">Nuevo Registro</h3>
                                <form id="miFormulario" action="{{ route('miembros.store') }}" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input name="nombres" value="{{ old('nombres') }}" class="inputField"
                                                    placeholder="Nombres" type="text" autocomplete="off">
                                                <label class="inputFieldLabel" for="nombre">Nombres del miembro</label>
                                                <i class="inputFieldIcon fas fa-user"></i>
                                                <small style="color:red" class="error-message"></small>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input name="apellidos" value="{{ old('apellidos') }}"
                                                    class="inputField" autocomplete="off" placeholder="Apellidos"
                                                    type="text">
                                                <small style="color:red" class="error-message"></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="inputContainer">
                                        <input class="inputField" value="{{ old('correo') }}" name="correo"
                                            autocomplete="off" placeholder="Correo" type="email">
                                        <label class="inputFieldLabel" for="fecha">Correo</label>
                                        <i class="inputFieldIcon fas fa-envelope"></i>
                                        <small style="color:red" class="error-message"></small>
                                        @error('correo')
                                            <small style="color:red">El correo ya ha sido registrado</small>
                                        @enderror
                                    </div>

                                    <input type="hidden" name="contador" id="contador" value="1">
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

                                    <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                        <button type="submit" class="button button-pri">
                                            <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                            <span class="lable">Guardar</span>
                                        </button>
                                        <button type="reset" class="button button-red">
                                            <i class="svg-icon fas fa-rotate-right"></i>
                                            <span class="lable">Cancelar</span>
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <form action="" id="form-edit" name="form" method="POST">
                @csrf
                <div class="modal fade" id="exampleModalToggle" aria-hidden="true"
                    aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalToggleLabel">Desea eliminar este registro?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Aquí puedes mostrar los detalles del registro utilizando el id -->
                                <p>ID del registro: <span id="modalRecordId"></span></p>
                                <!-- Otros detalles del registro -->
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
