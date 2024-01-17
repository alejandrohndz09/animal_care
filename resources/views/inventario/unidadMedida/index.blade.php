@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/jsUnidadMedida.js') }}"></script>
@endsection
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div class="row mt-3">
                    <div class="col-xl-7">
                        <div
                            style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <div style=" width:100%;margin: 0; display: flex; gap: 5px; align-items: center; ">
                                <button class="button btn-transparent" style="width: 30px;padding: 15px 5px" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-bs-pp="tooltip" data-bs-placement="top" title="Volver"
                                    onclick="window.location.href='/inventario/recursos'">
                                    <i class="svg-icon fas fa-chevron-left" style="color: #4c4c4c"></i>
                                </button>
                                <h1>Unidades de Medida </h1>
                            </div>
                            <div
                                style=" width:100%;margin: 0; display: flex; gap: 5px; justify-content: end ;align-items: center; ">
                                <input id="searchInput" class="inputField card" style="width: 100%;" autocomplete="off"
                                    placeholder="🔍︎ Buscar" type="search">
                            </div>
                        </div>
                        <table>
                            <thead>
                                <tr class="head">
                                    <th style="width: 10%"></th>
                                    <th style="width: 15%">Código</th>
                                    <th style="width: 20%;">Nombre</th>
                                    <th style="width: 15%;">Símbolo</th>
                                    <th style="width: 20%;">Categoría</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($unidadMedidas as $a)
                                    <tr class="unidadMedida-row" data-unidadMedida="{{ json_encode($a) }}">
                                        <td style="width: 10%">
                                            <img src="{{ asset('img/unidadMedida.png') }}" alt="UnidadMedida" class="picture" />
                                        </td>
                                        <td style="width: 15%">{{ $a->idUnidadMedida }}</td>
                                        <td style="width: 20%">{{ $a->unidadMedida }}</td>
                                        <td style="width: 15%;">{{ $a->simbolo }}</td>
                                        <td style="width: 20%">{{ $a->categoria==null? 'Indistinto': $a->categoria->categoria}}</td>
                                        <td>
                                            <div
                                                style="display: flex; align-items: flex-end; gap: 3px; justify-content: center">
                                                <a href="{{ url('/inventario/unidadMedidas/' . $a->idUnidadMedida . '/edit') }}"
                                                    class="button button-blue btnUpdate" style="width: 45%;"
                                                    data-bs-pp="tooltip" data-bs-placement="top" title="Editar">
                                                    <i class="svg-icon fas fa-pencil"></i>
                                                </a>
                                                <button type="button" class="button button-red btnDelete"
                                                    style="width: 45%" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalToggle"
                                                    data-unidadMedida="{{ json_encode($a) }}" data-bs-pp="tooltip"
                                                    data-bs-placement="top" title="Eliminar">
                                                    <i class="svg-icon fas fa-trash"></i>
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="pagination"></div>
                    </div>
                    <div class="col-xl-5">
                        <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                            <h3 style="padding: -5px 0px !important;">
                                {{ isset($unidadMedida) ? 'Editar Registro' : 'Nuevo Registro' }}</h3>
                            <form
                                action="{{ isset($unidadMedida) ? url('/inventario/unidadMedidas/update/' . $unidadMedida->idUnidadMedida) : '' }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($unidadMedida))
                                    @method('PUT')
                                @endif

                                <div class="inputContainer">
                                    <input id="unidadMedida" name="unidadMedida" class="inputField" placeholder="Ej. Kilogramos, libras, unidades, etc..."
                                        type="text"
                                        value="{{ isset($unidadMedida) ? old('unidadMedida', $unidadMedida->unidadMedida) : old('unidadMedida') }}"
                                        autocomplete="off">
                                    <label class="inputFieldLabel" for="unidadMedida">Nombre de la unidad de medida*</label>
                                    <i class="inputFieldIcon fas fa-ruler"></i>
                                    @error('unidadMedida')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="inputContainer">
                                    <input id="unidadMedida" name="simbolo" class="inputField" placeholder="Ej. Kg, lb, uds, etc..."
                                        type="text"
                                        value="{{ isset($unidadMedida) ? old('simbolo', $unidadMedida->simbolo) : old('simbolo') }}"
                                        autocomplete="off">
                                    <label class="inputFieldLabel" for="simbolo">Simbolo*</label>
                                    <i class="inputFieldIcon fas fa-question"></i>
                                    @error('simbolo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="inputContainer">
                                    <select id="categoria" name="categoria" class="inputField">
                                        <option value=""
                                            {{ old('categoria') == '' && isset($unidadMedida) == null ? 'selected' : '' }}>
                                            Seleccione...
                                        </option>
                                        <option value="-1"
                                            {{ isset($unidadMedida) ? ($unidadMedida->categoria == null ? 'selected' : '') : (old('categoria') == -1 ? 'selected' : '') }}>
                                            Ninguna (Puede usarse en más de una categoría)
                                        </option>
                                        @php use App\Models\Categoria; @endphp
                                        @foreach (Categoria::all() as $e)
                                            <option value="{{ $e->idCategoria }}"
                                                {{ isset($unidadMedida) ? ($unidadMedida->idCategoria == $e->idCategoria ? 'selected' : '') : (old('categoria') == $e->idCategoria ? 'selected' : '') }}>
                                                {{ $e->categoria }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <label class="inputFieldLabel" for="categoria">Categoría*</label>
                                    <i class="inputFieldIcon fas fa-tag"></i>
                                    @error('categoria')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <p style="margin-top: -25px;">(*)Campos Obligatorios</p>

                                <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                    <button type="submit" class="button button-pri">
                                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                        <span class="lable">
                                            @if (isset($unidadMedida))
                                                Modificar
                                            @else
                                                Guardar
                                            @endif
                                        </span>
                                    </button>
                                    <button type="button" id="btnCancelar" class="button button-red">
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
        <div class="floating-button" data-toggle="modal" data-target="#ayudaUni" data-bs-pp="tooltip" data-bs-placement="top" title="Ayuda">
            <span>?</span>
        </div>
        @include('inventario.unidadMedida.modalesUnidadMedida')
    </div>
    
@endsection
