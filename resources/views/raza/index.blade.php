@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ url('https://cdn.jsdelivr.net/npm/sweetalert2@10.3.5/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/validaciones/jsRaza.js') }}"></script>
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
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div class="row mt-3">
                    <div class="col-xl-7">
                        <div
                            style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h1>Razas </h1>
                            <input id="searchInput" class="inputField card" style="width: 50% " autocomplete="off"
                                placeholder="🔍︎ Buscar" type="search">
                        </div>
                        <table>
                            <thead>
                                <tr class="head">
                                    <th></th>
                                    <th>Código</th>
                                    <th>Nombre de la raza</th>
                                    <th>Especie perteneciente</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($razas as $a)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('img/huella.png') }}" alt="Raza" class="picture" />
                                        </td>
                                        <td>{{ $a->idRaza }}</td>
                                        <td>{{ $a->raza }}</td>
                                        <td>{{ $a->especie->especie }}</td>
                                        <td>
                                            <div
                                                style="display: flex; align-items: flex-end; gap: 3px; justify-content: center">
                                                <a href="{{ url('raza/' . $a->idRaza . '/edit') }}"
                                                    class="button button-blue" style="width: 45%;" data-bs-pp="tooltip"
                                                    data-bs-placement="top" title="Editar">
                                                    <i class="svg-icon fas fa-pencil"></i>
                                                </a>
                                                <button type="button" class="button button-red" style="width: 45%"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModalToggle"
                                                    data-raza="{{ json_encode($a) }}" data-bs-pp="tooltip"
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
                                {{ isset($raza) ? 'Editar Registro' : 'Nuevo Registro' }}</h3>
                            <form action="{{ isset($raza) ? url('raza/update/' . $raza->idRaza) : '' }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @if (isset($raza))
                                    @method('PUT')
                                @endif

                                <div class="inputContainer">
                                    <input id="raza" name="raza" class="inputField" placeholder="Ingrese acá"
                                        type="text" value="{{ isset($raza) ? old('raza', $raza->raza) : old('raza') }}"
                                        autocomplete="off">
                                    <label class="inputFieldLabel" for="raza">Nombre de la raza*</label>
                                    <i class="inputFieldIcon fas fa-pen"></i>
                                    @error('raza')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="inputContainer">
                                    <select id="especie" name="especie" class="inputField">
                                        <option value=""
                                            {{ old('especie') == '' && isset($raza) == null ? 'selected' : '' }}>
                                            Seleccione...
                                        </option>
                                        @php use App\Models\Especie; @endphp
                                        @foreach (Especie::all() as $e)
                                            <option value="{{ $e->idEspecie }}"
                                                {{ isset($raza) ? ($raza->idEspecie == $e->idEspecie ? 'selected' : '') : (old('especie') == $e->idEspecie ? 'selected' : '') }}>
                                                {{ $e->especie }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <label class="inputFieldLabel" for="especie">Especie*</label>
                                    <i class="inputFieldIcon fas fa-dog"></i>
                                    @error('especie')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <p style="margin-top: -25px;">(*)Campos Obligatorios</p>

                                <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                    <button type="submit" class="button button-pri">
                                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                        <span class="lable">
                                            @if (isset($raza))
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
        @include('raza.modalesRaza')
    </div>
@endsection
