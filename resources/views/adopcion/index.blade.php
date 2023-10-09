@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/jsAnimal.js') }}"></script>
@endsection
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div class="row mt-3">
                    <div class="col-xl-7">
                        <div
                            style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h1>Miembros </h1>
                            <input id="searchInput" class="inputField card" style="width: 50%; margin-left: 20% "
                                autocomplete="off" placeholder="🔍︎ Buscar" type="search">

                            <div class="dropdown">
                                <button class="button btn-transparent" style="width: 30px;padding: 15px 5px" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="svg-icon fas fa-ellipsis-vertical" style="color: #4c4c4c"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#tabla">Animales de
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

                                @php use App\Http\Controllers\AnimalControlador; @endphp
                                @foreach ($animales as $a)
                                    <tr class="animal-row"  data-animal="{{json_encode($a)}}">
                                        <td>
                                            <img src="{{isset($a->imagen)?asset($a->imagen):asset('img/especie.png')}}"
                                                alt="user" class="picture" />
                                        </td>
                                        <td>{{ $a->idAnimal }}</td>
                                        <td>{{ $a->nombre }}</td>
                                        <td>{{ $a->raza->especie->especie }}</td>
                                        <td>{{ $a->raza->raza }}</td>
                                        <td>{{ AnimalControlador::calcularEdad(explode(' ', $a->fechaNacimiento)[0]) }}
                                        </td>
                                        <td>
                                            <div
                                                style="display: flex; align-items: flex-end; gap: 3px; justify-content: center">
                                                <a href="{{ url('animal/' . $a->idAnimal . '/edit') }}"
                                                    class="button button-blue btnUpdate" style="width: 45%;" data-bs-pp="tooltip"
                                                    data-bs-placement="top" title="Editar">
                                                    <i class="svg-icon fas fa-pencil"></i>
                                                </a>
                                                <button type="button" class="button button-red btnDelete" style="width: 45%"
                                                data-bs-toggle="modal" data-bs-target="#exampleModalToggle" data-animal="{{json_encode($a)}}"
                                                    data-bs-pp="tooltip" data-bs-placement="top" title="Dar de baja">
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
                                {{ isset($animal) ? 'Editar Registro' : 'Nuevo Registro' }}</h3>
                            <form action="{{ isset($animal) ? url('animal/update/' . $animal->idAnimal) : '' }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($animal))
                                    @method('PUT')
                                @endif
                                <div class="row">
                                    <div class="col-xl-4">
                                        <input type="hidden"
                                            value="{{ isset($animal) ? old('imageTemp', $animal->imagen) : old('imagenTemp') }}"
                                            id="imagenTemp" name="imagenTemp">

                                        <label id="image-preview" class="custum-file-upload"
                                            style="margin-top:-10px; width: auto; height: 75%;
                                        {{ isset($animal)
                                            ? 'background-image: url(' . asset(old('imagenTemp', $animal->imagen)) . ')'
                                            : 'background-image: url(' . old('imagenTemp') . ')' }}"
                                            for="foto" data-bs-pp="tooltip" data-bs-placement="left"
                                            title="Subir imagen">
                                            <div class="icon" id="iconContainer" style="color:#c4c4c4;">
                                                <i style="height: 55px; padding: 10px" class="fas fa-camera"></i>
                                            </div>

                                            <input type="file" name="foto" id="foto"
                                                accept="image/jpeg,image/png">
                                        </label>
                                        @error('foto')
                                            <span class="text-danger" style="line-height: 0.05px">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-xl-8">
                                        <div class="inputContainer">
                                            <input id="nombre" name="nombre" class="inputField" placeholder="Nombre"
                                                type="text"
                                                value="{{ isset($animal) ? old('nombre', $animal->nombre) : old('nombre') }}"
                                                autocomplete="off">
                                            <label class="inputFieldLabel" for="nombre">Nombre*</label>
                                            <i class="inputFieldIcon fas fa-pen"></i>
                                            @error('nombre')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="inputContainer">
                                            <input id="fecha" name="fecha"
                                                value="{{ isset($animal) ? old('fecha', explode(' ', $animal->fechaNacimiento)[0]) : old('fecha') }}"
                                                max="{{ date('Y-m-d') }}" class="inputField" autocomplete="false"
                                                placeholder="Fecha de nacimiento" type="date">
                                            <label class="inputFieldLabel" for="fecha">Fecha de nacimiento
                                                estimada*</label>
                                            <i class="inputFieldIcon fas fa-calendar"></i>
                                            @error('fecha')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="inputContainer">
                                    <select id="especie" name="especie" class="inputField">
                                        <option value=""
                                            {{ old('especie') == '' && isset($animal) == null ? 'selected' : '' }}>
                                            Seleccione...
                                        </option>
                                        @php use App\Models\Especie; @endphp
                                        @foreach (Especie::all() as $e)
                                            <option value="{{ $e->idEspecie }}"
                                                {{ isset($animal) ? ($animal->raza->idEspecie == $e->idEspecie ? 'selected' : '') : (old('especie') == $e->idEspecie ? 'selected' : '') }}>
                                                {{ $e->especie }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <label class="inputFieldLabel" for="especie">Especie*</label>
                                    <i class="inputFieldIcon fas fa-dog"></i>
                                    @error('especie')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="inputContainer">
                                    <select id="raza" name="raza"
                                        data-selected="{{ isset($animal) ? $animal->idRaza : old('raza') }}"
                                        class="inputField">
                                        <option value="">Seleccione...</option>

                                    </select>
                                    <label class="inputFieldLabel" for="raza">Raza*</label>
                                    <i class="inputFieldIcon fas fa-paw"></i>
                                    @error('raza')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="inputContainer">
                                    <label class="inputFieldLabel">sexo*</label>
                                    <i class="inputFieldIcon fas fa-question"></i>
                                    <div style="padding: 3px 15px">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sexo"
                                                id="inlineRadio1" value="Hembra"
                                                {{ (isset($animal) && old('sexo', $animal->sexo) == 'Hembra') || old('sexo') == 'Hembra' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="Hembra">Hembra</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sexo"
                                                id="inlineRadio2" value="Macho"
                                                {{ isset($animal) ? (old('sexo', $animal->sexo) == 'Macho' ? 'checked' : '') : (old('sexo') == 'Macho' ? 'checked' : '') }}>
                                            <label class="form-check-label" for="Macho">Macho</label>
                                        </div>
                                    </div>
                                    @error('sexo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="inputContainer">
                                    <textarea id="particularidad" name="particularidad" class="inputField"
                                        placeholder="Ej. Mancha en la panza, ojos de diferente color, etc." rows="2" cols="50">{{ isset($animal) ? old('particularidad', $animal->particularidad) : old('particularidad') }}</textarea>

                                    <label class="inputFieldLabel" for="particularidad">Alguna Particularidad</label>
                                    <i class="inputFieldIcon fas fa-magnifying-glass-plus"></i>
                                    @error('particularidad')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <p style="margin-top: -25px;">(*)Campos Obligatorios</p>

                                <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">

                                    <button type="submit" class="button button-pri">
                                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                        <span class="lable">
                                            @if (isset($animal))
                                                Modificar
                                            @else
                                                Guardar
                                            @endif
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
        @include('animal.modalesAnimal')
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
