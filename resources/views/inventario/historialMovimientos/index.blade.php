@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/cards.css'); ?>" type="text/css">
@endsection
{{-- 
@section('scripts')
    <script src="{{ asset('js/validaciones/JsAlbergue.js') }}"></script>
@endsection --}}
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-5 py-4">
                <div class="row mt-3">
                    <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                        <div class="row">
                            <div class="col-xl-12">
                                <h1 class="mb-4">Historial de movimientos</h1>
                                <br>
                                    <div class="row mt-1" style="justify-content: center;">
                                        <div class="col-xl-3">
                                            <div class="inputContainer">

                                                <select class="inputField" name="tipoMovimiento" id="tipoMovimiento">
                                                    <option value="entrada">Seleccione</option>
                                                    <option value="entrada">Ingreso</option>
                                                    <option value="salida">Salida</option>
                                                </select>
                                                <label class="inputFieldLabel" for="nombre">Tipo de movimiento:</label>
                                                <i class="inputFieldIcon fas fa-house"></i>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="inputContainer">
                                                <input class="inputField" autocomplete="false" type="date"
                                                    name="fechaInicio" id="fechaInicio" required>
                                                <label class="inputFieldLabel"for="nombre">Fecha de inicio:</label>
                                                <i class="inputFieldIcon fas fa-house"></i>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="inputContainer">
                                                <input class="inputField" autocomplete="false" type="date"
                                                    name="fechaFin" id="fechaFin" required>
                                                <label class="inputFieldLabel" for="nombre">Fecha fin:</label>
                                                <i class="inputFieldIcon fas fa-house"></i>
                                            </div>

                                        </div>

                                        <div class="col-xl-2">
                                            <button type="button" class="button button-primary btnDelete"
                                            onclick="window.location.href = '{{ url('/inventario/historialMovimientos/filtro') }}';"
                                                style="margin-top:2%;: 45%" data-bs-toggle="modal"
                                                data-bs-target="#modaldeBaja" data-bs-pp="tooltip" data-bs-placement="top"
                                                title="Buscar">
                                                <i class="svg-icon fas fa-check"></i>
                                            </button>

                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="d-flex flex-row  align-items-center" style="margin-bottom: 15px;">
                                <h3 class="me-auto">Listado de movimientos</h3>

                                <div class="d-flex" style="gap:8px">
                                    <button type="button" class="button button-pri" data-bs-toggle="modal"
                                        data-bs-target="#modalAlvergar" style="width: 40px;" data-bs-pp="tooltip"
                                        data-bs-placement="top" title="Albergar nuevo animal">
                                        <i class="svg-icon fas fa-plus"></i>
                                    </button>

                                    <input id="searchInput" class="inputField card" style="width:80%" autocomplete="off"
                                        placeholder="🔍︎ Buscar" type="search">
                                </div>

                            </div>



                            <table>
                                <thead>
                                    <tr class="head">
                                        <th style="width: 15%"></th>
                                        <th>Fecha</th>
                                        <th>Tipo</th>
                                        <th>Recurso</th>
                                        <th>Valor</th>
                                        <th>Donante</th>
                                        <th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">

                                    @php use App\Http\Controllers\AnimalControlador; @endphp
                                    @foreach ($movimientos as $item)
                                        <tr>
                                            <td style="width: 15%">
                                                <img src="{{ isset($a->animal->imagen) ? asset($a->animal->imagen) : 'https://static.vecteezy.com/system/resources/previews/017/783/245/original/pet-shop-silhouette-logo-template-free-vector.jpg' }}"
                                                    alt="user" class="picture" />
                                            </td>
                                            <td>{{ explode(' ', $item->fechaMovimento)[0] }} </td>
                                            <td>{{ $item->tipoMovimiento }}</td>
                                            <td>{{ $item->recurso->recurso }}</td>
                                            <td>
                                                {{ $item->valor . ' (' . $item->recurso->unidadmedida->simbolo . ')' }}</td>
                                            </td>
                                            <td>
                                                {{ $item->donante->nombres . ' ' . $item->donante->apellidos }}</td>
                                            </td>
                                            <td>

                                                <button type="button" class="button button-red btnDelete"
                                                    style="width: 45%" data-bs-toggle="modal" data-bs-target="#modaldeBaja"
                                                    data-bs-pp="tooltip" data-bs-placement="top"
                                                    title="Dar de baja del albergue">
                                                    <i class="svg-icon fas fa-house-circle-xmark"></i>
                                                </button>


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
    {{-- @include('albergue.modalDetalle') --}}
@endsection
