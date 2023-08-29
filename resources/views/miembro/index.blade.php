@extends('layouts.master')



@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('js/Jsmiembro.js') }}"></script>
@endsection
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div style="width: 100%; display: flex;align-items: center; justify-content: space-between; gap:20px">
                    <h1>Miembros</h1>
                    {{-- <button class="btn button-pri">
                        <i class="fas fa-plus"></i>
                        <span class="lable">Agregar nuevo registro</span>
                    </button> --}}

                    <div class="inputContainer" style="margin: auto; align-items: end">
                        <input id="searchInput" class="inputField card" style="width: 50%" autocomplete="off"
                            placeholder="🔍︎ Buscar" type="search">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-xl-7">
                        <table>
                            <thead>
                                <tr class="head">
                                    <th></th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Correo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">

                                @foreach ($datos as $item)
                                    <tr>
                                        <td>
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                                alt="user" class="picture" />
                                        </td>
                                        <td>{{ $item->nombres }}</td>
                                        <td>{{ $item->apellidos }}</td>
                                        <td>{{ $item->correo }} </td>
                                        <td>
                                            <div
                                                style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                                <button type="button" class="button button-blue">
                                                    <i class="svg-icon fas fa-pencil"></i>
                                                    <span class="lable"></span>
                                                </button>
                                                <button type="button" class="button button-red">
                                                    <i class="svg-icon fas fa-trash"></i>
                                                    <span class="lable"></span>
                                                </button>
                                                <button type="button" class="button button-sec">
                                                    <i class="svg-icon fas fa-ellipsis-vertical"></i>
                                                    <span class="lable"></span>
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
                            <h3 style="padding: -5px 0px !important;">Nuevo Registro</h3>
                            <form action="{{ route('miembros.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="inputContainer">
                                            <input required="required" name="nombres" class="inputField"
                                                placeholder="Nombres" type="text" autocomplete="off">
                                            <label class="inputFieldLabel" for="nombres">Nombres del miembro</label>
                                            <i class="inputFieldIcon fas fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="inputContainer">
                                            <input required="required" id="apellidos" name="apellidos"
                                                class="inputField" autocomplete="off" placeholder="Apellidos"
                                                type="text">
                                                
                                        </div>
                                    </div>
                                </div>

                                <div class="inputContainer">
                                    <input required="required" id="correo" class="inputField" name="correo"
                                        autocomplete="false" placeholder="Correo" type="email">
                                    <label class="inputFieldLabel" for="correo">Correo</label>
                                    <i class="inputFieldIcon fas fa-envelope"></i>
                                </div>

                                <div class="row" id="telefono-container">
                                    <div class="col-xl-7">
                                        <div class="inputContainer">
                                            <input class="inputField  telefono" type="tel"
                                                maxlength="18" value="+503 " name="telefonos"
                                                oninput="formatPhoneNumber(this)"
                                                onkeydown="return restrictToNumbersAndHyphen(event)">
                                            <label class="inputFieldLabel" for="telefono">Telefono</label>
                                            <i class="inputFieldIcon fas fa-phone"></i>
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <button type="button" class="button button-pri" id="add-telefono">
                                            <i class="svg-icon fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                    <a href="{{ route('miembros.index') }}">
                                        <button type="submit" class="button button-pri">
                                            <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                            <span class="lable">Guardar</span>
                                        </button>
                                    </a>
                                    <button type="reset" class="button button-red">
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
@endsection
