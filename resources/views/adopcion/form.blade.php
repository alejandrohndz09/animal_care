@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/cards.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/JsAdopcion.js') }}"></script>
    <script src="{{ asset('js/tabAdopcion.js') }}"></script>
@endsection
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-5 py-4">
                <div class="row mt-3">
                    {{-- si se coloca como panel: --}}
                    <div class="mb-4" style=" width:100%;margin: 0; display: flex; gap: 5px; align-items: center; ">
                        <button class="button btn-transparent" style="width: 30px;padding: 15px 5px" type="button"
                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" data-bs-pp="tooltip"
                            data-bs-placement="top" title="Volver" onclick="window.location.href='/adopcion'">
                            <i class="svg-icon fas fa-chevron-left" style="color: #4c4c4c"></i>
                        </button>
                        <h1>
                            {{ isset($adopcion) ? 'Actualizar proceso de adopción' : 'Nuevo proceso de adopción' }}
                        </h1>

                    </div>
                    {{-- si se coloca como vista individual:
                    <div class="mb-4"
                        style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom:5px; border-bottom: 2px solid rgba(0, 0, 0, 0.1);">
                        <div style=" width:100%;margin: 0; display: flex; gap: 5px; align-items: center; ">
                            <button class="button btn-transparent" style="width: 30px;padding: 15px 5px" type="button"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-pp="tooltip" data-bs-placement="top" title="Volver"
                                onclick="window.location.href='/adopcion'">
                                <i class="svg-icon fas fa-chevron-left" style="color: #4c4c4c"></i>
                            </button>
                            <h1>
                                {{ isset($adopcion) ? 'Actualizar proceso de adopción' : 'Nuevo proceso de adopción' }}
                            </h1>
                        </div>
                    </div> --}}
                    <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">

                        <div class="d-flex flex-row  align-items-center" style="color: #878787;">
                            <div class="d-flex align-items-center me-auto" style="gap: 8px">
                                <i class="fas fa-paw" style="font-size: 24px"></i>
                                <h3 style="margin: 0;">Datos del animal</h3>
                            </div>
                            Este apartado no es editable, seleccione el expediente del animal a adoptar.
                            <button type="button" class="button button-pri" data-bs-toggle="modal"
                                data-bs-target="#buscarExpediente"
                                style="width: auto;padding: 7px 7px; margin-left:8px; justify-items: end">
                                <i class="svg-icon fas fa-search"></i>
                                <span class="lable">Buscar expediente</span>
                            </button>
                        </div>

                        <div class="row">
                            <style>
                                .colorLabel {
                                    color: {{ isset($adopcion->expediente) || isset($expElegido) ? '#000000' : '#878787' }};
                                }

                                .colorIcon {
                                    color: {{ isset($adopcion->expediente) || isset($expElegido) ? '#6067eb' : '#878787' }}
                                }
                            </style>
                            <div class="col-xl-9">
                                <div class="row mt-1" style="justify-content: center;">
                                    <div class="row">
                                        <div class="col-xl-6 col-md-6">
                                            <div class="inputContainer">
                                                <input name="expA" id="expA" class="inputField" type="text"
                                                    readonly
                                                    value="{{ isset($adopcion) ? old('expA', $adopcion->idExpediente) : (isset($expElegido) ? old('expA', $expElegido->idExpediente) : old('expA')) }}">
                                                <label class="inputFieldLabel colorLabel" for="expA">No.
                                                    Expediente:</label>
                                                <i class="inputFieldIcon fas fa-file-signature colorIcon"></i>
                                            </div>

                                        </div>
                                        <div class="col-xl-6 col-md-6">
                                            <div class="inputContainer">
                                                <input name="nombreA" id="nombreA" class="inputField" type="text"
                                                    readonly
                                                    value="{{ isset($adopcion) ? old('nombreA', $adopcion->expediente->animal->nombre) : (isset($expElegido) ? old('nombreA', $expElegido->animal->nombre) : old('nombreA')) }}">
                                                <label class="inputFieldLabel colorLabel" for="nombre">Nombre:</label>
                                                <i class="inputFieldIcon fas fa-pencil colorIcon"></i>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-xl-4 col-md-4">
                                            <div class="inputContainer">
                                                <input name="edadA" id="edad" class="inputField" type="text"
                                                    readonly @php use App\Http\Controllers\AnimalControlador; @endphp
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
                                                        : '' }}">
                                                <label class="inputFieldLabel colorLabel" for="edad">Edad
                                                    estimada:</label>
                                                <i class="inputFieldIcon fas fa-calendar colorIcon"></i>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="inputContainer">
                                                <input name="especieA" id="especieA" class="inputField" type="text"
                                                    readonly
                                                    value="{{ isset($adopcion) ? old('especieA', $adopcion->expediente->animal->raza->especie->especie) : (isset($expElegido) ? old('especieA', $expElegido->animal->raza->especie->especie) : old('especieA')) }}">
                                                <label class="inputFieldLabel colorLabel" for="especieA">Especie:</label>
                                                <i class="inputFieldIcon fas fa-bone colorIcon"></i>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="inputContainer">
                                                <input name="razaA" id="razaA" class="inputField" type="text"
                                                    readonly
                                                    value="{{ isset($adopcion) ? old('razaA', $adopcion->expediente->animal->raza->raza) : (isset($expElegido) ? old('razaA', $expElegido->animal->raza->raza) : old('razaA')) }}">
                                                <label class="inputFieldLabel colorLabel" for="razaA">Raza</label>
                                                <i class="inputFieldIcon fas fa-paw colorIcon"></i>
                                            </div>
                                        </div>


                                    </div>


                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="inputContainer">
                                                <input name="sexoA" id="sexoA" class="inputField" type="text"
                                                    readonly
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
                                        <img src="{{ isset($a->expediente->animal->imagen) ? asset($a->expedeinte->animal->imagen) : asset('imagenes/huella.png') }}"
                                            alt="user" class="picture"
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
                                <div class="d-flex align-items-center " style="gap: 8px">
                                    ¿Ya ha realizado este proceso?
                                    <button type="button" class="button button-pri" data-bs-toggle="modal"
                                        data-bs-target="#buscarAdoptante"
                                        style="width: auto;padding: 7px 7px; justify-items: end">
                                        <i class="svg-icon fas fa-search"></i>
                                        <span class="lable"> Encuéntrelo acá </span>
                                    </button>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="row mt-2" style="justify-content: center;">
                                        <div class="row">

                                            <input name="idAdoptante" id="idAdoptante" class="inputField" type="hidden"
                                                value="{{ isset($adopcion) ? old('idAdoptante', $adopcion->adoptante->idAdoptante) : (isset($adElegido) ? old('idAdoptante', $adElegido->idAdoptante) : old('idAdoptante')) }}">
                                            <div class="col-xl-6 col-md-6">
                                                <div class="inputContainer">
                                                    <input name="nombresAd" id="nombresAd" class="inputField"
                                                        placeholder="Nombres" type="text" autocomplete="off"
                                                        value="{{ isset($adopcion) ? old('nombresAd', $adopcion->adoptante->nombres) : (isset($adElegido) ? old('nombresAd', $adElegido->nombres) : old('nombresAd')) }}">
                                                    <label class="inputFieldLabel" for="nombresAd">Nombre
                                                        completo:*</label>
                                                    <i class="inputFieldIcon fas fa-pencil"></i>
                                                    @error('nombresAd')
                                                        <small style="color:red">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="col-xl-6 col-md-6">
                                                <div class="inputContainer">
                                                    <input name="apellidosAd" id="apellidosAd" class="inputField"
                                                        placeholder="Apellidos" type="text" autocomplete="off"
                                                        value="{{ isset($adopcion) ? old('apellidosAd', $adopcion->adoptante->apellidos) : (isset($adElegido) ? old('apellidosAd', $adElegido->apellidos) : old('apellidosAd')) }}">
                                                    @error('apellidosAD')
                                                        <small style="color:red">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="inputContainer ">
                                                    <input name="duiAd" id="duiAd"
                                                        value="{{ isset($adopcion) ? old('duiAd', $adopcion->adoptante->dui) : (isset($adElegido) ? old('duiAd', $adElegido->dui) : old('duiAd')) }}"
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
                                        @if (!isset($adopcion) || !isset($adElegido))
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
                                                                    value="+503 {{ old('telefonosAd.' . $i) }}">
                                                                <label class="inputFieldLabel"
                                                                    for="telefono">Teléfono(s):*</label>
                                                                <i class="inputFieldIcon fas fa-phone"></i>
                                                                <small style="color:red" class="error-message"></small>
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
                                                                    data-remove="remove{{ $contador }}"
                                                                    data-telefono-id="{{ $item->idTelefono }}"
                                                                    data-telefono-e="{{ $item->telefono }}">
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
                                                $leght = count($adopcion->adoptante->telefono_adoptantes);
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
                                                                    value="{{ old('telefonosAd.' . $loop->index, $tel->telefono) }}">
                                                                <label class="inputFieldLabel"
                                                                    for="telefono">Teléfono(s):*</label>
                                                                <i class="inputFieldIcon fas fa-phone"></i>
                                                                <small style="color:red" class="error-message"></small>
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
                                            {{-- se cargan los datos del adoptante elegido --}}
                                        @else
                                            @php
                                                $leght = count($adElegido->telefono_adoptantes);
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
                                                                <small style="color:red" class="error-message"></small>
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

                            <div class="row mt-2">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="inputContainer">
                                            <label class="inputFieldLabel" autocomplete="off"
                                                for="direccion">Dirección</label>
                                            <i class="inputFieldIcon fas fa-location-dot"></i>
                                            <input placeholder="Ej. Calle Principal #123, Ciudad" class="inputField"
                                                name="direccionH"
                                                value="{{ isset($adopcion) ? old('direccionH', $adopcion->adoptante->hogar->direccion) : (isset($adElegido) ? old('direccionH', $adElegido->hogar->direccion) : old('direccionH')) }}">
                                            @error('direccionH')
                                                <small style="color:red">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="inputContainer">
                                            <select id="tamanioHogar" name="tamanioHogar" class="inputField">
                                                <option value=""
                                                    {{ !isset($adopcion) && !isset($adElegido) ? 'selected' : '' }}>
                                                    Seleccione una escala...</option>
                                                <option value="Grande"
                                                    @if (isset($adopcion)) @if ($adopcion->adoptante->hogar->tamanioHogar == 'Grande')
                                                     'selected' 
                                                     @else 
                                                     '' @endif
                                                @elseif (isset($adElegido))
                                                    @if ($adElegido->hogar->tamanioHogar == 'Grande') 'selected'
                                                    @else 
                                                        '' @endif
                                                @else
                                                    @if (old('tamanioHogar') == 'Grande') 'selected'
                                                    @else 
                                                        '' @endif
                                                    @endif>
                                                    Grande</option>
                                                <option value="Mediana"
                                                    @if (isset($aMediano)) @if ($adopcion->adoptante->hogar->tamanioHogar == 'Mediano')
                                                        'selected' 
                                                        @else 
                                                        '' @endif
                                                @elseif (isset($adElegido))
                                                    @if ($adElegido->hogar->tamanioHogar == 'Mediano') 'selected'
                                                        @else 
                                                            '' @endif
                                                @else
                                                    @if (old('tamanioHogar') == 'Mediano') 'selected'
                                                        @else 
                                                            '' @endif
                                                    @endif>
                                                    Mediano</option>
                                                <option value="Pequeño"
                                                    @if (isset($adopcion)) @if ($adopcion->adoptante->hogar->tamanioHogar == 'Pequeño')
                                                    'selected' 
                                                    @else 
                                                    '' @endif
                                                @elseif (isset($adElegido))
                                                    @if ($adElegido->hogar->tamanioHogar == 'Pequeño') 'selected'
                                                    @else 
                                                        '' @endif
                                                @else
                                                    @if (old('tamanioHogar') == 'Pequeño') 'selected'
                                                    @else 
                                                        '' @endif
                                                    @endif>Pequeño</option>
                                            </select>
                                            <label class="inputFieldLabel" for="raza">Tamaño del hogar*</label>
                                            <i class="inputFieldIcon fas fa-house"></i>
                                            @error('tamanioHogar')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
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
                                                value="{{ isset($adopcion) ? old('companiaHumana', $adopcion->adoptante->hogar->tamanioHogar) : (isset($adElegido) ? old('companiaHumana', $adElegido->hogar->tamanioHogar) : old('companiaHumana', '1')) }}"
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
                                                            {{ old('isCompaniaAnimal') == 'No' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="No">No</label>
                                                    </div>
                                                @elseif (isset($adopcion))
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="isCompaniaAnimal" id="inlineRadio1" value="Sí"
                                                            {{ $adopcion->adoptante->hogar->companiaAnimal > 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="Sí">Sí</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
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
                                            <label class="form-check-label" style="margin-right: 8px">Cantidad:*</label>
                                            <input placeholder="" type="number" step="1"
                                                value="{{ isset($adopcion) ? old('companiaAnimal', $adopcion->adoptante->hogar->companiaAnimal) : (isset($adElegido) ? old('companiaAnimal', $adElegido->hogar->companiaAnimal) : old('companiaAnimal', 1)) }}"
                                                class="inputField w-100" min="1" name="companiaAnimal">
                                            @error('companiaAnimal')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @include('adopcion.modalesAdopcion')
    </div>
    @if (session()->has('alert'))
        <script>
            Toast.fire({
                icon: "{{ session()->get('alert')['type'] }}",
                title: "{{ session()->get('alert')['message'] }}",
            });

            @php
                session()->keep('alert');
            @endphp
        </script>
    @endif
@endsection
