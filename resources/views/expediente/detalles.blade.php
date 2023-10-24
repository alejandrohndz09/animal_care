@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/cards.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/jsHistorialV.js') }}"></script>
    <script src="{{ asset('js/validaciones/jsHistorialP.js') }}"></script>
@endsection
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-5 py-4">
                <div class="row mt-3">
                    <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                        <div class="row">
                            <div class="col-xl-8">
                                <h1 class="mb-4">
                                    {{ $registrado->count() > 0 ? 'Expediente No. ' . $animal->expedientes->get(0)->idExpediente : 'Detalles de animal' }}
                                </h1>
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

                                        <div class="col-xl-4">
                                            <div class="inputContainer">
                                                <input name="nombres" id="nombres" class="inputField" type="text"
                                                    value="{{ $animal->sexo }}" readonly>
                                                <label class="inputFieldLabel" for="nombre">Sexo:</label>
                                                <i class="inputFieldIcon fas fa-dna"></i>
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

                                        @if ($registrado->count() > 0)
                                            <div class="col-xl-6">
                                                <div class="inputContainer">
                                                    <input name="nombres" id="nombres" class="inputField" type="text"
                                                        value="{{ $estado }}" readonly>
                                                    <label class="inputFieldLabel" for="nombre">Estado:</label>
                                                    <i class="inputFieldIcon fas fa-file-prescription"></i>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <button type="submit" class="button button-pri" style="margin-left: 180%"
                                        onclick="window.location.href = '{{ $registrado->count() > 0 ? 'AQUI EL URL PARA ALBERGARLO' : url('crearExpediente/' . $animal->idAnimal) }} '">
                                        <span class="lable">
                                            {{ $registrado->count() > 0 ? 'Albergar animal' : 'Crear expediente' }}
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
                                    style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                    <h5 style="margin-left: 30px;font-size: 34px; color: #333;">Historial de vacunas</h5>
                                    <button type="submit" id="mostrar" class="button button-pri"
                                        data-bs-toggle="modal" data-bs-target="#newHistorial"
                                        style="width: 80px;padding: 7px 3px">
                                        <i class="svg-icon fas fa-plus"></i>
                                    </button>
                                </div>
                                <input type="hidden" id="valorJavascript" name="valorJavascript" value="">

                                <style>
                                    .vaccine-container {
                                        padding: 15px;
                                        margin: 10px;
                                        margin-top: -30px;
                                        margin-bottom: -35px;
                                        transition: background-color 0.3s;
                                        /* Agregar una transición para suavizar el cambio de color */
                                    }

                                    .vaccine-container:hover {
                                        background-color: #f0f0f0;
                                        /* Cambiar el color de fondo cuando el cursor está sobre el contenedor */
                                    }

                                    .vaccine-title {
                                        font-size: 18px;
                                        font-weight: bold;
                                        color: #666;
                                        /* Cambiar el color del texto a un tono de gris */
                                    }

                                    .vaccine-content {
                                        padding: 5px;
                                        margin-bottom: 10px;
                                        display: flex;
                                        align-items: center;
                                    }

                                    .vaccine-content i {
                                        margin-right: 5px;
                                    }

                                    .vaccine-content:first-child {
                                        border-top: 1px solid #ccc;
                                        margin-left: -10px;
                                        margin-right: -10px;
                                        padding-left: 10px;
                                        padding-right: 10px;
                                    }

                                    .vaccine-container:last-child .vaccine-content {
                                        border-bottom: 1px solid #ccc;
                                        margin-left: -10px;
                                        margin-right: -10px;
                                        padding-left: 10px;
                                        padding-right: 10px;
                                    }

                                    ul {
                                        list-style-type: none;
                                        padding-left: 0;
                                    }

                                    ul li {
                                        margin-left: 60px;
                                    
                                    }
                                </style>

                                @php
                                    $exp = $animal->expedientes->get(0);
                                    $historialesAgrupados = [];
                                @endphp


                                @foreach ($exp->historialVacunas as $historial)
                                    @php
                                        $nombreVacuna = $historial->vacuna->vacuna;
                                        if (!isset($historialesAgrupados[$nombreVacuna])) {
                                            $historialesAgrupados[$nombreVacuna] = [];
                                        }
                                        $historialesAgrupados[$nombreVacuna][] = $historial;
                                    @endphp
                                @endforeach

                                <div id="contenedorVacuna">
                                    @foreach ($historialesAgrupados as $nombreVacuna => $historiales)
                                        <div class="vaccine-container historialv-row"
                                            data-vacuna="{{ json_encode($historiales) }}">
                                            <div class="vaccine-content"
                                                style="margin: 0; display: flex; align-items: center">
                                                <i class="fas fa-syringe" style="margin-right: 3px;color:#6067eb"></i>
                                                <span class="vaccine-title">{{ $nombreVacuna }}</span>
                                            </div>
                                            <ul>
                                                @foreach ($historiales as $historial)
                                                    <li>Dosis #{{ $loop->iteration }} aplicada el
                                                        {{ date('d/m/Y', strtotime($historial->fechaAplicacion)) }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                    <br>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-6 " style="padding-right: 0%">
                            <div class="card mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                                <div
                                    style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                    <h5 style="margin-left: 30px;font-size: 34px; color: #333;">Historial de patologías
                                    </h5>
                                    <button type="submit" id="mostrarPatologia" class="button button-pri"
                                        id="abrir" data-bs-toggle="modal" data-bs-target="#newHistorialPatologia"
                                        style="width: 80px;padding: 7px 3px">
                                        <i class="svg-icon fas fa-plus"></i>
                                    </button>
                                </div>


                                @php
                                    $exp = $animal->expedientes->get(0);
                                    $historialesAgrupados = [];
                                @endphp

                                @foreach ($exp->historialPatologia as $historial)
                                    @php
                                        $nombrePatologia = $historial->patologium->patologia;
                                        if (!isset($historialesAgrupados[$nombrePatologia])) {
                                            $historialesAgrupados[$nombrePatologia] = [];
                                        }
                                        $historialesAgrupados[$nombrePatologia][] = $historial;
                                    @endphp
                                @endforeach

                                <div id="contenedorPatologia">
                                    @foreach ($historialesAgrupados as $nombrePatologia => $historiales)
                                        <div class="vaccine-container historialp-row"
                                            data-patologia="{{ json_encode($historiales) }}">
                                            <div class="vaccine-content"
                                                style="margin: 0; display: flex; align-items: center">
                                                <img src="{{ asset('img/suero.svg') }}"
                                                    alt="triangle with all three sides equal" height="25"
                                                    width="25" style="margin-right: 3px" />
                                                <span class="vaccine-title">{{ $nombrePatologia }}</span>
                                            </div>
                                            <ul>
                                                @php
                                                    // Ordena los historiales por fecha de diagnóstico de forma descendente
                                                    usort($historiales, function ($a, $b) {
                                                        return strtotime($b->fechaDiagnostico) - strtotime($a->fechaDiagnostico);
                                                    });

                                                    // Toma el último historial (el más reciente) para mostrarlo
                                                    $ultimoHistorial = reset($historiales);
                                                @endphp
                                                <ul>
                                                    <li>
                                                        Diagnosticado el
                                                        <span>{{ date('d/m/Y', strtotime($ultimoHistorial->fechaDiagnostico)) }}</span>
                                                    </li>
                                                    <li>
                                                        Estado:
                                                        <span style="font-size: 15px;"
                                                            class="@if ($ultimoHistorial->estado == 'De alta') badge rounded-pill alert-success @elseif($ultimoHistorial->estado == 'En tratamiento') badge rounded-pill alert-warning @elseif($ultimoHistorial->estado == 'En espera de tratamiento') badge rounded-pill alert-danger @endif">
                                                            {{ $ultimoHistorial->estado }}
                                                        </span>
                                                    </li>
                                                </ul>
                                            </ul>
                                        </div>
                                    @endforeach
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @include('historialVacunas.index')
                @include('historialPatologia.index')
        </main>
    </div>

@endsection
