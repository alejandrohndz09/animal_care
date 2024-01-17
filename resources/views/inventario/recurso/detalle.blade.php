@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/cards.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/JsDetallesRecurso.js') }}"></script>
@endsection
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-5 py-4">
                <div class="row mt-3">
                    <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">

                        <div class="row">
                            <div class="col-xl-8">
                                <h1 class="mb-4">Detalle de recurso</h1>
                                <div class="row mt-1" style="justify-content: center;">
                                    <div class="col-xl-5">
                                        <div class="inputContainer">
                                            <input name="nombres" id="nombres" class="inputField" type="text"
                                                value="{{ $recurso->recurso }}" readonly>
                                            <label class="inputFieldLabel" for="nombre">Recurso:</label>
                                            <i class="inputFieldIcon fas fa-house"></i>
                                        </div>
                                        <div class="inputContainer">
                                            <input name="nombres" id="nombres" class="inputField" type="text"
                                                autocomplete="off" value="{{ $recurso->categoria->categoria }}" readonly>
                                            <label class="inputFieldLabel" for="nombre">Categoria: </label>
                                            <i class="inputFieldIcon fas fa-location-dot"></i>
                                            <small style="color:red" class="error-message"></small>
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="inputContainer">
                                            <input name="nombres" id="nombres" class="inputField" type="text"
                                                value="{{ $recurso->unidadmedida->unidadMedida }}" readonly>
                                            <label class="inputFieldLabel" for="nombre">Unidad de medidad:</label>
                                            <i class="inputFieldIcon fas fa-ruler"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4" style="margin: auto 0; padding: 20px 7%">
                                <div class="card_" style="margin-top: 7%">
                                    <div class="item item--1">

                                        <i class=" fas fa-coins"></i>
                                        <span class="quantity">
                                            {{ number_format($saldo, 2) }}
                                        </span>
                                        <span class="text text--1"> Cantidad disponible
                                            ({{ $recurso->unidadmedida->simbolo }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="d-flex flex-row  align-items-center" style="margin-bottom: 15px;">
                            <h3 class="me-auto">Lista de movimientos</h3>

                            <div class="d-flex" style="gap:8px">

                                <input id="searchInput" class="inputField card" style="width:80%" autocomplete="off"
                                    placeholder="🔍︎ Buscar" type="search">
                            </div>

                        </div>

                        <table>
                            <thead>
                                <tr class="head">
                                    <th style="width: 15%"></th>
                                    <th>Fecha movimiento</th>
                                    <th>Tipo movimiento</th>
                                    <th>Valor ({{ $recurso->unidadmedida->simbolo }})</th>
                                    <th>Registrado por</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($recurso->movimientos as $a)
                                    <tr class="movimientosR-row" data-movimiento="{{ $a }}"
                                        data-miembro="{{ $a->miembro->nombres . ' ' . $a->miembro->apellidos }}"
                                        data-donante="{{ $a->donante}}">
                                        <td style="width: 15%">
                                            <img src="{{ asset('img/recurso.png') }}" alt="movimiento item"
                                                class="picture" />
                                        </td>
                                        <td>{{ explode(' ', $a->fechaMovimento)[0] }}</td>
                                        <td>{{ $a->tipoMovimiento }}</td>
                                        <td>{{ number_format($a->valor, 2) }}</td> <!-- Formatear con dos decimales -->
                                        <td>{{ $a->miembro->nombres . ' ' . $a->miembro->apellidos }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div id="pagination"></div>
                    </div>
                </div>
                @include('inventario.recurso.modalesRecurso')
        </main>
    </div>
@endsection
