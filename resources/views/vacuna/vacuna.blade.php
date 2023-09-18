@extends('layouts.master'){{-- llama a la carcasa master --}}



@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">{{-- estilo --}}
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/jsVacuna.js') }}"></script>{{-- validacion para eliminar --}}
@endsection

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">


                <div class="row mt-3">
                    <div class="col-xl-7">
                        <div
                            style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h1>Vacuna </h1>
                            <input id="searchInput" class="inputField card" style="width: 50% " autocomplete="off"
                                placeholder="🔍︎ Buscar" type="search">
                        </div>

                        <table>
                            <thead>
                                <tr class="head">
                                    <th style="width: 10%"></th>
                                    Vacuna
                                    </th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">

                                @foreach ($vacuna as $v)
                                    <tr>

                                        <td>{{ $v->idVacuna }}</td>
                                        <td>{{ $v->vacuna }}</td>
                                        <td>

                                            <div
                                                style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                                <a id="btnmodificar" href="{{ url('vacuna/' . $v->idVacuna . '/edit') }}"
                                                    type="button" class="button button-blue" data-id="{{ $v->idVacuna }}"
                                                    style="width: 45%" data-bs-pp="tooltip" data-bs-placement="top"
                                                    title="Editar">
                                                    <i class="svg-icon fas fa-pencil"></i>
                                                </a>
                                                <button type="button" class="button button-red" style="width: 45%"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModalToggle"
                                                    data-id="{{ $v->idVacuna }}" data-vacuna="{{ $v->vacuna }}">
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
                    <div class="col-xl-5">
                        <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                            <h3 style="padding: -5px 0px !important;">
                                {{ isset($vacunaEdit) ? 'Editar Registro' : 'Nuevo Registro' }}</h3>


                            <form action="{{ isset($vacunaEdit) ? url('vacuna/update/' . $vacunaEdit->idVacuna) : '' }}"
                                id="miFormulario" name="form" method="POST">
                                @csrf
                                @if (isset($vacunaEdit))
                                    @method('PUT') <!-- Utilizar el método PUT para la actualización -->
                                @endif
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="inputContainer">
                                            <label class="inputFieldLabel" autocomplete="off" for="vacuna">Vacuna</label>
                                            <i class="inputFieldIcon fas fa-syringe"></i>
                                            <input placeholder="Vacuna"
                                                value="{{ isset($vacunaEdit) ? $vacunaEdit->vacuna : old('vacuna') }}"
                                                class="inputField" name="vacuna">
                                            @error('vacuna')
                                                <small style="color:red">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                        <button type="submit" class="button button-pri">
                                            <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                            <span class="lable">
                                                @if (isset($vacunaEdit))
                                                    Modificar
                                                @else
                                                    Guardar
                                                @endif
                                            </span>
                                        </button>
                                        <button onclick="{{ url('vacuna') }}" type="button" id="btnCancelar"
                                            class="button button-red">
                                            <i class="svg-icon fas fa-rotate-right"></i>
                                            <span class="lable">Cancelar</span>
                                        </button>
                                    </div>
                            </form>
                        </div>
                    </div>
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
                        <p>ID del registro: <span id="modalRecordCodigo"></span></p>
                        <!-- Otros detalles del registro -->
                        <p>Vacuna: <span id="modalRecordeVacuna"></span></p>

                    </div>
                    <div class="modal-footer">
                        <button id="confirmar" type="button" class="btn btn-primary"> Eliminar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>


            </div>
        </div>

    </form>


    </main>
    </div>
    @endsection