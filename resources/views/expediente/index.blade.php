@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/jsExpediente.js') }}"></script>
@endsection
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div class="row mt-3">
                    <div class="col-xl-7">
                        <div
                            style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h1>Expedientes </h1>
                            <input id="searchInput" class="inputField card" style="width: 50%; margin-left: 20% "
                                autocomplete="off" placeholder="🔍︎ Buscar" type="search">

                            <div class="dropdown">
                                <button class="button btn-transparent" style="width: 30px;padding: 15px 5px" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="svg-icon fas fa-ellipsis-vertical" style="color: #4c4c4c"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#tabla">Expedientes
                                            de
                                            baja</a></li>
                                </ul>
                            </div>
                        </div>

                        <table>
                            <thead>
                                <tr class="head">
                                    <th></th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Especie</th>
                                    <th>Raza</th>
                                    <th>Edad</th>
                                    <th>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">

                                @php use App\Http\Controllers\ExpedienteController; @endphp
                                @php use App\Http\Controllers\AnimalControlador; @endphp

                                @foreach ($expedientes as $ex)
                                    <tr class="expediente-row" data-file="{{ json_encode($ex) }}">
                                        <td>
                                            <img src="{{ isset($ex->animal->imagen) ? asset($ex->animal->imagen) : asset('img/especie.png') }}"
                                                alt="user" class="picture" />
                                        </td>
                                        <td>{{ $ex->animal->idAnimal }}</td>
                                        <td>{{ $ex->animal->nombre }}</td>
                                        <td>{{ $ex->animal->raza->especie->especie }}</td>
                                        <td>{{ $ex->animal->raza->raza }}</td>
                                        <td>{{ AnimalControlador::calcularEdad(explode(' ', $ex->animal->fechaNacimiento)[0]) }}
                                        </td>
                                        <td>
                                            <div
                                                style="display: flex; align-items: flex-end; gap: 3px; justify-content: center">
                                                <a href="{{ url('expediente/' . $ex->idExpediente . '/edit') }}"
                                                    class="button button-blue btnUpdate" style="width: 45%;"
                                                    data-bs-pp="tooltip" data-bs-placement="top" title="Editar">
                                                    <i class="svg-icon fas fa-pencil"></i>
                                                </a>
                                                <button type="button" class="button button-red btnDelete" style="width: 45%"
                                                 data-bs-toggle="modal" data-bs-target="#modalEliminar" data-file="{{ json_encode($ex) }}" data-bs-pp="tooltip"
                                                    data-bs-placement="top" title="Dar de baja">
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
                                {{ isset($expediente) ? 'Editar Registro' : 'Nuevo Registro' }}</h3>
                            <form
                                action="{{ isset($expediente) ? url('expediente/update/' . $expediente->idExpediente) : '' }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($expediente))
                                    @method('PUT')
                                @endif
                                <div class="inputContainer">
                                    <label class="inputFieldLabel" for="animal">Animal*</label>
                                    <i class="inputFieldIcon fas fa-file-signature"></i>
                                    <select id="animal" name="animal" class="inputField">
                                        <option value="" {{ old('animal') == '' && !isset($expediente) ? 'selected' : '' }}>
                                            Seleccione...
                                        </option>
                                        @php use App\Models\Animal; @endphp
                                        @foreach (Animal::all() as $animal)
                                            @if ($animal->estado == 1)
                                                <option value="{{ $animal->idAnimal }}"
                                                    {{ isset($expediente) ? ($expediente->idAnimal == $animal->idAnimal ? 'selected' : '') : (old('animal') == $animal->idAnimal ? 'selected' : '') }}>
                                                    {{ $animal->nombre }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('animal')
                                        <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="inputContainer">
                                    <label class="inputFieldLabel" for="albergue">Albergue*</label>
                                    <i class="inputFieldIcon fas fa-house"></i>
                                    <select id="albergue" name="albergue" class="inputField">
                                        <option value="" {{ old('albergue') == '' && !isset($expediente) ? 'selected' : '' }}>
                                            Seleccione...
                                        </option>
                                        @php use App\Models\Alvergue; @endphp
                                        @foreach (Alvergue::all() as $albergue)
                                            @if ($albergue->estado == 1)
                                                <option value="{{ $albergue->idAlvergue }}"
                                                    {{ isset($expediente) ? ($expediente->alvergue->idAlvergue == $albergue->idAlvergue ? 'selected' : '') : (old('albergue') == $albergue->idAlvergue ? 'selected' : '') }}>
                                                    {{ $albergue->direccion }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('albergue')
                                        <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="inputContainer">
                                    <input id="fecha" name="fecha" value="{{ isset($expediente) ? old('fecha') : old('fecha') }}" max="{{ date('Y-m-d') }}"
                                        class="inputField" autocomplete="false" placeholder="Fecha de nacimiento"
                                        type="date">
                                    <label class="inputFieldLabel" for="fecha">Fecha de ingreso
                                        estimada*</label>
                                    <i class="inputFieldIcon fas fa-calendar"></i>
                                    @error('fecha')
                                        <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="inputContainer">
                                    <label class="inputFieldLabel" for="estado">Estado general*</label>
                                    <i class="inputFieldIcon fas fa-spinner"></i>
                                    <select id="estado" name="estado" class="inputField">
                                        <option value="" {{ old('estado') == '' && !isset($expediente) ? 'selected' : '' }}> Seleccione...</option>
                                        <option value="controlado">Controlado</option>
                                        <option value="albergado">Albergado</option>
                                        <option value="proceso_adopcion">En proceso de adopción</option>
                                        <option value="adopcion">Adopción</option>
                                    </select>
                                    @error('estado')
                                        <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>
                                <p style="margin-top: -25px;">(*)Campos Obligatorios</p>

                                <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">

                                    <button type="submit" class="button button-pri">
                                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                        <span class="lable">
                                            {{ isset($expediente) ? 'Modificar' : 'Guardar' }}
                                        </span>
                                    </button>
                                    <button type="button" id="btnCancelar" class="button button-red"
                                        onclick="{{ url('animal') }}">
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
        @include('expediente.modalesExpediente')
    </div>
    @if (session()->has('alert'))
        <script>
            Toast.fire({
                icon: "{{ session()->get('alert')['type'] }}",
                title: "{{ session()->get('alert')['message'] }}",
            });

            @php
                session()->keep('alert');
            @endphp
        </script>
    @endif
@endsection
