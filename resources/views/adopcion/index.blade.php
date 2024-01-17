@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/tabAdopcion.js') }}"></script>
@endsection

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">

                <div class="row">
                    <div class="col-xl-12">
                        <div
                            style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom:5px; border-bottom: 2px solid rgba(0, 0, 0, 0.1);">
                            <div style=" width:55%; margin: 0; display: flex; gap: 5px; align-items: center; ">
                                <button class="button btn-transparent" style="width: 30px;padding: 15px 5px" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-bs-pp="tooltip" data-bs-placement="top" title="Volver"
                                    onclick="window.location.href='/'">
                                    <i class="svg-icon fas fa-chevron-left" style="color: #4c4c4c"></i>
                                </button>
                                <h1>Adopciones </h1>
                            </div>
                            <div class="d-flex" style="width:45%; gap:8px">
                                <button type="button" class="button button-pri" style="width: 30%;"
                                onclick="window.location.href='{{url('/adopcion/create')}}'" >
                                    <i class="svg-icon fas fa-plus"></i>
                                    <span class="lable">Nueva adopción</span>
                                </button>
                                <input id="searchInputGrid" class="inputField card" style="width: 70%; " autocomplete="off"
                                    placeholder="🔍︎ Buscar" type="search">
                            </div>
                        </div>
                        
                        <div id="grid" class="d-flex justify-content-center">
                            <div class="row col-xl-8">

                                @foreach ($adopciones as $item)
                                    @if ($item->estado == 1)
                                        <div class="col-xl-12 col-md-6">
                                            <div class="card mb-1 panelGrid d-flex flex-row " style="align-items:center; border: none; padding:.5rem; justify-content:start; gap: 0.7rem !important; width: 100%">
                                                <a href="/adopcion/{{$item->idAdopcion }}" class="stretched-link"></a>
                                                <div class="picture" style="width:60px; height: 60px; overflow: hidden;">
                                                    <img src="{{$item->expediente->animal->imagen==''?asset('img/especie.png'):$item->expediente->animal->imagen}}" style="width:100%; height:100%; object-fit: cover;">
                                                </div>
                                                <div style="margin: 0; display: flex; flex-direction:column;">
                                                    <div style="margin: 0; display: flex; align-items: center; font-weight: bold;">
                                                        Cod. {{ $item->idExpediente }}
                                                    </div>
                                                    <div style="margin: 0; display: flex; align-items: center;color:#6067eb; font-size: 14px">
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
                        <div id="paginationGrid"></div>
                    </div>

                </div>
            </div>
        </main>
        <div class="floating-button" data-toggle="modal" data-target="#ayudaAdopcion" data-bs-pp="tooltip" data-bs-placement="top" title="Ayuda">
            <span>?</span>
        </div>
       @include('adopcion.modalesAdopcion') 
    </div>
    
@endsection
