@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/JsAlbergue.js') }}"></script>
@endsection
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div class="row mt-3">
                    <div class="col-xl-7">
                        <div
                            style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h1>Albergues </h1>
                            <input id="searchInput" class="inputField card" style="width: 50%; margin-left: 20% "
                                autocomplete="off" placeholder="🔍︎ Buscar" type="search">

                            <div class="dropdown">
                                <button class="button btn-transparent" style="width: 30px;padding: 15px 5px" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="svg-icon fas fa-ellipsis-vertical" style="color: #4c4c4c"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#tabla">Albergue de
                                            baja</a></li>
                                </ul>
                            </div>
                        </div>
                        <table>
                            <thead>
                                <tr class="head">
                                    <th style="width: 10%"></th>
                                    <th>Código</th>
                                    <th style="width: 40%">Direccion</th>
                                    <th>Responsable</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody id="tableBody">

                                @foreach ($Albergues as $item)
                                    @if ($item->estado == 1)
                                        <tr class="registro-row">
                                            <td style="width: 10%">
                                                <img src="{{ asset('img/albergue.png') }}" alt="user" class="picture" />
                                            </td>
                                            <td>{{ $item->idAlvergue }}</td>
                                            <td style="width: 40%">{{ $item->direccion }} </td>
                                            <td>{{ $item->miembro->nombres }} {{ $item->miembro->apellidos }}</td>

                                            <td>
                                                <div
                                                    style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                                    <a id="btnmodificar"
                                                        href="{{ url('albergue/' . $item->idAlvergue . '/edit') }}"
                                                        type="button" class="button button-blue btnUpdate"
                                                        data-id="{{ $item->idAlvergue }}" style="width: 45%"
                                                        data-bs-pp="tooltip" data-bs-placement="top" title="Editar">
                                                        <i class="svg-icon fas fa-pencil"></i>
                                                    </a>

                                                    <button type="button" class="button button-red btnDelete"
                                                        style="width: 45%" data-bs-toggle="modal"
                                                        data-bs-target="#modalDetalle" data-id="{{ $item->idAlvergue }}"
                                                        data-nombre="{{ $item->miembro->nombres }}"
                                                        data-apellido="{{ $item->miembro->apellidos }}"
                                                        data-direccion="{{ $item->direccion }}" data-bs-pp="tooltip"
                                                        data-bs-placement="top" title="Dar de baja">
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
                                {{ isset($AlbergueEdit) ? 'Editar Registro' : 'Nuevo Registro' }}</h3>
                            <form
                                action="{{ isset($AlbergueEdit) ? url('albergue/update/' . $AlbergueEdit->idAlvergue) : '' }}"
                                id="miFormulario" name="form" method="POST">
                                @csrf
                                @if (isset($AlbergueEdit))
                                    @method('PUT') <!-- Utilizar el método PUT para la actualización -->
                                @endif

                                <div class="row">
                                    <div class="col-xl-12">

                                        <div class="inputContainer">
                                            <label class="inputFieldLabel" autocomplete="off"
                                                for="direccion">Dirección</label>
                                            <i class="inputFieldIcon fas fa-location-dot"></i>
                                            <input placeholder="Ej. Calle Principal #123, Ciudad"
                                                value="{{ isset($AlbergueEdit) ? old('direccion', $AlbergueEdit->direccion) : old('direccion') }}"
                                                class="inputField" name="direccion">
                                            @error('direccion')
                                                <small style="color:red">{{ $message }}</small>
                                            @enderror
                                        </div>


                                        <div class="inputContainer">
                                            <label class="inputFieldLabel" for="dui">Miembro responsable</label>
                                            <i class="inputFieldIcon fas fa-user"></i>
                                            <select id="miembro" name="miembro" class="inputField">
                                                <option value=""
                                                    {{ old('miembro') == '' && !isset($AlbergueEdit) ? 'selected' : '' }}>
                                                    Seleccione...
                                                </option>
                                                @php use App\Models\Miembro; @endphp
                                                @foreach (Miembro::all() as $miembro)
                                                    @if ($miembro->estado == 1)
                                                        <option value="{{ $miembro->idMiembro }}"
                                                            {{ isset($AlbergueEdit) ? ($AlbergueEdit->miembro->idMiembro == $miembro->idMiembro ? 'selected' : '') : (old('nombre') == $miembro->idMiembro ? 'selected' : '') }}>
                                                            {{ $miembro->nombres }} {{ $miembro->apellidos }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('miembro')
                                                <small style="color:red">{{ $message }}</small>
                                            @enderror
                                        </div>

                                    </div>
                                    <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                        <button type="submit" class="button button-pri">
                                            <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                            <span class="lable">
                                                @if (isset($AlbergueEdit))
                                                    Modificar
                                                @else
                                                    Guardar
                                                @endif
                                            </span>
                                        </button>
                                        <button onclick="{{ url('albergue') }}" type="button" id="btnCancelar"
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
    @include('albergue.modalesAlbergue')
@endsection
