@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/cards.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/JsAlbergue.js') }}"></script>

@endsection
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-5 py-4">
                <div class="row mt-3">
                    <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                        <div class="row">
                            <div class="col-xl-8">
                                <h1 class="mb-4">Detalle de albergue</h1>
                                <div class="row mt-1" style="justify-content: center;">
                                    <div class="col-xl-5">
                                        <div class="inputContainer">
                                            <input name="nombres" id="nombres" class="inputField" type="text"
                                                value="{{ $albergue->idAlvergue }}" readonly>
                                            <label class="inputFieldLabel" for="nombre">Código:</label>
                                            <i class="inputFieldIcon fas fa-house"></i>
                                        </div>
                                        <div class="inputContainer">
                                            <input name="nombres" id="nombres" class="inputField" type="text"
                                                autocomplete="off" value="{{ $albergue->direccion }}" readonly>
                                            <label class="inputFieldLabel" for="nombre">Dirección: </label>
                                            <i class="inputFieldIcon fas fa-location-dot"></i>
                                            <small style="color:red" class="error-message"></small>
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="inputContainer">
                                            <input name="nombres" id="nombres" class="inputField" type="text"
                                                value="{{ $albergue->miembro->nombres . ' ' . $albergue->miembro->apellidos }}"
                                                readonly>
                                            <label class="inputFieldLabel" for="nombre">Miembro a cargo:</label>
                                            <i class="inputFieldIcon fas fa-user"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4" style="margin: auto 0; padding: 20px 7%">
                                <div class="card_">
                                    <div class="item item--1">

                                        <i class=" fas fa-shield-dog"></i>
                                        <span class="quantity">
                                            {{ count($albergue->expedientes) }} </span>
                                        <span class="text text--1"> Animales albergados </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div
                        style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h3>Animales albergados </h3>


                        <button type="button" class="button button-pri" data-bs-toggle="modal" data-bs-target="#modalAlvergar"
                        style="width: 45%;" data-bs-pp="tooltip" data-bs-placement="top" title="Albergar nuevo animal">
                            <i class="svg-icon fas fa-plus"></i>
                        </button>    

                        <input id="searchInput" class="inputField card" style="width: 50% " autocomplete="off"
                            placeholder="🔍︎ Buscar" type="search">
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
                            @foreach ($albergue->expedientes as $a)
                                <tr>
                                    <td>
                                        <img src="{{ isset($a->imagen) ? asset($a->imagen) : 'https://static.vecteezy.com/system/resources/previews/017/783/245/original/pet-shop-silhouette-logo-template-free-vector.jpg' }}"
                                            alt="user" class="picture" />
                                    </td>
                                    <td>{{ $a->idAnimal }}</td>
                                    <td>{{ $a->animal->nombre }}</td>
                                    <td>{{ $a->animal->raza->especie->especie }}</td>
                                    <td>{{ $a->animal->raza->raza }}</td>
                                    <td>{{ AnimalControlador::calcularEdad(explode(' ', $a->fechaNacimiento)[0]) }}
                                    </td>
                                    <td>
                                        <div>
                                            <button type="button" class="button button-red btnDelete" style="width: 45%"
                                                data-bs-toggle="modal" data-bs-target="#modaldeBaja"
                                                data-expediente="{{ json_encode($a) }}" data-bs-pp="tooltip"
                                                data-bs-placement="top" title="Dar de baja del albergue">
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
            </div>
        </main>
    </div>
     @include('albergue.modalDetalle')
@endsection