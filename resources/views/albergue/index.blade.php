@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/JsAlbergue.js') }}"></script>
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
                            <h1>Albergues </h1>
                            <input id="searchInput" class="inputField card" style="width: 50% " autocomplete="off"
                                placeholder="🔍︎ Buscar" type="search">
                        </div>
                        <table>
                            <thead>
                                <tr class="head">
                                    <th style="width: 10%"></th>
                                    <th>No.</th>
                                    <th>Responsable</th>
                                    <th>Direccion</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody id="tableBody">

                                @foreach ($Albergues as $item)
                                    <tr>
                                        <td style="width: 10%">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                                alt="user" class="picture" />
                                        </td>
                                        <td>{{ $item->idAlvergue }}</td>
                                        <td>{{ $item->idMiembro }}</td>
                                        <td>{{ $item->direccion }} </td>
                                        <td>
                                            <div
                                                style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                                <a id="btnmodificar" href="AlbergueEdit/{{ $item->idAlvergue }}"
                                                    type="button" class="button button-blue"
                                                    data-id="{{ $item->idAlvergue }}">
                                                    <i class="svg-icon fas fa-pencil"></i>
                                                    <span class="lable"></span>
                                                </a>

                                                <button type="button" class="button button-red"data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalToggle" data-id="{{ $item->idAlvergue }}"
                                                    data-nombre="{{ $item->nombres }}"
                                                    data-apellido="{{ $item->apellidos }}"
                                                    data-correo="{{ $item->correo }}">
                                                    <i class="svg-icon fas fa-trash"></i>
                                                    <span class="lable"></span>
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="pagination">

                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">

                            @if (isset($AlbergueEdit))
                                <h3 style="padding: -5px 0px !important;">Modificar Registro</h3>
                                <form id="miFormulario" action="{{ route('albergue.update', $AlbergueEdit) }}"
>
                                    @csrf
                                    @method('PUT') 
                                    <div class="row">
                                        <div class="col-xl-12">

                                            <div class="inputContainer">
                                                <label class="inputFieldLabel" autocomplete="off"
                                                    for="direccion">Dirección</label>
                                                <i class="inputFieldIcon fas fa-house"></i>
                                                <input value="{{ $AlbergueEdit->direccion }}" class="inputField"
                                                    name="direccion">
                                            </div>

                                            <div class="inputContainer">
                                                <label class="inputFieldLabel" for="nombre">Miembro responsable</label>
                                                <i class="inputFieldIcon fas fa-user"></i>
                                                <select id="miembro" name="miembro" class="inputField">
                                                    <option value="" {{ old('miembro') == '' ? 'selected' : '' }}>
                                                        Seleccione</option>
                                                    @foreach ($collection as $miembro)
                                                        <option value="{{ $miembro->idMiembro }}"
                                                            {{ $AlbergueEdit->idMiembro == $miembro->idMiembro || old('miembro') == $miembro->idMiembro ? 'selected' : '' }}>
                                                            {{ $miembro->nombres }}
                                                            {{ $miembro->apellidos }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div
                                            style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                            <button type="submit" class="button button-pri">
                                                <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                                <span class="lable">Modificar</span>
                                            </button>
                                            <button type="reset" class="button button-red">
                                                <i class="svg-icon fas fa-rotate-right"></i>
                                                <span class="lable">Cancelar</span>
                                            </button>
                                        </div>
                                </form>


                        </div>
                    @else
                        <h3 style="padding: -5px 0px !important;">Nuevo Registro</h3>
                        <form id="miFormulario" action="{{ route('albergueStore.index') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">

                                    <div class="inputContainer">
                                        <label class="inputFieldLabel" autocomplete="off" for="direccion">Dirección</label>
                                        <i class="inputFieldIcon fas fa-house"></i>
                                        <input class="inputField" name="direccion">
                                    </div>

                                    <div class="inputContainer">
                                        <label class="inputFieldLabel" for="nombre">Miembro responsable</label>
                                        <i class="inputFieldIcon fas fa-user"></i>
                                        <select id="miembro" name="miembro" class="inputField">
                                            <option value="" {{ old('miembro') == '' ? 'Seleccione' : '' }}>
                                                Seleccione</option>
                                            @foreach ($collection as $miembro)
                                                <option value="{{ $miembro->idMiembro }}"
                                                    {{ old('miembro') == $miembro->idMiembro ? 'Seleccione' : '' }}>
                                                    {{ $miembro->nombres }}
                                                    {{ $miembro->apellidos }}
                                                </option>
                                            @endforeach
                                        </select>
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
        <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalToggleLabel">Desea eliminar este registro?</h5>

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
