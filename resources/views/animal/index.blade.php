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
                            <h1>Animales </h1>
                            <input id="searchInput" class="inputField card" style="width: 50% " autocomplete="off"
                                placeholder="🔍︎ Buscar" type="search">
                        </div>

                        <table>
                            <thead>
                                <tr class="head">
                                    <th></th>
                                    <th>Nombre</th>
                                    <th>Edad</th>
                                    <th>Especie</th>
                                    <th>Raza</th>
                                    <th>Sexo</th>
                                    <th>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">

                                @php use App\Http\Controllers\AnimalControlador; @endphp
                                @foreach ($animales as $a)
                                    <tr>
                                        <td>
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                                alt="user" class="picture" />
                                        </td>
                                        <td>{{ $a->nombre }}</td>
                                        <td>{{ AnimalControlador::calcularEdad(explode(' ', $a->fechaNacimiento)[0]) }}
                                        </td>
                                        <td>{{ $a->raza->especie->especie }}</td>
                                        <td>{{ $a->raza->raza }}</td>
                                        <td>{{ $a->sexo }}</td>
                                        <td>
                                            <div
                                                style="display: flex; align-items: flex-end; gap: 3px; justify-content: center">
                                                <a href="{{ url('animal/' . $a->idAnimal . '/edit') }}"
                                                    class="button button-blue">
                                                    <i class="svg-icon fas fa-pencil"></i>
                                                    <span class="lable"></span>
                                                </a>
                                                <button type="button" class="button button-red">
                                                    <i class="svg-icon fas fa-trash"></i>
                                                    <span class="lable"></span>
                                                </button>
                                                {{-- <button type="button" class="button button-sec">
                                                <i class="svg-icon fas fa-ellipsis-vertical"></i>
                                                <span class="lable"></span>
                                            </button> --}}
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
                                {{ isset($animal) ? 'Editar Registro' : 'Nuevo Registro' }}</h3>
                            <form action="{{ isset($animal) ? url('animal/update/' . $animal->idAnimal) : '' }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($animal))
                                    @method('PUT')
                                @endif
                                <div class="row">
                                    <div class="col-xl-4">
                                        <input type="hidden" value="{{ old('imagenTemp') }}" id="imagenTemp"
                                            name="imagenTemp">

                                        <label id="image-preview" class="custum-file-upload"
                                            style="margin-top:-10px; width: auto; height: 75%;
                                        {{ isset($animal)
                                            ? 'background-image: url(' . asset($animal->imagen) . ')'
                                            : 'background-image: url(' . old('imagenTemp') . ')' }}"
                                            for="foto">
                                            <div class="icon" style="color:#c4c4c4;">
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
                                                value="{{ isset($animal) ? $animal->nombre : old('nombre') }}"
                                                autocomplete="off">
                                            <label class="inputFieldLabel" for="nombre">Nombre</label>
                                            <i class="inputFieldIcon fas fa-pen"></i>
                                            @error('nombre')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="inputContainer">
                                            <input id="fecha" name="fecha"
                                                value="{{ isset($animal) ? explode(' ', $animal->fechaNacimiento)[0] : old('fecha') }}"
                                                max="{{ date('Y-m-d') }}" class="inputField" autocomplete="false"
                                                placeholder="Fecha de nacimiento" type="date">
                                            <label class="inputFieldLabel" for="fecha">Fecha de nacimiento
                                                estimada</label>
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

                                    <label class="inputFieldLabel" for="especie">Especie</label>
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
                                    <label class="inputFieldLabel" for="raza">Raza</label>
                                    <i class="inputFieldIcon fas fa-paw"></i>
                                    @error('raza')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="inputContainer">
                                    <label class="inputFieldLabel">sexo</label>
                                    <i class="inputFieldIcon fas fa-question"></i>
                                    <div style="padding: 3px 15px">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sexo"
                                                id="inlineRadio1" value="Hembra"
                                                {{ isset($animal) ? ($animal->sexo == 'Hembra' ? 'checked' : '') : (old('sexo') == 'Hembra' ? 'checked' : '') }}>
                                            <label class="form-check-label" for="Hembra">Hembra</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sexo"
                                                id="inlineRadio2" value="Macho"
                                                {{ isset($animal) ? ($animal->sexo == 'Macho' ? 'checked' : '') : (old('sexo') == 'Macho' ? 'checked' : '') }}>
                                            <label class="form-check-label" for="Macho">Macho</label>
                                        </div>
                                    </div>
                                    @error('sexo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="inputContainer">
                                    <textarea id="particularidad" name="particularidad" class="inputField"
                                    placeholder="Ej. Mancha en la panza, ojos de diferente color, etc." rows="2" cols="50"{{isset($animal) ? $animal->particularidad : old('particularidad')}}></textarea>
                                    
                                    <label class="inputFieldLabel" for="particularidad">Alguna Particularidad</label>
                                    <i class="inputFieldIcon fas fa-magnifying-glass-plus"></i>
                                    @error('particularidad')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">

                                    <button type="submit" class="button button-pri">
                                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                        <span class="lable">Guardar</span>
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
    </div>
@endsection
