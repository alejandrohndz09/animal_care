@extends('layouts.master')



@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/JsEspecie.js') }}"></script>
@endsection

@section('content')
    <div id="layoutSidenav_content">
        <main>

            {{-- div de mostrar --}}
            <div class="container-fluid px-4 py-4">
                <div style=" width: 100%;display: flex;align-items: center;justify-content: space-between;">

                </div>
                {{-- validacion para los campos requeridos
                @if ($errors->any())
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                        --}}
                <div class="row mt-3">
                    <div class="col-xl-7">
                        <div
                            style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h1>Especie </h1>
                            <input id="searchInput" class="inputField card" style="width: 50% " autocomplete="off"
                                placeholder="🔍︎ Buscar" type="search">
                        </div>
                        <table>
                            <thead>
                                <tr class="head">
                                    <th style="width: 10%"></th>
                                    Especie
                                    </th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">

                                @foreach ($especie as $e)
                                    <tr>

                                        <td>{{ $e->idEspecie }}</td>
                                        <td>{{ $e->especie }}</td>
                                        <td>

                                            <div
                                                style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                                <a id="btnmodificar"
                                                    href="{{ url('especie/' . $e->idEspecie . '/edit') }}" type="button"
                                                    class="button button-blue" data-id="{{ $e->idEspecie }}"
                                                    style="width: 45%" data-bs-pp="tooltip" data-bs-placement="top"
                                                    title="Editar">
                                                    <i class="svg-icon fas fa-pencil"></i>
                                                </a>
                                                <button type="button" class="button button-red" style="width: 45%"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModalToggle"
                                                    data-id="{{ $e->idEspecie }}"
                                                    data-especie="{{ $e->especie }}">
                                                    <i class="svg-icon fas fa-trash"></i>
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

                </div>
                {{-- div de Insertar --}}
                <div class="col-xl-5">
                    <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                        <h3 style="padding: -5px 0px !important;">
                            {{ isset($especieEdit) ? 'Editar Registro' : 'Nuevo Registro' }}</h3>


                        <form action="{{ isset($especieEdit) ? url('especie/update/' . $especieEdit->idEspecie) : '' }}"
                            id="miFormulario" name="form" method="POST">
                            @csrf
                            @if (isset($especieEdit))
                                @method('PUT') <!-- Utilizar el método PUT para la actualización -->
                            @endif
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="inputContainer">
                                        <label class="inputFieldLabel" autocomplete="off" for="especie">Especie</label>
                                        <i class="inputFieldIcon fas fa-location-dot"></i>
                                        <input placeholder="Especie"
                                            value="{{ isset($especieEdit) ? $especieEdit->especie : old('especie') }}"
                                            class="inputField" name="especie">
                                        @error('especie')
                                            <small style="color:red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                    <button type="submit" class="button button-pri">
                                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                        <span class="lable">
                                            @if (isset($especieEdit))
                                                Modificar
                                            @else
                                                Guardar
                                            @endif
                                        </span>
                                    </button>
                                    <button onclick="{{ url('especie') }}" type="button" id="btnCancelar"
                                        class="button button-red">
                                        <i class="svg-icon fas fa-rotate-right"></i>
                                        <span class="lable">Cancelar</span>
                                    </button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--Modal-->
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
                                <p>Especie: <span id="modalRecordEspecie"></span></p>

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
