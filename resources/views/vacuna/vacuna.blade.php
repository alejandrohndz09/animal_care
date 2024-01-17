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
                            <div style=" width:100%;margin: 0; display: flex; gap: 5px; align-items: center; ">
                                <button class="button btn-transparent" style="width: 30px;padding: 15px 5px" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-bs-pp="tooltip" data-bs-placement="top" title="Volver"
                                    onclick="window.location.href='/'">
                                    <i class="svg-icon fas fa-chevron-left" style="color: #4c4c4c"></i>
                                </button>
                                <h1>Vacunas </h1>
                            </div>
                            <input id="searchInput" class="inputField card" style="width: 50% " autocomplete="off"
                                placeholder="🔍︎ Buscar" type="search">
                        </div>

                        <table>
                            <thead>
                                <tr class="head">
                                    <th></th>
                                    <th>Código</th>
                                    <th style="width: 40%">
                                        Nombre de vacuna
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">

                                @foreach ($vacuna as $v)
                                    <tr class="vacuna-row"  data-vacuna="{{ json_encode($v) }}">
                                        <td>
                                            <img src="{{ asset('img/vacuna.png') }}" alt="vacuna" class="picture" />
                                        </td>
                                        <td>{{ $v->idVacuna }}</td>
                                        <td style="width: 40%">{{ $v->vacuna }}</td>
                                        <td>

                                            <div
                                                style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                                <a id="btnmodificar" href="{{ url('vacuna/' . $v->idVacuna . '/edit') }}"
                                                    type="button" class="button button-blue btnUpdate" data-id="{{ $v->idVacuna }}"
                                                    style="width: 45%" data-bs-pp="tooltip" data-bs-placement="top"
                                                    title="Editar">
                                                    <i class="svg-icon fas fa-pencil"></i>
                                                </a>
                                                <button type="button" class="button button-red btnDelete" style="width: 45%"
                                                    data-bs-toggle="modal" data-bs-target="#modalEliminacion"
                                                    data-vacuna="{{ json_encode($v) }}"
                                                    data-bs-pp="tooltip" data-bs-placement="top" title="Eliminar">
                                                    <i class="svg-icon fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div id="pagination"></div>
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

                                <div class="inputContainer">
                                    <label class="inputFieldLabel" autocomplete="off" for="vacuna">Nombre de
                                        vacuna*</label>
                                    <i class="inputFieldIcon fas fa-syringe"></i>
                                    <input placeholder="Ingrese acá"
                                        value="{{ isset($vacunaEdit) ? $vacunaEdit->vacuna : old('vacuna') }}"
                                        class="inputField" name="vacuna">
                                    @error('vacuna')
                                        <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>

                                <p style="margin-top: -25px;">(*)Campos Obligatorios</p>
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
        </main>
    </div>
    <div class="floating-button" data-toggle="modal" data-target="#ayudaV" data-bs-pp="tooltip" data-bs-placement="top" title="Ayuda">
        <span>?</span>
    </div>
    @include('vacuna.modalesVacuna')
@endsection
