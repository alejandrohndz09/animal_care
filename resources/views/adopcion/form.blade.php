@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/cards.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/JsAdopcion.js') }}"></script>
    <script src="{{ asset('js/tabExpediente.js') }}"></script>
@endsection
@section('content')

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-5 py-4">
                {{-- titulo de la vista --}}
                <div class="row">

                    {{-- si se coloca como vista individual: --}}
                    <div class="mb-4"
                        style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom:5px; border-bottom: 2px solid rgba(0, 0, 0, 0.1); padding:0;">
                        <div style=" width:100%;margin: 0; display: flex; gap: 5px; align-items: center; ">
                            <button class="button btn-transparent" style="width: 30px;padding: 15px 5px" type="button"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-pp="tooltip" data-bs-placement="top" title="Volver"
                                onclick="window.location.href='/adopcion'">
                                <i class="svg-icon fas fa-chevron-left" style="color: #4c4c4c"></i>
                            </button>
                            <h1>
                                {{ isset($adopcion) && $adopcion->aceptacion == 0 ? 'Actualizar proceso de adopción' : (isset($adopcion) && $adopcion->aceptacion != 0 ? 'Detalle de adopción' : 'Nuevo proceso de adopción') }}
                            </h1>
                        </div>
                        @if (isset($adopcion) && $adopcion->aceptacion == 0)
                            <div class="dropdown">
                                <button class="button btn-transparent" style="width: 30px;padding: 15px 5px" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="svg-icon fas fa-ellipsis-vertical" style="color: #4c4c4c"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"
                                    onclick="window.location.href = '{{ url('/adopcion-baja/' . $adopcion->idAdopcion) }}'">
                                    <li><a class="dropdown-item">
                                            ✖️Eliminar trámite</a></li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <form
                    action="{{ isset($adopcion) ? url('/adopcion/update/' . $adopcion->idAdopcion) : route('adopcion.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($adopcion))
                        @method('PUT')
                        <div class="row">

                            <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">

                                <div class="d-flex flex-row  align-items-center" style="color: #878787;">
                                    <div class="d-flex align-items-center me-auto" style="gap: 8px">
                                        <i class="fas fa-file-invoice" style="font-size: 24px"></i>
                                        <h3 style="margin: 0;">Datos del Trámite</h3>
                                    </div>

                                    <button type="button" class="button button-pri"
                                             data-bs-pp="tooltip"
                                             onclick="window.location.href = '{{ url('/adopcion/pdf/' . $adopcion->idAdopcion) }}'"  data-bs-placement="top" title="Imprimir">
                                            <i class="svg-icon fas fa-print"></i>
                                        </button>
                                </div>

                                <div class="row align-items-center justify-content-center">

                                    <div class="col-xl-4">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <div class="inputContainer">
                                                <input class="inputField" type="text" readonly
                                                    value="{{ $adopcion->idAdopcion }}">
                                                <label class="inputFieldLabel colorLabel">Código:</label>
                                                <i class="inputFieldIcon fas fa-hashtag colorIcon"></i>
                                            </div>
                                            <div class="inputContainer {{ $adopcion->aceptacion != 0 ? '' : 'mb-0' }}">
                                                <input class="inputField" type="text" readonly
                                                    value="{{ $adopcion->fechaTramiteInicio->format('d/m/Y') }}">
                                                <label class="inputFieldLabel colorLabel">Fecha de inicio:</label>
                                                <i class="inputFieldIcon fas fa-calendar colorIcon"></i>
                                            </div>
                                            @if ($adopcion->aceptacion != 0)

                                                <div class="inputContainer mb-0">
                                                    <input class="inputField" type="text" readonly
                                                        value="{{ $adopcion->fechaTramiteFin->format('d/m/Y') }}">
                                                    <label class="inputFieldLabel colorLabel">Fecha de
                                                        finalización:</label>
                                                    <i class="inputFieldIcon fas fa-calendar colorIcon"></i>
                                                </div>

                                            @endif
                                        </div>
                                        @if ($adopcion->aceptacion == 0)
                                            <div class="row mt-4" style="text-align: center">
                                                <p class="mb-1"><strong>Opciones del trámite:</strong></p>
                                            </div>
                                            <div class="d-flex justify-content-center mt-0" style="gap: 8px">
                                                <button type="button"
                                                    onclick="window.location.href='{{ url('/aprobarAdopcion/' . $adopcion->idAdopcion) }}'"
                                                    class="button button-green"
                                                    style="width: 40%; padding: 7px 7px; justify-items: end">
                                                    <i class="svg-icon fas fa-check"></i>
                                                    <span class="lable">Aprobar<span>
                                                </button>
                                                <button type="button"
                                                    onclick="window.location.href='{{ url('/denegarAdopcion/' . $adopcion->idAdopcion) }}'"
                                                    class="button button-red"
                                                    style="width: 40%; padding: 7px 7px; justify-items: end">
                                                    <i class="svg-icon fas fa-xmark"></i>
                                                    <span class="lable">Denegar<span>
                                                </button>

                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-xl-3  d-flex flex-column align-items-center px-5">

                                        <div class="card_">
                                            <div
                                                class="item item--{{ $adopcion->aceptacion == 1 ? '3' : ($adopcion->aceptacion == 0 ? '0' : '4') }}">
                                                <i
                                                    class="{{ $adopcion->aceptacion == 1 ? 'fas fa-circle-check' : ($adopcion->aceptacion == 0 ? 'fas fa-clock' : 'fas fa-xmark') }}"></i>
                                                <span class="quantity">Estado:</span>
                                                <span
                                                    class="text text--{{ $adopcion->aceptacion == 1 ? '3' : ($adopcion->aceptacion == 0 ? '0' : '4') }}">
                                                    {{ $adopcion->aceptacion == 1 ? 'Trámite aprobado' : ($adopcion->aceptacion == 0 ? 'Pendiente de aprobación' : 'Trámite denegado') }}</span>
                                            </div>
                                        </div>
                                        @if ($adopcion->aceptacion != 0)
                                            <button type="button"
                                                onclick="window.location.href='{{ url('/revertirDecisionAdopcion/' . $adopcion->idAdopcion) }}'"
                                                class="button button-sec mt-3"
                                                style="width: 80%; padding: 7px 7px; justify-items: end; ">
                                                <i class="svg-icon fas fa-rotate-right alert-secondary"
                                                    style="color: #514e4e;"></i>
                                                <span class="lable" style="color: #514e4e;">Revertir decisión<span>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif

                    <div class="row mt-1">

                        <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">

                            <div class="d-flex flex-row  align-items-center" style="color: #878787;">
                                <div class="d-flex align-items-center me-auto" style="gap: 8px">
                                    <i class="fas fa-paw" style="font-size: 24px"></i>
                                    <h3 style="margin: 0;">Datos del animal</h3>

                                </div>
                                @if ((isset($adopcion) && $adopcion->aceptacion == 0) || !isset($adopcion))
                                    Este apartado no es editable, seleccione el expediente del animal a adoptar.
                                    <button type="button" class="button button-pri" data-bs-toggle="modal"
                                        data-bs-target="#buscarExpediente"
                                        style="width: auto;padding: 7px 7px; margin-left:8px; justify-items: end">
                                        <i class="svg-icon fas fa-search"></i>
                                        <span class="lable">Buscar expediente</span>
                                    </button>
                                @endif
                            </div>
                            @error('expA')
                                <span style="margin-top:-25px;" class="text-danger px-2">{{ $message }}</span>
                            @enderror
                            <div class="row">
                                <style>
                                    .colorLabel {
                                        color: {{ isset($adopcion->expediente) || isset($expElegido) || old('expA') != '' ? '#000000' : '#878787' }};
                                    }

                                    .colorIcon {
                                        color: {{ isset($adopcion->expediente) || isset($expElegido) || old('expA') != '' ? '#6067eb' : '#878787' }}
                                    }
                                </style>
                                <div class="col-xl-9">
                                    <div class="row mt-1" style="justify-content: center;">
                                        <div class="row">

                                            <div class="col-xl-6 col-md-6">
                                                <div class="inputContainer">

                                                    <input name="expA" id="expA" class="inputField"
                                                        type="text" readonly
                                                        value="{{ isset($adopcion) ? old('expA', $adopcion->idExpediente) : (isset($expElegido) ? old('expA', $expElegido->idExpediente) : old('expA')) }}">
                                                    <label class="inputFieldLabel colorLabel" for="expA">No.
                                                        Expediente:</label>
                                                    <i class="inputFieldIcon fas fa-file-signature colorIcon"></i>
                                                </div>

                                            </div>
                                            <div class="col-xl-6 col-md-6">
                                                <div class="inputContainer">
                                                    <input name="nombreA" id="nombreA" class="inputField"
                                                        type="text" readonly
                                                        value="{{ isset($adopcion) ? old('nombreA', $adopcion->expediente->animal->nombre) : (isset($expElegido) ? old('nombreA', $expElegido->animal->nombre) : old('nombreA')) }}">
                                                    <label class="inputFieldLabel colorLabel"
                                                        for="nombre">Nombre:</label>
                                                    <i class="inputFieldIcon fas fa-pencil colorIcon"></i>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-xl-4 col-md-4">
                                                <div class="inputContainer">

                                                    <input name="edad" id="edad" class="inputField"
                                                        type="text" readonly
                                                        @php use App\Http\Controllers\AnimalControlador; @endphp
                                                        value="{{ isset($adopcion) || isset($expElegido)
                                                            ? AnimalControlador::calcularEdad(
                                                                explode(
                                                                    ' ',
                                                                    isset($adopcion)
                                                                        ? old('edad', $adopcion->expediente->animal->fechaNacimiento)
                                                                        : (isset($expElegido)
                                                                            ? old('edad', $expElegido->animal->fechaNacimiento)
                                                                            : old('edad')),
                                                                )[0],
                                                            )
                                                            : old('edad') }}">
                                                    <label class="inputFieldLabel colorLabel" for="edad">Edad
                                                        estimada:</label>
                                                    <i class="inputFieldIcon fas fa-calendar colorIcon"></i>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="inputContainer">
                                                    <input name="especieA" id="especieA" class="inputField"
                                                        type="text" readonly
                                                        value="{{ isset($adopcion) ? old('especieA', $adopcion->expediente->animal->raza->especie->especie) : (isset($expElegido) ? old('especieA', $expElegido->animal->raza->especie->especie) : old('especieA')) }}">
                                                    <label class="inputFieldLabel colorLabel"
                                                        for="especieA">Especie:</label>
                                                    <i class="inputFieldIcon fas fa-bone colorIcon"></i>
                                                </div>
                                            </div>

                                            <div class="col-xl-4">
                                                <div class="inputContainer">
                                                    <input name="razaA" id="razaA" class="inputField"
                                                        type="text" readonly
                                                        value="{{ isset($adopcion) ? old('razaA', $adopcion->expediente->animal->raza->raza) : (isset($expElegido) ? old('razaA', $expElegido->animal->raza->raza) : old('razaA')) }}">
                                                    <label class="inputFieldLabel colorLabel" for="razaA">Raza</label>
                                                    <i class="inputFieldIcon fas fa-paw colorIcon"></i>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="inputContainer">
                                                    <input name="sexoA" id="sexoA" class="inputField"
                                                        type="text" readonly
                                                        value="{{ isset($adopcion) ? old('sexoA', $adopcion->expediente->animal->sexo) : (isset($expElegido) ? old('sexoA', $expElegido->animal->sexo) : old('sexoA')) }}">
                                                    <label class="inputFieldLabel colorLabel" for="sexoA">Sexo:</label>
                                                    <i class="inputFieldIcon fas fa-dna colorIcon"></i>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="inputContainer">
                                                    <input name="particularidadA" id="particularidadA" class="inputField"
                                                        type="text" readonly
                                                        value="{{ isset($adopcion) ? old('particularidadA', $adopcion->expediente->animal->particularidad) : (isset($expElegido) ? old('particularidadA', $expElegido->animal->particularidad) : old('particularidadA')) }}">
                                                    <label class="inputFieldLabel colorLabel"
                                                        for="particularidadA">Particularidad:</label>
                                                    <i class="inputFieldIcon fas fa-comments colorIcon"></i>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 d-flex align-items-center justify-content-center">

                                    @if (isset($adopcion->expediente))
                                        <div
                                            style="margin-bottom:35px; width: 100%; height: 10rem; display:flex; justify-content: center; align-items: center; overflow: hidden;">
                                            <img src="{{ isset($adopcion->expediente->animal->imagen) ? asset($adopcion->expediente->animal->imagen) : asset('img/especie.png') }}"
                                                alt="user" class="picture"
                                                style="width: 75%; height: 100%; object-fit: cover;" />
                                        </div>
                                    @elseif (isset($expElegido))
                                        <input type="hidden" name="img"
                                            value="{{ old('img', $expElegido->animal->imagen) }}">
                                        <div
                                            style="margin-bottom:35px; width: 100%; height: 10rem; display:flex; justify-content: center; align-items: center; overflow: hidden;">
                                            <img src="{{ isset($expElegido->animal->imagen) ? asset($expElegido->animal->imagen) : asset(old('img', 'img/especie.png')) }}"
                                                alt="user" class="picture"
                                                style="width: 75%; height: 100%; object-fit: cover;" />
                                        </div>
                                    @else
                                        <input type="hidden" name="img" value="{{ old('img') }}">
                                        @if (old('img') != '')
                                            <div
                                                style="margin-bottom:35px; width: 100%; height: 10rem; display:flex; justify-content: center; align-items: center; overflow: hidden;">
                                                <img src="{{ asset(old('img', 'img/especie.png')) }}" alt="user"
                                                    class="picture"
                                                    style="width: 75%; height: 100%; object-fit: cover;" />
                                            </div>
                                        @else
                                            <div
                                                style="margin-bottom: 35px; border-radius: 10px; width: 75%; height: 10rem; display: flex; justify-content: center; align-items: center; overflow: hidden; border: 2px dashed #c4c4c4; position: relative;">
                                                <div
                                                    style=" width: 100%; height: 100% background-color: #c4c4c4; display: flex; justify-content: center; align-items: center;">
                                                    <i class="fa fa-camera" style="color: #c4c4c4; font-size: 3rem;"></i>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-xl-6 " style="padding-left: 0%">
                            <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">

                                <div class="d-flex flex-row  align-items-center" style="color: #878787;">
                                    <div class="d-flex align-items-center me-auto" style="gap: 8px">
                                        <i class="fas fa-user" style="font-size: 24px"></i>
                                        <h3 style="margin: 0;">Adoptante</h3>
                                    </div>

                                    @if ((isset($adopcion) && $adopcion->aceptacion == 0) || !isset($adopcion))

                                        <div class="d-flex align-items-center " style="gap: 8px">
                                            ¿Ya ha realizado este proceso?
                                            <button type="button" class="button button-pri" data-bs-toggle="modal"
                                                data-bs-target="#buscarAdoptante"
                                                style="width: auto;padding: 7px 7px; justify-items: end">
                                                <i class="svg-icon fas fa-search"></i>
                                                <span class="lable">Buscar adoptante </span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                @error('idAdoptante')
                                    <span style="margin-top:-25px;" class="text-danger px-2">{{ $message }}</span>
                                @enderror
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="row mt-2" style="justify-content: center;">
                                            <div class="row">

                                                <input name="idAdoptante" id="idAdoptante" class="inputField"
                                                    type="hidden"
                                                    value="{{ isset($adopcion) ? old('idAdoptante', $adopcion->adoptante->idAdoptante) : (isset($adElegido) ? old('idAdoptante', $adElegido->idAdoptante) : old('idAdoptante')) }}">
                                                <div class="col-xl-6 col-md-6">
                                                    <div class="inputContainer">
                                                        <input name="nombres" id="nombres" class="inputField"
                                                            placeholder="Nombres" type="text" autocomplete="off"
                                                            {{ isset($adopcion) && $adopcion->aceptacion != 0 ? 'readonly' : '' }}
                                                            value="{{ isset($adopcion) ? old('nombres', $adopcion->adoptante->nombres) : (isset($adElegido) ? old('nombres', $adElegido->nombres) : old('nombres')) }}">
                                                        <label class="inputFieldLabel" for="nombres">Nombre
                                                            completo:*</label>
                                                        <i class="inputFieldIcon fas fa-pencil"></i>
                                                        @error('nombres')
                                                            <small style="color:red">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="col-xl-6 col-md-6">
                                                    <div class="inputContainer">
                                                        <input name="apellidos" id="apellidos" class="inputField"
                                                            {{ isset($adopcion) && $adopcion->aceptacion != 0 ? 'readonly' : '' }}
                                                            placeholder="Apellidos" type="text" autocomplete="off"
                                                            value="{{ isset($adopcion) ? old('apellidos', $adopcion->adoptante->apellidos) : (isset($adElegido) ? old('apellidos', $adElegido->apellidos) : old('apellidos')) }}">
                                                        @error('apellidos')
                                                            <small style="color:red">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="inputContainer ">
                                                        <input name="dui" id="dui"
                                                            {{ isset($adopcion) && $adopcion->aceptacion != 0 ? 'readonly' : '' }}
                                                            value="{{ isset($adopcion) ? old('dui', $adopcion->adoptante->dui) : (isset($adElegido) ? old('dui', $adElegido->dui) : old('dui')) }}"
                                                            class="inputField" placeholder="00000000-0" type="text"
                                                            autocomplete="off" oninput="validarDui(this)">
                                                        <label class="inputFieldLabel" name="texto">DUI:*</label>
                                                        <i class="inputFieldIcon fas fa-id-card" id="iconDui"
                                                            name="logoDui"></i>
                                                        @error('dui')
                                                            <small style="color:red">{{ $message }}</small>
                                                        @enderror

                                                    </div>
                                                </div>
                                            </div>

                                            {{-- se empieza desde cero --}}
                                            @if (!isset($adopcion) && !isset($adElegido))
                                                <input type="hidden" name="con" id="con"
                                                    value="{{ old('con', 1) }}">
                                                @php  $con = old('con',1);@endphp
                                                <div class="row" id="telefono-container">
                                                    @for ($i = 0; $i < $con; $i++)
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="inputContainer">
                                                                    <input class="inputField telefono" id="tel"
                                                                        name="telefonosAd[]" type="text"
                                                                        autocomplete="off" oninput="validarInput(this)"
                                                                        value="{{ old('telefonosAd.' . $i, '+503 ') }}">
                                                                    <label class="inputFieldLabel"
                                                                        for="telefono">Teléfono(s):*</label>
                                                                    <i class="inputFieldIcon fas fa-phone"></i>
                                                                    <small style="color:red"
                                                                        class="error-message"></small>
                                                                    @error('telefonosAd.' . $i)
                                                                        <small style="color:red">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                @if ($i == 0)
                                                                    <button type="button" class="button button-pri"
                                                                        id="add-telefono" data-bs-pp="tooltip"
                                                                        data-bs-placement="top" title="Añadir teléfono">
                                                                        <i class="svg-icon fas fa-plus"></i>
                                                                    </button>
                                                                @else
                                                                    <button type="button" data-bs-pp="tooltip"
                                                                        data-bs-placement="top" title="Eliminar telefono"
                                                                        class=" button button-sec remove-telefono"
                                                                        data-telefono-id="" data-telefono-e="">
                                                                        <i class="svg-icon fas fa-minus"></i>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endfor
                                                </div>
                                                {{-- se cargan los datos del adoptante de la adopcion --}}
                                            @elseif(isset($adopcion))
                                                @php
                                                    $leght = $adopcion->adoptante->telefono_adoptantes->count();
                                                @endphp
                                                <input type="hidden" name="con" id="con"
                                                    value="{{ old('con', $leght) }}">
                                                @php  $con = old('con', $leght);@endphp
                                                <div class="row" id="telefono-container">
                                                    @foreach ($adopcion->adoptante->telefono_adoptantes as $tel)
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="inputContainer">
                                                                    <input class="inputField telefono" id="tel"
                                                                        name="telefonosAd[]" type="text"
                                                                        autocomplete="off" oninput="validarInput(this)"
                                                                        {{ $adopcion->aceptacion != 0 ? 'readonly' : '' }}
                                                                        value="{{ old('telefonosAd.' . $loop->index, $tel->telefono) }}">
                                                                    <label class="inputFieldLabel"
                                                                        for="telefono">Teléfono(s):*</label>
                                                                    <i class="inputFieldIcon fas fa-phone"></i>
                                                                    <small style="color:red"
                                                                        class="error-message"></small>
                                                                    @error('telefonosAd.' . $loop->index)
                                                                        <small style="color:red">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            @if ($adopcion->aceptacion == 0)
                                                                <div class="col-xl-6">
                                                                    @if ($loop->index == 0)
                                                                        <button type="button" class="button button-pri"
                                                                            id="add-telefono" data-bs-pp="tooltip"
                                                                            data-bs-placement="top"
                                                                            title="Añadir teléfono">
                                                                            <i class="svg-icon fas fa-plus"></i>
                                                                        </button>
                                                                    @else
                                                                        <button type="button" data-bs-pp="tooltip"
                                                                            data-bs-placement="top"
                                                                            title="Eliminar telefono"
                                                                            class=" button button-sec remove-telefono"
                                                                            data-remove="remove{{ $loop->index }}"
                                                                            data-telefono-id="{{ $tel->idTelefono }}"
                                                                            data-telefono-e="{{ $tel->telefono }}">
                                                                            <i class="svg-icon fas fa-minus"></i>
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                                {{-- se cargan los datos del adoptante elegido --}}
                                            @else
                                                @php
                                                    $leght = $adElegido->telefono_adoptantes->count();
                                                @endphp
                                                <input type="hidden" name="con" id="con"
                                                    value="{{ old('con', $leght) }}">
                                                @php  $con = old('con',$leght);@endphp
                                                <div class="row" id="telefono-container">
                                                    @foreach ($adElegido->telefono_adoptantes as $tel)
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="inputContainer">
                                                                    <input class="inputField telefono" id="tel"
                                                                        name="telefonosAd[]" type="text"
                                                                        autocomplete="off" oninput="validarInput(this)"
                                                                        value="{{ old('telefonosAd.' . $loop->index, $tel->telefono) }}">
                                                                    <label class="inputFieldLabel"
                                                                        for="telefono">Teléfono(s):*</label>
                                                                    <i class="inputFieldIcon fas fa-phone"></i>
                                                                    <small style="color:red"
                                                                        class="error-message"></small>
                                                                    @error('telefonosAd.' . $loop->index)
                                                                        <small style="color:red">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                @if ($loop->index == 0)
                                                                    <button type="button" class="button button-pri"
                                                                        id="add-telefono" data-bs-pp="tooltip"
                                                                        data-bs-placement="top" title="Añadir teléfono">
                                                                        <i class="svg-icon fas fa-plus"></i>
                                                                    </button>
                                                                @else
                                                                    <button type="button" data-bs-pp="tooltip"
                                                                        data-bs-placement="top" title="Eliminar telefono"
                                                                        class=" button button-sec remove-telefono"
                                                                        data-remove="remove{{ $loop->index }}"
                                                                        data-telefono-id="{{ $tel->idTelefono }}"
                                                                        data-telefono-e="{{ $tel->telefono }}">
                                                                        <i class="svg-icon fas fa-minus"></i>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                            @if ((isset($adopcion) && $adopcion->aceptacion == 0) || !isset($adopcion))
                                                <div class="row">
                                                    <p style="margin-top: -25px;">(*)Campos Obligatorios</p>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-xl-6 " style="padding-right: 0%">
                            <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">

                                <div class="d-flex flex-row  align-items-center" style="color: #878787;">
                                    <div class="d-flex align-items-center me-auto" style="gap: 8px">
                                        <i class="fas fa-house" style="font-size: 24px"></i>
                                        <h3 style="margin: 0;">Hogar</h3>
                                    </div>
                                </div>
                                @error('idHogar')
                                    <span style="margin-top:-25px;" class="text-danger px-2">{{ $message }}</span>
                                @enderror
                                <div class="row mt-2">
                                    <div class="row">
                                        <input name="idHogar" id="idHogar" class="inputField" type="hidden"
                                            value="{{ isset($adopcion) ? old('idHogar', $adopcion->adoptante->idHogar) : (isset($adElegido) ? old('idHogar', $adElegido->idHogar) : old('idHogar')) }}">

                                        <div class="col-xl-12">
                                            <div class="inputContainer">
                                                <label class="inputFieldLabel" autocomplete="off"
                                                    for="direccion">Dirección:*</label>
                                                <i class="inputFieldIcon fas fa-location-dot"></i>
                                                <input placeholder="Ej. Calle Principal #123, Ciudad" class="inputField"
                                                    name="direccion"
                                                    {{ isset($adopcion) && $adopcion->aceptacion != 0 ? 'readonly' : '' }}
                                                    value="{{ isset($adopcion) ? old('direccion', $adopcion->adoptante->hogar->direccion) : (isset($adElegido) ? old('direccion', $adElegido->hogar->direccion) : old('direccion')) }}">
                                                @error('direccion')
                                                    <small style="color:red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-12">
                                            @if (isset($adopcion) && $adopcion->aceptacion != 0)
                                                <div class="inputContainer">
                                                    <label class="inputFieldLabel" for="raza">Tamaño del
                                                        hogar*</label>
                                                    <i class="inputFieldIcon fas fa-house"></i>
                                                    @error('tamanioHogar')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    <input class="inputField" name="direccion"
                                                        {{ isset($adopcion) && $adopcion->aceptacion != 0 ? 'readonly' : '' }}
                                                        value="{{ $adopcion->adoptante->hogar->tamanioHogar }}">

                                                </div>
                                            @else
                                                <div class="inputContainer">
                                                    <select id="tamanioHogar" name="tamanioHogar" class="inputField">
                                                        <option value=""
                                                            {{ !isset($adopcion) && !isset($adElegido) ? 'selected' : '' }}>
                                                            Seleccione una escala...</option>
                                                        <option value="Grande"
                                                            @if (isset($adopcion)) @if ($adopcion->adoptante->hogar->tamanioHogar == 'Grande')
                                                        selected @endif
                                                        @elseif (isset($adElegido))
                                                        @if ($adElegido->hogar->tamanioHogar == 'Grande') selected @endif @else
                                                            @if (old('tamanioHogar') == 'Grande') selected @endif @endif>
                                                            Grande</option>
                                                        <option value="Mediano"
                                                            @if (isset($adopcion)) @if ($adopcion->adoptante->hogar->tamanioHogar == 'Mediano')
                                                            selected 
                                                            @else 
                                                            '' @endif
                                                        @elseif (isset($adElegido))
                                                            @if ($adElegido->hogar->tamanioHogar == 'Mediano') selected
                                                            @else 
                                                                '' @endif
                                                        @else
                                                            @if (old('tamanioHogar') == 'Mediano') selected
                                                            @else 
                                                                '' @endif
                                                            @endif>
                                                            Mediano</option>
                                                        <option value="Pequeño"
                                                            @if (isset($adopcion)) @if ($adopcion->adoptante->hogar->tamanioHogar == 'Pequeño')
                                                        selected 
                                                        @else 
                                                        '' @endif
                                                        @elseif (isset($adElegido))
                                                            @if ($adElegido->hogar->tamanioHogar == 'Pequeño') selected
                                                        @else 
                                                            '' @endif
                                                        @else
                                                            @if (old('tamanioHogar') == 'Pequeño') selected
                                                        @else 
                                                            '' @endif
                                                            @endif>Pequeño</option>
                                                    </select>
                                                    <label class="inputFieldLabel" for="raza">Tamaño del
                                                        hogar*</label>
                                                    <i class="inputFieldIcon fas fa-house"></i>
                                                    @error('tamanioHogar')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="inputContainer">
                                                <label class="inputFieldLabel" autocomplete="off"
                                                    for="companiaHumana">Cantidad de
                                                    miembros que lo habitan:*</label>
                                                <i class="inputFieldIcon fas fa-users"></i>
                                                <input min="1" step="1"
                                                    {{ isset($adopcion) && $adopcion->aceptacion != 0 ? 'readonly' : '' }}
                                                    value="{{ isset($adopcion) ? old('companiaHumana', $adopcion->adoptante->hogar->companiaHumana) : (isset($adElegido) ? old('companiaHumana', $adElegido->hogar->companiaHumana) : old('companiaHumana', '1')) }}"
                                                    class="inputField" type="number" name="companiaHumana">
                                                @error('companiaHumana')
                                                    <small style="color:red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-5">
                                            <div class="inputContainer">
                                                <label class="inputFieldLabel">¿Habitan más mascotas?*</label>
                                                <i class="inputFieldIcon fas fa-dog"></i>
                                                <div style="padding: 3px 15px">
                                                    @if (!isset($adopcion) && !isset($adElegido))
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="isCompaniaAnimal" id="inlineRadio1" value="Sí"
                                                                {{ old('isCompaniaAnimal') == 'Sí' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="Sí">Sí</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="isCompaniaAnimal" id="inlineRadio2" value="No"
                                                                {{ old('isCompaniaAnimal') == 'No' ? 'checked' : (old('isCompaniaAnimal') == '' ? 'checked' : '') }}>
                                                            <label class="form-check-label" for="No">No</label>
                                                        </div>
                                                    @elseif (isset($adopcion))
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ isset($adopcion) && $adopcion->aceptacion != 0 ? 'disabled' : '' }}
                                                                name="isCompaniaAnimal" id="inlineRadio1" value="Sí"
                                                                {{ $adopcion->adoptante->hogar->companiaAnimal > 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="Sí">Sí</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                {{ isset($adopcion) && $adopcion->aceptacion != 0 ? 'disabled' : '' }}
                                                                name="isCompaniaAnimal" id="inlineRadio2" value="No"
                                                                {{ $adopcion->adoptante->hogar->companiaAnimal > 0 ? '' : 'checked' }}>
                                                            <label class="form-check-label" for="No">No</label>
                                                        </div>
                                                    @else
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="isCompaniaAnimal" id="inlineRadio1" value="Sí"
                                                                {{ $adElegido->hogar->companiaAnimal > 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="Sí">Sí</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="isCompaniaAnimal" id="inlineRadio2" value="No"
                                                                {{ $adElegido->hogar->companiaAnimal > 0 ? '' : 'checked' }}>
                                                            <label class="form-check-label" for="No">No</label>
                                                        </div>
                                                    @endif

                                                </div>
                                                @error('isCompaniaAnimal')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-7">
                                            <div class="d-flex  align-items-center">
                                                @if (!isset($adopcion) && !isset($adElegido))
                                                    <label class="form-check-label" id="lb-cant"
                                                        style="margin-right: 8px; color: {{ old('isCompaniaAnimal') == '' || old('isCompaniaAnimal') == 'No' ? '#878787' : '#000000' }}">Cantidad:*</label>
                                                    <input placeholder="" type="number" step="1"
                                                        value="{{ old('companiaAnimal', '1') }}"
                                                        @if (old('isCompaniaAnimal') == '' || old('isCompaniaAnimal') == 'No') disabled @endif
                                                        class="inputField w-100" min="1" name="companiaAnimal">
                                                @elseif (isset($adopcion))
                                                    @if ($adopcion->adoptante->hogar->companiaAnimal == 0)
                                                        <label class="form-check-label" id="lb-cant"
                                                            style="margin-right: 8px; color: #878787">Cantidad:*</label>
                                                        <input placeholder="" type="number" step="1"
                                                            value="{{ old('companiaAnimal', $adopcion->adoptante->hogar->companiaAnimal + 1) }}"
                                                            disabled class="inputField w-100" min="1"
                                                            name="companiaAnimal">
                                                    @else
                                                        <label class="form-check-label;" id="lb-cant"
                                                            style="margin-right: 8px">Cantidad:*</label>
                                                        <input placeholder="" type="number" step="1"
                                                            {{ $adopcion->aceptacion != 0 ? 'readonly' : '' }}
                                                            value="{{ old('companiaAnimal', $adopcion->adoptante->hogar->companiaAnimal) }}"
                                                            class="inputField w-100" min="1"
                                                            name="companiaAnimal">
                                                    @endif
                                                @else
                                                    @if ($adElegido->hogar->companiaAnimal == 0)
                                                        <label class="form-check-label" id="lb-cant"
                                                            style="margin-right: 8px; color: #878787">Cantidad:*</label>
                                                        <input placeholder="" type="number" step="1"
                                                            value="{{ old('companiaAnimal', $adElegido->hogar->companiaAnimal + 1) }}"
                                                            disabled class="inputField w-100" min="1"
                                                            name="companiaAnimal">
                                                    @else
                                                        <label class="form-check-label" id="lb-cant"
                                                            style="margin-right: 8px;">Cantidad:*</label>
                                                        <input placeholder="" type="number" step="1"
                                                            value="{{ old('companiaAnimal', $adElegido->hogar->companiaAnimal) }}"
                                                            class="inputField w-100" min="1"
                                                            name="companiaAnimal">
                                                    @endif
                                                @endif

                                                @error('companiaAnimal')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    @if ((isset($adopcion) && $adopcion->aceptacion == 0) || !isset($adopcion))
                                        <div class="row">
                                            <p style="margin-top: -25px;">(*)Campos Obligatorios</p>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    @if ((isset($adopcion) && $adopcion->aceptacion == 0) || !isset($adopcion))
                        <div class="row my-1 justify-content-center align-items-center" style="gap: 8px">
                            <button type="submit" class="button button-pri"
                                style="width: 20%;padding: 7px 7px; justify-items: end">
                                <i class="svg-icon fas fa-save"></i>
                                <span class="lable">{{ isset($adopcion) ? 'Modificar' : 'Guardar' }}<span>
                            </button>
                            <button type="button"
                                onclick="window.location.href='{{ isset($adopcion) ? url('adopcion') : route('adopcion.create') }}'"
                                class="button button-red" style="width: 20%;padding: 7px 7px; justify-items: end">
                                <i class="svg-icon fas fa-rotate-right"></i>
                                <span class="lable">Cancelar<span>
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </main>
        @include('adopcion.modalesAdopcion')
    </div>

@endsection
