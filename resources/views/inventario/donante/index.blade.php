@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/JsDonante.js') }}"></script>
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
                        <div style=" width:100%;margin: 0; display: flex; gap: 5px; align-items: center; ">
                            <button class="button btn-transparent" style="width: 30px;padding: 15px 5px" type="button"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-pp="tooltip" data-bs-placement="top" title="Volver"
                                onclick="window.location.href='/inventario'">
                                <i class="svg-icon fas fa-chevron-left" style="color: #4c4c4c"></i>
                            </button>
                            <h1>Recursos </h1>
                        </div>
                        <div
                            style=" width:100%;margin: 0; display: flex; gap: 5px; justify-content: end ;align-items: center; ">
                            <input id="searchInput" class="inputField card" style="width: 100%;" autocomplete="off"
                                placeholder="🔍︎ Buscar" type="search">

                            <div class="dropdown">
                                <button class="button btn-transparent" style="width: 30px;padding: 15px 5px"
                                    type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                    aria-expanded="false" data-bs-pp="tooltip" data-bs-placement="top" title="Opciones">
                                    <i class="svg-icon fas fa-ellipsis-vertical" style="color: #4c4c4c"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" data-bs-toggle="modal"data-bs-target="#tabla">
                                            Donantes dados de baja</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                        
                        <table id="table">
                            <thead>
                                <tr class="head">
                                    <th style="width: 10%"></th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>dui</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody id="tableBody">

                                @foreach ($donantes as $item)
                                    @if ($item->estado == 1)
                                        <tr class="donante-row" data-donante="{{ json_encode($item) }}">
                                            <td style="width: 10%">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                                    alt="user" class="picture" />
                                            </td>
                                            <td>{{ $item->nombres }}</td>
                                            <td>{{ $item->apellidos }}</td>
                                            <td>{{ $item->dui }} </td>
                                            <td>
                                                <div
                                                    style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                                    <button
                                                        onclick="window.location.href = '{{ url('inventario/donantes/' . $item->idDonante . '/edit') }}';"
                                                        type="button" class="button button-blue btnUpdate"
                                                        style="width: 45%" data-bs-pp="tooltip" data-bs-placement="top"
                                                        title="Editar">
                                                        <i class="svg-icon fas fa-pencil"></i>
                                                    </button>


                                                    <button type="button" class="button button-red btnDelete"
                                                        data-bs-pp="tooltip" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalToggle" style="width: 45%"
                                                        data-donante="{{ json_encode($item) }}" data-bs-placement="top"
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
                                {{ isset($donanteEdit) ? 'Editar Registro' : 'Nuevo registro' }}
                            </h3>
                            <form
                                action="{{ isset($donanteEdit) ? url('/inventario/donantes/update/' . $donanteEdit->idDonante) : '' }}"
                                id="miFormulario" name="form" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($donanteEdit))
                                    @method('PUT') <!-- Utilizar el método PUT para la actualización -->
                                @endif

                                <!-- Input Nombres -->
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="inputContainer">
                                            <input name="nombres" id="nombres" class="inputField" placeholder="Nombres"
                                                type="text" autocomplete="off" oninput="validarTexto(this)"
                                                value="{{ isset($donanteEdit) ? $donanteEdit->nombres : old('nombres') }}">
                                            <label class="inputFieldLabel" for="nombre">Nombres*</label>
                                            <i class="inputFieldIcon fas fa-user"></i>
                                            @error('nombres')
                                                <small style="color:red">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Input Apellidos -->
                                    <div class="col-xl-6">
                                        <div class="inputContainer">
                                            <input name="apellidos" class="inputField" autocomplete="off"
                                                placeholder="Apellidos" type="text" oninput="validarTexto(this)"
                                                value="{{ isset($donanteEdit) ? $donanteEdit->apellidos : old('apellidos') }}">
                                            @error('apellidos')
                                                <small style="color:red">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Input DUI -->
                                    <div class="col-xl-12">
                                        <div class="inputContainer ">
                                            <input name="dui" id="dui"
                                                value="{{ isset($donanteEdit) ? $donanteEdit->dui : old('dui') }}"
                                                class="inputField" placeholder="00000000-0" type="text"
                                                autocomplete="off" oninput="validarDui(this)">
                                            <label class="inputFieldLabel" name="texto">DUI:*</label>
                                            <i class="inputFieldIcon fas fa-id-card" id="iconDui" name="logoDui"></i>
                                            @error('dui')
                                                <small style="color:red">{{ $message }}</small>
                                            @enderror

                                        </div>
                                    </div>
                                </div>


                                {{-- ... (código existente) ... --}}
                                @if (!isset($donanteEdit))
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
                                @elseif(isset($donanteEdit))
                                    @php
                                        $leght = count($donanteEdit->telefono_donantes);
                                    @endphp

                                    <input type="hidden" name="con" id="con"
                                        value="{{ old('con', $leght) }}">
                                    @php $con = old('con', $leght); @endphp

                                    <div class="row" id="telefono-container">
                                        @foreach ($donanteEdit->telefono_donantes as $tel)
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
                                {{-- ... (código existente) ... --}}


                                <div class="row">
                                    <p style="margin-top: -25px;">(*)Campos Obligatorios</p>
                                </div>


                                <!-- Botones para la vista -->
                                <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                    <button type="submit" class="button button-pri" id="buttonAction">
                                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                        <span class="lable">
                                            {{ isset($donanteEdit) ? 'Modificar' : 'Guardar' }}
                                        </span>
                                    </button>
                                    <button onclick="window.location.href = '{{ url('inventario/donantes') }}'"
                                        type="button" id="btnCancelar" class="button button-red">
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
    @include('inventario.donante.modalesDonante')
@endsection
