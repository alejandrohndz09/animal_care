@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/Jsmiembro.js') }}"></script>
    <script src="{{ asset('js/tabAdopcion.js') }}"></script>
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
                            style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom:5px; border-bottom: 2px solid rgba(0, 0, 0, 0.1);">
                            <div style=" width:100%;margin: 0; display: flex; gap: 5px; align-items: center; ">
                                <button class="button btn-transparent" style="width: 30px;padding: 15px 5px" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-bs-pp="tooltip" data-bs-placement="top" title="Volver"
                                    onclick="window.location.href='/'">
                                    <i class="svg-icon fas fa-chevron-left" style="color: #4c4c4c"></i>
                                </button>
                                <h1>Adopciones </h1>
                            </div>
                            <input id="searchInputGrid" class="inputField card" style="width: 50%; " autocomplete="off"
                                placeholder="🔍︎ Buscar" type="search">

                        </div>
                        <div id="grid" class="d-flex justify-content-center">
                            <div class="row col-xl-8">

                                @foreach ($adopciones as $item)
                                    @if ($item->estado == 1)
                                        <div class="col-xl-12 col-md-6">
                                            <div class="card mb-4 panelGrid d-flex flex-row "
                                                style="border: none; padding:.5rem; padding-bottom: 25px !important; gap: 0rem !important; width: 100%">
                                                <div style="width: 100%; height: 140px; overflow: hidden;">
                                                    <img src="' + img + '" class="card-img-top"
                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                </div>
                                                <div class="d-flex flex-columns">

                                                    <div
                                                        style="margin: 0; display: flex; align-items: center; font-weight: bold;">
                                                        Cod. {{ $item->idExpediente }}
                                                    </div>
                                                    <div
                                                        style="margin: 0; display: flex; align-items: center;color:#6067eb; font-size: 14px">
                                                        <i class="fas fa-paw" style="margin-right: 3px;"></i>
                                                        {{ $item->expediente->animal->nombre }}
                                                    </div>
                                                    <div
                                                        style="margin: 0; display: flex; align-items: center; color:#867596; font-size: 12px ">
                                                        <i class="fas fa-calendar" style="margin-right: 3px;"></i>
                                                        Desde el {{ $item->fechaTramiteInicio->format('d/m/y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div id="paginationGrid">

                        </div>
                    </div>

                </div>
            </div>
        </main>
        {{-- @include('adopcion.modalesAdopcion') --}}
    </div>
@endsection
