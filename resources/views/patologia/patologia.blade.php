@extends('layouts.master'){{-- llama a la carcasa master --}}



@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">{{-- estilo --}}
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/jsPatologias.js') }}"></script>{{-- validacion para eliminar --}}
@endsection

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div class="row mt-3">
                    <div class="col-xl-7">
                        <div
                            style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h1>Patologías </h1>
                            <input id="searchInput" class="inputField card" style="width: 50% " autocomplete="off"
                                placeholder="🔍︎ Buscar" type="search">
                        </div>
                        <table>
                            <thead>
                                <tr class="head">
                                    <th></th>
                                    <th>Código</th>
                                    <th style="width: 40%">Nombre de patología</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">

                                @foreach ($patologia as $p)
                                    <tr class="patologia-row" data-patologia="{{ json_encode($p) }}">
                                        <td>
                                            <img src="{{ asset('img/patologia.png') }}" alt="user" class="picture" />
                                        </td>
                                        <td>{{ $p->idPatologia }}</td>
                                        <td style="width: 40%">{{ $p->patologia }}</td>
                                        <td>
                                            <div
                                                style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                                <a id="btnmodificar"
                                                    href="{{ url('patologia/' . $p->idPatologia . '/edit') }}"
                                                    type="button" class="button button-blue btnUpdate"
                                                    data-id="{{ $p->idPatologia }}" style="width: 45%" data-bs-pp="tooltip"
                                                    data-bs-placement="top" title="Editar">
                                                    <i class="svg-icon fas fa-pencil"></i>
                                                </a>
                                                <button type="button" class="button button-red btnDelete"
                                                    style="width: 45%" data-bs-toggle="modal"
                                                    data-bs-target="#modalEliminar" data-patologia="{{ json_encode($p) }}"
                                                    data-bs-pp="tooltip" data-bs-placement="top" title="Eliminar">
                                                    <i class="svg-icon fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="pagination">

                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                            <h3 style="padding: -5px 0px !important;">
                                {{ isset($patologiaEdit) ? 'Editar Registro' : 'Nuevo Registro' }}</h3>
                            <form
                                action="{{ isset($patologiaEdit) ? url('patologia/update/' . $patologiaEdit->idPatologia) : '' }}"
                                id="miFormulario" name="form" method="POST">
                                @csrf
                                @if (isset($patologiaEdit))
                                    @method('PUT') <!-- Utilizar el método PUT para la actualización -->
                                @endif

                                <div class="inputContainer">
                                    <label class="inputFieldLabel" autocomplete="off" for="patologia">Nombre de
                                        patología*</label>
                                    <i class="inputFieldIcon fas fa-syringe"></i>
                                    <input placeholder="Ej. Hepatitis, moquillo, herpes, etc."
                                        value="{{ isset($patologiaEdit) ? $patologiaEdit->patologia : old('patologia') }}"
                                        class="inputField" autocomplete="off" name="patologia">
                                    @error('patologia')
                                        <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>
                                <p style="margin-top: -25px;">(*)Campos Obligatorios</p>

                                <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                    <button type="submit" class="button button-pri">
                                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                        <span class="lable">
                                            @if (isset($patologiaEdit))
                                                Modificar
                                            @else
                                                Guardar
                                            @endif
                                        </span>
                                    </button>
                                    <button onclick="{{ url('patologia') }}" type="button" id="btnCancelar"
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
    <div class="floating-button" data-toggle="modal" data-target="#ayudaPato" data-bs-pp="tooltip" data-bs-placement="top" title="Ayuda">
        <span>?</span>
    </div>
    @include('patologia.modalesPatologia')
@endsection
