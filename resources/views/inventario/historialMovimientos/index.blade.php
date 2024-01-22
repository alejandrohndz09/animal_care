@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/cards.css'); ?>" type="text/css">
@endsection

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-5 py-4">
                <div class="row mt-3">
                    <div
                        style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom:5px; border-bottom: 2px solid rgba(0, 0, 0, 0.1);">
                        <div style=" width:100%;margin: 0; display: flex; gap: 5px; align-items: center; ">
                            <button class="button btn-transparent" style="width: 30px;padding: 15px 5px" type="button"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-pp="tooltip" data-bs-placement="top" title="Volver"
                                onclick="window.location.href='/inventario'">
                                <i class="svg-icon fas fa-chevron-left" style="color: #4c4c4c"></i>
                            </button>
                            <h1>Historial de Movimentos </h1>
                        </div>

                    </div>
                    <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                        <div class="row">
                            <div class="col-xl-12">
                                <h3 class="mb-4">Filtrar</h3>
                                <br>
                                <form id="filtroForm" action="{{ url('/inventario/historialMovimientos/filtro') }}"
                                    method="GET">
                                    <div class="row mt-1" style="justify-content: center;">
                                        <div class="col-xl-3">
                                            <div class="inputContainer">
                                                <select class="inputField" name="tipoMovimiento" id="tipoMovimiento">
                                                    @if (isset($tipoMovimiento))
                                                        <option value="Seleccione"
                                                            @if ($tipoMovimiento == '') selected @endif>Seleccione
                                                        </option>
                                                        <option value="Ingreso"
                                                            @if ($tipoMovimiento == 'Ingreso') selected @endif>
                                                            Ingreso
                                                        </option>
                                                        <option value="Salida"
                                                            @if ($tipoMovimiento == 'Salida') selected @endif>Salida
                                                        </option>
                                                    @else
                                                        <option value="Seleccione" selected>Seleccione
                                                        </option>
                                                        <option value="Ingreso">Ingreso</option>
                                                        <option value="Salida">Salida</option>
                                                    @endif
                                                </select>
                                                <label class="inputFieldLabel" for="nombre">Tipo de movimiento:</label>
                                                <i class="inputFieldIcon fas fa-house"></i>
                                                @error('tipoMovimiento')
                                                    <small style="color:red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="inputContainer">
                                                <input class="inputField" autocomplete="false" type="date"
                                                    name="fechaInicio" id="fechaInicio"
                                                    value="{{ isset($fechaInicio) ? $fechaInicio : '' }}">
                                                <label class="inputFieldLabel" for="nombre">Fecha de inicio:</label>
                                                <i class="inputFieldIcon fas fa-house"></i>
                                                @error('fechaInicio')
                                                    <small style="color:red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="inputContainer">
                                                <input class="inputField" autocomplete="false" type="date"
                                                    name="fechaFin" id="fechaFin"
                                                    value="{{ isset($fechaFin) ? $fechaFin : '' }}">
                                                <label class="inputFieldLabel" for="nombre">Fecha fin:
                                                    {{ isset($fechaFin) ? $fechaFin : '' }}</label>
                                                <i class="inputFieldIcon fas fa-house"></i>
                                                @error('fechaFin')
                                                    <small style="color:red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-2">
                                            <button type="submit" class="button button-primary btnConfirmar"
                                                style="margin-top:2%;: 45%" data-bs-pp="tooltip" data-bs-placement="top"
                                                title="Buscar">
                                                <i class="svg-icon fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="d-flex flex-row  align-items-center" style="margin-bottom: 15px;">
                                <h3 class="me-auto">Listado de movimientos</h3>

                                <div class="d-flex" style="gap:8px">
                                    <button type="button" class="button button-pri" style="width: 40px;"
                                        data-bs-pp="tooltip" data-bs-placement="top" title="Imprimir"
                                        onclick="window.location.href = '{{ url('/inventario/historialMovimientos/pdf') }}'">
                                        <i class="svg-icon fas fa-print"></i>
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
                                        <th>Tipo
                                        </th>
                                        <th>Recurso</th>
                                        <th>Valor</th>s
                                        <th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">

                                    @php use App\Http\Controllers\AnimalControlador; @endphp
                                    @foreach ($movimientos as $item)
                                        <tr>
                                            <td style="width: 15%">
                                                <img src="{{ asset('img/recurso.png') }}" alt="recurso item"
                                                    class="picture" />
                                            </td>
                                            <td>{{ explode(' ', $item->fechaMovimento)[0] }} </td>
                                            <td>{{ $item->tipoMovimiento }}</td>
                                            <td>{{ $item->recurso->recurso }}</td>
                                            <td>
                                                {{ $item->valor . ' (' . $item->recurso->unidadmedida->simbolo . ')' }}
                                            <td>

                                                <button type="button" class="button button-red btnDelete"
                                                    style="width: 45%" data-bs-toggle="modal"
                                                    data-bs-target="#modaldeBaja" data-bs-pp="tooltip"
                                                    data-bs-placement="top" title="Dar de baja del albergue">
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
                </div>
            </div>
        </main>
    </div>
@endsection
