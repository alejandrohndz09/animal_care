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
    <script src="{{ asset('js/validaciones/JsMovimiento.js') }}"></script>
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
                                <h1>Movimientos </h1>
                            </div>
                            <div
                                style=" width:100%;margin: 0; display: flex; gap: 5px; justify-content: end ;align-items: center; ">
                                <input id="searchInput" class="inputField card" style="width: 50%;" autocomplete="off"
                                    placeholder="🔍︎ Buscar" type="search">
                            </div>
                        </div>
                        <table>
                            <thead>
                                <tr class="head">
                                    <th style="width: 8%"></th>
                                    <th style="width:20%">Fecha</th>
                                    <th style="width: 15%">Tipo</th>
                                    <th style="width: 20%">Recurso</th>
                                    <th style="width: 20%">Valor</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody id="tableBody">

                                @foreach ($Movimientos as $item)
                                 @if ($item->estado == 1) 
                                    <tr class="movimiento-row" data-movimiento="{{$item}}" data-recurso="{{$item->recurso}}">
                                        <td style="width: 8%">
                                            <img src="{{ asset('img/regurso.png') }}" alt="movimiento item" class="picture" />
                                        </td>
                                        <td>{{ $item->idMovimiento }}</td>
                                        <td style="width: 20%">{{ explode(' ',$item->fechaMovimiento)[0] }} </td>
                                        <td style="width: 15%">{{ $item->tipo }}</td>
                                        <td style="width: 20%">{{ $item->recurso->recurso }}</td>
                                        <td style="width: 20%">{{ $item->valor. ' ('.$item->recurso->unidadmedida->simbolo.')' }}</td>

                                        <td>
                                            <div
                                                style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                                <a
                                                    href="{{ url('inventario/movimientos/' . $item->idMovimiento . '/edit') }}" type="button"
                                                    class="button button-blue btnUpdate" data-id="{{ $item->idMovimiento }}"
                                                    data-bs-pp="tooltip" data-bs-placement="top"
                                                    title="Editar">
                                                    <i class="svg-icon fas fa-pencil"></i>
                                                </a>

                                                <button type="button" id="btnDelete" class="button button-red btnDelete"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModalToggle"
                                                    data-movimiento="{{ $item }}" data-bs-pp="tooltip"
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
                            <a href="/inventario/recursos" class="menu-link">
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
                                {{ isset($MovimientoEdit) ? 'Editar Registro' : 'Nuevo Registro' }}</h3>
                            <form
                                action="{{ isset($MovimientoEdit) ? url('inventario/movimientos/update/' . $MovimientoEdit->idMovimiento) : '' }}"
                                id="miFormulario" name="form" method="POST">
                                @csrf
                                @if (isset($MovimientoEdit))
                                    @method('PUT') <!-- Utilizar el método PUT para la actualización -->
                                @endif

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="inputContainer">
                                            <input id="fecha" name="fecha"
                                                value="{{ isset($MovimientoEdit) ? old('fecha', explode(' ', $MovimientoEdit->fechaMovimiento)[0]) : old('fecha') }}"
                                                max="{{ date('Y-m-d') }}" class="inputField" autocomplete="false"
                                                placeholder="Fecha de movimiento" type="date">
                                            <label class="inputFieldLabel" for="fecha">Fecha de operación*</label>
                                            <i class="inputFieldIcon fas fa-calendar"></i>
                                            @error('fecha')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="inputContainer">
                                            <label class="inputFieldLabel" autocomplete="off"
                                                for="movimiento">Concepto*</label>
                                            <i class="inputFieldIcon fas fa-pencil"></i>
                                            <input placeholder="Ej. alimentación del mes de abril." autocomplete="off"
                                                value="{{ isset($MovimientoEdit) ? old('concepto', $MovimientoEdit->descripcion) : old('concepto') }}"
                                                class="inputField" name="concepto">
                                            @error('concepto')
                                                <small style="color:red">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="inputContainer">
                                            <select id="tipoMovimiento" name="tipoMovimiento" class="inputField">
                                                <option value=""
                                                {{ old('tipoMovimiento') == '' && !isset($MovimientoEdit) ? 'selected' : '' }}>
                                                    Seleccione...</option>
                                                <option value="Ingreso"
                                                    @if (isset($MovimientoEdit)) 
                                                     @if ($MovimientoEdit->tipoMovimiento == 'Ingreso')
                                                        selected
                                                     @endif 
                                                    @else 
                                                        @if (old('tipoMovimiento') == 'Ingreso') selected 
                                                        @endif 
                                                    @endif>
                                                    Ingreso</option>
                                                    <option value="Salida"
                                                    @if (isset($MovimientoEdit)) 
                                                     @if ($MovimientoEdit->tipoMovimiento == 'Salida')
                                                        selected
                                                     @endif 
                                                    @else 
                                                        @if (old('tipoMovimiento') == 'Salida') selected 
                                                        @endif 
                                                    @endif>
                                                    Salida</option>                                               
                                            </select>
                                            <label class="inputFieldLabel" for="raza">Tipo de movimiento*</label>
                                            <i class="inputFieldIcon fas fa-house"></i>
                                            @error('tipoMovimiento')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="inputContainer">
                                            <label class="inputFieldLabel" for="">Recurso*</label>
                                            <i class="inputFieldIcon fas fa-tag"></i>
                                            <select id="recurso" name="recurso" class="inputField">
                                                <option value=""
                                                    {{ old('recurso') == '' && !isset($MovimientoEdit) ? 'selected' : '' }}>
                                                    Seleccione...
                                                </option>
                                                @php use App\Models\Recurso; @endphp
                                                @foreach (Recurso::all() as $recurso)
                                                    <option value="{{ $recurso->idRecurso }}"
                                                        {{ isset($MovimientoEdit) ? ($MovimientoEdit->recurso->idRecurso == $recurso->idRecurso ? 'selected' : '') : (old('recurso') == $recurso->idRecurso ? 'selected' : '') }}>
                                                        {{ $recurso->recurso }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('recurso')
                                                <small style="color:red">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="inputContainer">
                                            <label class="inputFieldLabel" autocomplete="off"
                                                for="valor">Valor*</label>
                                            <i class="inputFieldIcon fas fa-pencil"></i>
                                            <input autocomplete="off"
                                                value="{{ isset($MovimientoEdit) ? old('valor', $MovimientoEdit->valor) : old('valor','1') }}"
                                                class="inputField" type="number" min="1" step="1" value="1" name="valor">
                                            @error('valor')
                                                <small style="color:red">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        
                                        <p style="margin-top: -25px;">(*)Campos Obligatorios</p>
                                    </div>
                                    <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                        <button type="submit" class="button button-pri">
                                            <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                            <span class="lable">
                                                @if (isset($MovimientoEdit))
                                                    Modificar
                                                @else
                                                    Guardar
                                                @endif
                                            </span>
                                        </button>
                                        <button onclick="{{ url('inventario/movimientos') }}" type="button"
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
    <div class="floating-button"data-bs-pp="tooltip" data-bs-placement="top" title="Ayuda">
        <span>?</span>
    </div>
    @include('inventario.movimiento.modalesMovimiento')
@endsection
