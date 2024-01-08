@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/jsCategoria.js') }}"></script>
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
                                <h1>Categorías </h1>
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
                                    <th style="width: 5%"></th>
                                    <th style="width: 15%">Código</th>
                                    <th style="width: 45%;">Nombre de la categoría</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($categorias as $a)
                                    <tr class="categoria-row" data-categoria="{{ json_encode($a) }}">
                                        <td style="width: 5%">
                                            <img src="{{ asset('img/categoria.png') }}" alt="Categoria" class="picture" />
                                        </td>
                                        <td style="width: 15%">{{ $a->idCategoria }}</td>
                                        <td style="width: 45%">{{ $a->categoria }}</td>
                                        <td>
                                            <div
                                                style="display: flex; align-items: flex-end; gap: 3px; justify-content: center">
                                                <a href="{{ url('/inventario/categorias/' . $a->idCategoria . '/edit') }}"
                                                    class="button button-blue btnUpdate" style="width: 45%;"
                                                    data-bs-pp="tooltip" data-bs-placement="top" title="Editar">
                                                    <i class="svg-icon fas fa-pencil"></i>
                                                </a>
                                                <button type="button" class="button button-red btnDelete"
                                                    style="width: 45%" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalToggle"
                                                    data-categoria="{{ json_encode($a) }}" data-bs-pp="tooltip"
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
                                {{ isset($categoria) ? 'Editar Registro' : 'Nuevo Registro' }}</h3>
                            <form
                                action="{{ isset($categoria) ? url('/inventario/categorias/update/' . $categoria->idCategoria) : '' }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($categoria))
                                    @method('PUT')
                                @endif

                                <div class="inputContainer">
                                    <input id="categoria" name="categoria" class="inputField" placeholder="Ingrese acá"
                                        type="text"
                                        value="{{ isset($categoria) ? old('categoria', $categoria->categoria) : old('categoria') }}"
                                        autocomplete="off">
                                    <label class="inputFieldLabel" for="categoria">Nombre de la categoria*</label>
                                    <i class="inputFieldIcon fas fa-pen"></i>
                                    @error('categoria')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <p style="margin-top: -25px;">(*)Campos Obligatorios</p>

                                <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                    <button type="submit" class="button button-pri">
                                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                        <span class="lable">
                                            @if (isset($categoria))
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
        @include('inventario.categoria.modalesCategoria')
    </div>
@endsection
