@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/cards.css'); ?>" type="text/css">
@endsection

{{-- @section('scripts')
    <script src="{{ asset('js/validaciones/JsAlbergue.js') }}"></script>
@endsection --}}
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-5 py-4">
                <div class="row mt-3">
                    <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                        <div class="row">
                            <div class="col-xl-8">
                                <h1 class="mb-4">Detalles de animal</h1>
                                <br>
                                <div class="row mt-1" style="justify-content: center;">


                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input name="nombres" id="nombres" class="inputField" type="text"
                                                    value="{{ $animal->nombre }}" readonly>
                                                <label class="inputFieldLabel" for="nombre">Nombre:</label>
                                                <i class="inputFieldIcon fas fa-file-signature"></i>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input name="nombres" id="nombres" class="inputField" type="text"
                                                    @php use App\Http\Controllers\AnimalControlador; @endphp
                                                    value="{{ AnimalControlador::calcularEdad(explode(' ', $animal->fechaNacimiento)[0]) }}"
                                                    readonly>
                                                <label class="inputFieldLabel" for="nombre">Edad estimada:</label>
                                                <i class="inputFieldIcon fas fa-hashtag"></i>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input name="nombres" id="nombres" class="inputField" type="text"
                                                    value="{{ $animal->particularidad }}" readonly>
                                                <label class="inputFieldLabel" for="nombre">Particularidad:</label>
                                                <i class="inputFieldIcon fas fa-comments"></i>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input name="nombres" id="nombres" class="inputField" type="text"
                                                    {{-- value="{{ $albergue->miembro->nombres . ' ' . $albergue->miembro->apellidos }}" --}} readonly>
                                                <label class="inputFieldLabel" for="nombre">Estado:</label>
                                                <i class="inputFieldIcon fas fa-file-prescription"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-xl-4">
                                            <div class="inputContainer">
                                                <input name="nombres" id="nombres" class="inputField" type="text"
                                                    value="{{ $animal->sexo }}" readonly>
                                                <label class="inputFieldLabel" for="nombre">Sexo:</label>
                                                <i class="inputFieldIcon fas fa-dna"></i>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="inputContainer">
                                                <input name="nombres" id="nombres" class="inputField" type="text"
                                                    value="{{ $animal->raza->especie->especie }}" readonly>
                                                <label class="inputFieldLabel" for="nombre">Especie:</label>
                                                <i class="inputFieldIcon fas fa-bone"></i>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="inputContainer">
                                                <input name="nombres" id="nombres" class="inputField" type="text"
                                                    value="{{ $animal->raza->raza }}" readonly>
                                                <label class="inputFieldLabel" for="nombre">Raza</label>
                                                <i class="inputFieldIcon fas fa-paw"></i>
                                            </div>
                                        </div>
                                    </div>


                                    <button type="submit" class="button button-pri" style="margin-left: 180%"
                                       >
                                        {{-- <i class="svg-icon fa-regular fa-floppy-disk"></i> --}}
                                        <span class="lable">
                                            Crear expediente
                                        </span>
                                    </button>

                                </div>

                            </div>
                            <div class="col-xl-4" style="margin: auto 0; padding: 20px 7%">
                                <div class="card_">
                                    <div class="item item--1">
                                        <img src="{{ isset($animal->imagen) ? asset($animal->imagen) : asset('img/especie.png') }}"
                                            alt="user" class="picture">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                @if ($registrado->count() > 0)
                    <div class="row mt-3">
                        <div class="col-xl-6 " style="padding-left: 0%">
                            <div class="card mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                                <div
                                    style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                    <h5>Historial de vacunas</h5>
                                    <button type="submit" class="button button-pri"
                                        style="width: 40px;padding: 15px 5px">
                                        <i class="svg-icon fas fa-plus"></i>
                                    </button>
                                </div>
                                <table>
                                    <thead>
                                        <tr class="head">
                                            <th></th>
                                            <th>Vacuna</th>
                                            <th>Dosís</th>
                                            <th>Fecha aplicación</th>
                                            <th>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">

                                        {{-- @php use App\Http\Controllers\AnimalControlador; @endphp
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
                                    @endforeach --}}
                                    </tbody>
                                </table>

                            </div>

                        </div>

                        <div class="col-xl-6 " style="padding-right: 0%">
                            <div class="card mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                                <div
                                    style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                    <h5>Historial de Patologías</h5>

                                    <button type="submit" class="button button-pri"
                                        style="width: 40px;padding: 15px 5px">
                                        <i class="svg-icon fas fa-plus"></i>
                                    </button>
                                </div>

                                <table>
                                    <thead>
                                        <tr class="head">
                                            <th>Patología</th>
                                            <th>Fecha diagnóstico</th>
                                            <th>Detalles</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">

                                        {{-- @php use App\Http\Controllers\AnimalControlador; @endphp
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
                                    @endforeach --}}
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                @endif

        </main>
    </div>
@endsection
