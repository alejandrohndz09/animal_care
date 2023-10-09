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
                                                    {{-- value="{{ $albergue->idAlvergue }}" --}} readonly>
                                                <label class="inputFieldLabel" for="nombre">Nombre:</label>
                                                <i class="inputFieldIcon fas fa-file-signature"></i>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input name="nombres" id="nombres" class="inputField" type="text"
                                                    {{-- value="{{ $albergue->miembro->nombres . ' ' . $albergue->miembro->apellidos }}" --}} readonly>
                                                <label class="inputFieldLabel" for="nombre">Edad estimada:</label>
                                                <i class="inputFieldIcon fas fa-hashtag"></i>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input name="nombres" id="nombres" class="inputField" type="text"
                                                    {{-- value="{{ $albergue->idAlvergue }}" --}} readonly>
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
                                                    {{-- value="{{ $albergue->miembro->nombres . ' ' . $albergue->miembro->apellidos }}" --}} readonly>
                                                <label class="inputFieldLabel" for="nombre">Sexo:</label>
                                                <i class="inputFieldIcon fas fa-dna"></i>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="inputContainer">
                                                <input name="nombres" id="nombres" class="inputField" type="text"
                                                    {{-- value="{{ $albergue->idAlvergue }}" --}} readonly>
                                                <label class="inputFieldLabel" for="nombre">Especie:</label>
                                                <i class="inputFieldIcon fas fa-bone"></i>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="inputContainer">
                                                <input name="nombres" id="nombres" class="inputField" type="text"
                                                    {{-- value="{{ $albergue->miembro->nombres . ' ' . $albergue->miembro->apellidos }}" --}} readonly>
                                                <label class="inputFieldLabel" for="nombre">Raza</label>
                                                <i class="inputFieldIcon fas fa-paw"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4" style="margin: auto 0; padding: 20px 7%">
                                <div class="card_">
                                    <div class="item item--1">

                                        <i class=" fas fa-shield-dog"></i>
                                        <span class="quantity">
                                            {{-- {{ count($albergue->expedientes) }} --}}
                                        </span>
                                        <span class="text text--1"> Animales albergados </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                </div>
                <div class="row mt-3" style="padding-left: 0%">
                    <div class="col-xl-6 ">
                        <div class="card mb-4" style="border:none; padding-bottom: 25px !important; width: 100%"></div>
                    </div>
                  
                    <div class="col-xl-6" style="padding-right: 0%">
                        <div class="card mb-4" style="border:none; padding-bottom: 25px !important; width: 100%"></div>
                    </div>
                </div>

        </main>
    </div>
@endsection
