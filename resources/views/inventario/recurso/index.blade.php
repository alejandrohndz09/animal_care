@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
    <style>
        /* Estilo del panel de menú */
        .menu-panel {
            width: 100%;
            padding: 10px 25px;
            border-radius: 5px;
            color: #6067eb;
        }

        /* Estilo del enlace del panel de menú */
        .menu-link {
            text-decoration: none;
            /* Quitar subrayado del enlace */
            color: inherit;
            /* Heredar color del texto */
        }

        /* Estilo del título y del icono */
        .menu-title {
            display: flex;
            align-items: center;
        }

        .menu-panel:hover {
            background-color: #f0f0f0;
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        .menu-icon {
            font-size: 14px;
            margin-right: 10px;
        }

        /* Estilo de la línea divisoria interna */
        .menu-divider {
            border: 1px solid #ddd;
            margin: 0;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('js/validaciones/JsRecurso.js') }}"></script>
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
                                                Recursos dados de baja</a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <table>
                            <thead>
                                <tr class="head">
                                    <th style="width: 8%"></th>
                                    <th>Código</th>
                                    <th style="width:40%">Descripción</th>
                                    <th style="width: 25%">Categoría</th>
                                    <th style="width: 20%">Unidad de medida</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody id="tableBody">

                                @foreach ($Recursos as $item)
                                 @if ($item->estado == 1) 
                                    <tr class="recurso-row" data-recurso="{{$item}}" data-categoria="{{$item->categoria}}">
                                        <td style="width: 8%">
                                            <img src="{{ asset('img/recurso.png') }}" alt="recurso item" class="picture" />
                                        </td>
                                        <td>{{ $item->idRecurso }}</td>
                                        <td style="width: 40%">{{ $item->recurso }} </td>
                                        <td style="width: 20%">{{ $item->categoria->categoria }}</td>
                                        <td style="width: 15%">{{ $item->unidadmedida->unidadMedida }}</td>

                                        <td>
                                            <div
                                                style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                                <a
                                                    href="{{ url('inventario/recursos/' . $item->idRecurso . '/edit') }}" type="button"
                                                    class="button button-blue btnUpdate" data-id="{{ $item->idRecurso }}"
                                                    data-bs-pp="tooltip" data-bs-placement="top"
                                                    title="Editar">
                                                    <i class="svg-icon fas fa-pencil"></i>
                                                </a>

                                                <button type="button" id="btnDelete" class="button button-red btnDelete"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModalToggle"
                                                    data-recurso="{{ $item }}" data-bs-pp="tooltip"
                                                    data-bs-placement="top" title="Eliminar">
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
                        <h3 style="padding: 0px !important;">
                            Más opciones</h3>
                        <div class="card  px-0 py-0 mb-4" style="border:none; margin:0;  gap:0 !important; width: 100%">
                            <a href="/inventario/categorias" class="menu-link">
                                <div class="menu-panel ">
                                    <div class="menu-title">
                                        <div class="menu-icon">
                                            <i class="fas fa-tags" style="margin-right: 3px;"></i>
                                        </div>
                                        <span>Gestionar Categorías</span>
                                    </div>
                                </div>
                            </a>
                            <hr class="menu-divider">
                            <a href="/inventario/unidadMedidas" class="menu-link">
                                <div class="menu-panel ">

                                    <div class="menu-title">
                                        <div class="menu-icon">
                                            <i class="fas fa-ruler" style="margin-right: 3px;"></i>
                                        </div>
                                        <span>Gestionar Unidades de Medida</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                            <h3 style="padding: -5px 0px !important;">
                                {{ isset($RecursoEdit) ? 'Editar Registro' : 'Nuevo Registro' }}</h3>
                            <form
                                action="{{ isset($RecursoEdit) ? url('inventario/recursos/update/' . $RecursoEdit->idRecurso) : '' }}"
                                id="miFormulario" name="form" method="POST">
                                @csrf
                                @if (isset($RecursoEdit))
                                    @method('PUT') <!-- Utilizar el método PUT para la actualización -->
                                @endif

                                <div class="row">
                                    <div class="col-xl-12">

                                        <div class="inputContainer">
                                            <label class="inputFieldLabel" autocomplete="off"
                                                for="recurso">Descripción*</label>
                                            <i class="inputFieldIcon fas fa-pencil"></i>
                                            <input placeholder="Ej. Croquetas para perro." autocomplete="off"
                                                value="{{ isset($RecursoEdit) ? old('recurso', $RecursoEdit->recurso) : old('recurso') }}"
                                                class="inputField" name="recurso">
                                            @error('recurso')
                                                <small style="color:red">{{ $message }}</small>
                                            @enderror
                                        </div>


                                        <div class="inputContainer">
                                            <label class="inputFieldLabel" for="">Categoría*</label>
                                            <i class="inputFieldIcon fas fa-tag"></i>
                                            <select id="categoria" name="categoria" class="inputField">
                                                <option value=""
                                                    {{ old('categoria') == '' && !isset($RecursoEdit) ? 'selected' : '' }}>
                                                    Seleccione...
                                                </option>
                                                @php use App\Models\Categoria; @endphp
                                                @foreach (Categoria::all() as $categoria)
                                                    <option value="{{ $categoria->idCategoria }}"
                                                        {{ isset($RecursoEdit) ? ($RecursoEdit->categoria->idCategoria == $categoria->idCategoria ? 'selected' : '') : (old('categoria') == $categoria->idCategoria ? 'selected' : '') }}>
                                                        {{ $categoria->categoria }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('categoria')
                                                <small style="color:red">{{ $message }}</small>
                                            @enderror
                                        </div>


                                        <div class="inputContainer">
                                            <select id="unidad" name="unidad"
                                                data-selected="{{ isset($RecursoEdit) ? $RecursoEdit->unidadmedida->idUnidadMedida : old('unidad') }}"
                                                class="inputField">
                                                <option value="">Seleccione...</option>

                                            </select>
                                            <label class="inputFieldLabel" for="unidad">Unidad de Medida*</label>
                                            <i class="inputFieldIcon fas fa-ruler"></i>
                                            @error('unidad')
                                                <span style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <p style="margin-top: -25px;">(*)Campos Obligatorios</p>
                                    </div>
                                    <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                        <button type="submit" class="button button-pri">
                                            <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                            <span class="lable">
                                                @if (isset($RecursoEdit))
                                                    Modificar
                                                @else
                                                    Guardar
                                                @endif
                                            </span>
                                        </button>
                                        <button onclick="{{ url('inventario/recursos') }}" type="button"
                                            id="btnCancelar" class="button button-red">
                                            <i class="svg-icon fas fa-rotate-right"></i>
                                            <span class="lable">Cancelar</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- Botón de ayuda -->
    <div class="floating-button" data-toggle="modal" data-target="#ayudaRecursos" data-bs-pp="tooltip" data-bs-placement="top" title="Ayuda">
        <span>?</span>
    </div>
    @include('inventario.recurso.modalesRecurso')
@endsection
