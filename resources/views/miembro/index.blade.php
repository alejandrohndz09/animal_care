@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/Jsmiembro.js') }}"></script>
@endsection

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div style=" width: 100%;display: flex;align-items: center;justify-content: space-between;">
                </div>

                <div class="row mt-3">
                    <div class="col-xl-7">
                        <div
                            style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h1>Miembros </h1>
                            <input id="searchInput" class="inputField card" style="width: 50%; margin-left: 20% "
                                autocomplete="off" placeholder="🔍︎ Buscar" type="search">

                            <div class="dropdown">
                                <button class="button btn-transparent" style="width: 30px;padding: 15px 5px" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="svg-icon fas fa-ellipsis-vertical" style="color: #4c4c4c"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#tabla">Miembro de
                                            baja</a></li>
                                </ul>
                            </div>
                        </div>
                        <table id="table">
                            <thead>
                                <tr class="head">
                                    <th style="width: 10%"></th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Correo</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody id="tableBody">

                                @foreach ($datos as $item)
                                    @if ($item->estado == 1)
                                        <tr class="miembro-row" data-miembro="{{ json_encode($item) }}">
                                            <td style="width: 10%">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                                    alt="user" class="picture" />
                                            </td>
                                            <td>{{ $item->nombres }}</td>
                                            <td>{{ $item->apellidos }}</td>
                                            <td>{{ $item->correo }} </td>
                                            <td>
                                                <div
                                                    style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                                    <button
                                                        onclick="window.location.href = '{{ url('miembro/' . $item->idMiembro . '/edit') }}';"
                                                        type="button" class="button button-blue btnUpdate"
                                                        style="width: 45%" data-id="{{ $item->idMiembro }}"
                                                        data-dui="{{ $item->dui }}" data-bs-pp="tooltip"
                                                        data-bs-placement="top" title="Editar">
                                                        <i class="svg-icon fas fa-pencil"></i>
                                                    </button>


                                                    <button type="button" class="button button-red btnDelete"
                                                        data-bs-pp="tooltip" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalToggle" style="width: 45%"
                                                        data-miembro="{{ json_encode($item) }}" data-bs-placement="top"
                                                        title="Dar de baja">
                                                        <i class="svg-icon fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div id="pagination">

                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                            <h3 style="padding: -5px 0px !important;">
                                {{ isset($miembroEdit) ? 'Editar Registro' : 'Nuevo registro' }}
                            </h3>
                            <form
                                action="{{ isset($miembroEdit) ? url('miembro/update/' . $miembroEdit->idMiembro) : '' }}"
                                id="miFormulario" name="form" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($miembroEdit))
                                    @method('PUT') <!-- Utilizar el método PUT para la actualización -->
                                @endif

                                <!-- Input Nombres -->
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="inputContainer">
                                            <input name="nombres" id="nombres" class="inputField" placeholder="Nombres"
                                                type="text" autocomplete="off" oninput="validarTexto(this)"
                                                value="{{ isset($miembroEdit) ? $miembroEdit->nombres : old('nombres') }}">
                                            <label class="inputFieldLabel" for="nombre">Nombres*</label>
                                            <i class="inputFieldIcon fas fa-user"></i>
                                            <small style="color:red" class="error-message"></small>
                                        </div>
                                    </div>
                                    <!-- Input Apellidos -->
                                    <div class="col-xl-6">
                                        <div class="inputContainer">
                                            <input name="apellidos" class="inputField" autocomplete="off"
                                                placeholder="Apellidos" type="text" oninput="validarTexto(this)"
                                                value="{{ isset($miembroEdit) ? $miembroEdit->apellidos : old('apellidos') }}">
                                            <small style="color:red" class="error-message"></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Input DUI -->
                                    <div class="col-xl-6">
                                        <div class="inputContainer col-xl-6">
                                            <input name="dui" id="dui"
                                                value="{{ isset($miembroEdit) ? $miembroEdit->dui : old('dui') }}"
                                                class="inputField" placeholder="00000000-0" type="text"
                                                autocomplete="off"
                                                {{ isset($miembroEdit) ? (empty($miembroEdit->dui) ? 'disabled' : '') : (old('dui') == '' ? 'disabled' : '') }}
                                                oninput="validarDui(this)">
                                            <label class="inputFieldLabel" name="texto">DUI*</label>
                                            <i class="inputFieldIcon fas fa-id-card" id="iconDui"
                                                style="color:  {{ isset($miembroEdit) ? (empty($miembroEdit->dui) ? '#cdcbcd' : '#6067eb') : (old('dui') == '' ? '#cdcbcd' : '#6067eb') }}"
                                                name="logoDui"></i>
                                            @error('dui')
                                                <small style="color:red">{{ $message }}</small>
                                            @enderror
                                            <small style="color:red" class="error-message"></small>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="inputContainer">
                                            <div style="padding: 3px 15px">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" name="esMayorDeEdad" type="checkbox"
                                                        id="esMayorDeEdad"
                                                        {{ isset($miembroEdit) ? (empty($miembroEdit->dui) ? '' : 'checked') : (old('dui') == '' ? '' : 'checked') }}>
                                                    <label class="form-check-label" for="esMayorDeEdad">¿Es mayor de
                                                        edad?</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Input Correo -->
                                <div class="inputContainer">
                                    <input class="inputField" name="correo" autocomplete="off" placeholder="Correo"
                                        type="email"
                                        value="{{ isset($miembroEdit) ? $miembroEdit->correo : old('correo') }}">
                                    <label class="inputFieldLabel">Correo*</label>
                                    <i class="inputFieldIcon fas fa-envelope"></i>
                                    <small style="color:red" class="error-message"></small>
                                    @error('correo')
                                        <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Condicional para verificar si esta modificando o agregando telefonos -->
                              
                                @if (!isset($miembroEdit))
                                    <input type="hidden" name="con" id="con" value="{{ old('con', 1) }}">
                                    @php  $con = old('con',1); @endphp
                                    <div class="row" id="telefono-container">
                                        @for ($i = 0; $i < $con; $i++)
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="inputContainer">
                                                        <input class="inputField telefono" id="tel"
                                                            name="telefonosAd[]" type="text" autocomplete="off"
                                                            oninput="validarInput(this)"
                                                            value="{{ old('telefonosAd.' . $i, '+503 ') }}">
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
                                                            class=" button button-sec remove-telefono" data-telefono-id=""
                                                            data-telefono-e="">
                                                            <i class="svg-icon fas fa-minus"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endfor
                                    </div>

                                @elseif(isset($miembroEdit))
                                    @php
                                        $leght = count($miembroEdit->telefono_miembros);
                                    @endphp

                                    <input type="hidden" name="con" id="con"
                                        value="{{ old('con', $leght) }}">
                                    @php $con = old('con', $leght); @endphp

                                    <div class="row" id="telefono-container">
                                        @foreach ($miembroEdit->telefono_miembros as $tel)
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="inputContainer">
                                                        <input class="inputField telefono" id="tel"
                                                            name="telefonosAd[]" type="text" autocomplete="off"
                                                            oninput="validarInput(this)"
                                                            value="{{ old('telefonosAd.' . $loop->index, $tel->telefono) }}">

                                                        <!-- Agrega un campo oculto para almacenar el ID del teléfono -->
                                                        <input type="hidden" name="telefonoIds[]"
                                                            value="{{ $tel->idTelefono }}">

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

                                <p style="margin-top: -25px;">(*)Campos Obligatorios</p>
                                <!-- Botones para la vista -->
                                <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                    <button type="submit" class="button button-pri" id="buttonAction">
                                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                        <span class="lable">
                                            {{ isset($miembroEdit) ? 'Modificar' : 'Guardar' }}
                                        </span>
                                    </button>
                                    <button onclick="{{ url('miembro') }}" type="button" id="btnCancelar"
                                        class="button button-red">
                                        <i class="svg-icon fas fa-rotate-right"></i>
                                        <span class="lable">Cancelar</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @include('miembro.modalesMiembro')
@endsection
