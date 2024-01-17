@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/jsEspecie.js') }}"></script>
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
                                <h1>Especies </h1>
                            </div>
                            <input id="searchInput" class="inputField card" style="width: 50% " autocomplete="off"
                                placeholder="🔍︎ Buscar" type="search">
                        </div>
                        <table>
                            <thead>
                                <tr class="head">
                                    <th></th>
                                    <th>Código</th>
                                    <th style="width: 40%">Nombre de especie</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">

                                @foreach ($especie as $e)
                                    <tr class="especie-row" data-especie="{{ json_encode($e) }}">
                                        <td>
                                            <img src="{{ asset('img/especie.png') }}" alt="especie" class="picture" />
                                        </td>
                                        <td>{{ $e->idEspecie }}</td>
                                        <td style="width: 40%">{{ $e->especie }}</td>
                                        <td>
                                            <div
                                                style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                                <a id="btnmodificar" href="{{ url('especie/' . $e->idEspecie . '/edit') }}"
                                                    type="button" class="button button-blue btnUpdate" data-id="{{ $e->idEspecie }}"
                                                    style="width: 45%" data-bs-pp="tooltip" data-bs-placement="top"
                                                    title="Editar">
                                                    <i class="svg-icon fas fa-pencil"></i>
                                                </a>
                                                <button type="button" class="button button-red btnDelete" style="width: 45%"
                                                    data-bs-toggle="modal" data-bs-target="#modalEliminar"
                                                    data-especie="{{ json_encode($e) }}"
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
                                {{ isset($especieEdit) ? 'Editar Registro' : 'Nuevo Registro' }}</h3>


                            <form action="{{ isset($especieEdit) ? url('especie/update/' . $especieEdit->idEspecie) : '' }}"
                                id="miFormulario" name="form" method="POST">
                                @csrf
                                @if (isset($especieEdit))
                                    @method('PUT') <!-- Utilizar el método PUT para la actualización -->
                                @endif


                                <div class="inputContainer">
                                    <label class="inputFieldLabel" autocomplete="off" for="especie">Nombre de la
                                        especie*</label>
                                    <i class="inputFieldIcon fas fa-paw"></i>
                                    <input placeholder="Especie" autocomplete="off"
                                        value="{{ isset($especieEdit) ? $especieEdit->especie : old('especie') }}"
                                        class="inputField" name="especie">
                                    @error('especie')
                                        <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>

                                <p style="margin-top: -25px;">(*)Campos Obligatorios</p>
                                <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                    <button type="submit" class="button button-pri">
                                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                        <span class="lable">
                                            {{ isset($especieEdit) ? 'Modificar' : 'Guardar' }}</h3>
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
            </div>
        </main>
    </div>
    @include('especie.modalesEspecie')
@endsection
