@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
@endsection

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div style=" width: 100%;display: flex;align-items: center;justify-content: space-between;">
                </div>

                <div class="row mt-3 ">
                    <div class="col-xl-12">
                        <div
                            style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom:5px; border-bottom: 2px solid rgba(0, 0, 0, 0.1);">
                            <div style=" width:100%;margin: 0; display: flex; gap: 5px; align-items: center; ">
                                <button class="button btn-transparent" style="width: 30px;padding: 15px 5px" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-bs-pp="tooltip" data-bs-placement="top" title="Volver"
                                    onclick="window.location.href='/'">
                                    <i class="svg-icon fas fa-chevron-left" style="color: #4c4c4c"></i>
                                </button>
                                <h1>Gestión de inventario </h1>
                            </div>
                            <div
                                style=" width:100%;margin: 0; display: flex; gap: 5px; justify-content: end ;align-items: center; ">
                                <input id="searchInputGrid" class="inputField card" style="width: 50%;" autocomplete="off"
                                    placeholder="🔍︎ Buscar" type="search">

                                <div class="dropdown">
                                    <button class="button btn-transparent" style="width: 30px;padding: 15px 5px"
                                        type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                        aria-expanded="false" data-bs-pp="tooltip" data-bs-placement="top" title="Opciones">
                                        <i class="svg-icon fas fa-ellipsis-vertical" style="color: #4c4c4c"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#tabla">Expedientes
                                                dados de
                                                baja</a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div style="display: flex;  justify-content: center">
                            <div class="row col-xl-8">
                                <div class="col-xl-12 col-md-6">
                                    <div class="card mb-4 panelGrid"
                                        style="border: none; padding:.5rem; padding-bottom: 15px !important; gap: 0rem !important; width: 100%">
                                        <a href="/inventario/recursos/" class="stretched-link"></a>
                                        <div class="row" style="justify-content: center">
                                            <div class="col-xl-2">
                                                <div
                                                    style="margin: 0;height: 100%; display: flex; align-items: center;justify-content: center;color:#6067eb; font-size: 34px ">
                                                    <i class="fas fa-coins" style="margin-right: 3px;"></i>

                                                </div>
                                            </div>

                                            <div class="col-xl-10"
                                                style="padding-left: 1%; display:flex; flex-direction: column; justify-content: center;">
                                                <div
                                                    style="margin: 0; display: flex; align-items: center;width:auto; color:#6067eb; font-size: 14px">
                                                    <h2>Recursos</h2>
                                                </div>
                                                <div
                                                    style="margin: 0; display: flex; align-items: center;width:auto; color:#867596; font-size: 13px ">
                                                    <i class="fas fa-circle-info" style="margin-right: 3px;"></i>
                                                    Listado de recursos disponibles.
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="card mb-4 panelGrid"
                                        style="border: none; padding:.5rem; padding-bottom: 15px !important; gap: 0rem !important; width: 100%">
                                        <a href="/inventario/movimientos/" class="stretched-link"></a>
                                        <div class="row" style="justify-content: center">
                                            <div class="col-xl-2">
                                                <div
                                                    style="margin: 0;height: 100%; display: flex; align-items: center;justify-content: center;color:#6067eb; font-size: 34px ">
                                                    <i class="fas fa-right-left" style="margin-right: 3px;"></i>

                                                </div>
                                            </div>

                                            <div class="col-xl-10"
                                                style="padding-left: 1%; display:flex; flex-direction: column; justify-content: center;">
                                                <div
                                                    style="margin: 0; display: flex; align-items: center;width:auto; color:#6067eb; font-size: 14px">
                                                    <h2>Nuevo movimiento</h2>
                                                </div>
                                                <div
                                                    style="margin: 0; display: flex; align-items: center;width:auto; color:#867596; font-size: 13px ">
                                                    <i class="fas fa-circle-info" style="margin-right: 3px;"></i>
                                                    Registro de un ingreso o egreso de un recurso en específico.
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="card mb-4 panelGrid"
                                        style="border: none; padding:.5rem; padding-bottom: 15px !important; gap: 0rem !important; width: 100%">
                                        <a href="/inventario/donantes/" class="stretched-link"></a>
                                        <div class="row" style="justify-content: center">
                                            <div class="col-xl-2">
                                                <div
                                                    style="margin: 0;height: 100%; display: flex; align-items: center;justify-content: center;color:#6067eb; font-size: 34px ">
                                                    <i class="fas fa-hand-holding-medical" style="margin-right: 3px;"></i>

                                                </div>
                                            </div>

                                            <div class="col-xl-10"
                                                style="padding-left: 1%; display:flex; flex-direction: column; justify-content: center;">
                                                <div
                                                    style="margin: 0; display: flex; align-items: center;width:auto; color:#6067eb; font-size: 14px">
                                                    <h2>Gestión de donantes</h2>
                                                </div>
                                                <div
                                                    style="margin: 0; display: flex; align-items: center;width:auto; color:#867596; font-size: 13px ">
                                                    <i class="fas fa-circle-info" style="margin-right: 3px;"></i>
                                                    Control de las personas que realizan donaciones de recursos.
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="card mb-4 panelGrid"
                                        style="border: none; padding:.5rem; padding-bottom: 15px !important; gap: 0rem !important; width: 100%">
                                        <a href="/inventario/historial/" class="stretched-link"></a>
                                        <div class="row" style="justify-content: center">
                                            <div class="col-xl-2">
                                                <div
                                                    style="margin: 0;height: 100%; display: flex; align-items: center;justify-content: center;color:#6067eb; font-size: 34px ">
                                                    <i class="fas fa-clock-rotate-left" style="margin-right: 3px;"></i>

                                                </div>
                                            </div>

                                            <div class="col-xl-10"
                                                style="padding-left: 1%; display:flex; flex-direction: column; justify-content: center;">
                                                <div
                                                    style="margin: 0; display: flex; align-items: center;width:auto; color:#6067eb; font-size: 14px">
                                                    <h2>Historial de movimientos</h2>
                                                </div>
                                                <div
                                                    style="margin: 0; display: flex; align-items: center;width:auto; color:#867596; font-size: 13px ">
                                                    <i class="fas fa-circle-info" style="margin-right: 3px;"></i>
                                                    Reportes de movimientos durante un periodo definido.
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </main>
    </div>
@endsection
