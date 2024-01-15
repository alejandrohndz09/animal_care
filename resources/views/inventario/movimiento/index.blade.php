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
                                        <tr class="movimiento-row" data-movimiento="{{ $item }}"
                                            data-recurso="{{ $item->recurso }}">
                                            <td style="width: 8%">
                                                <img src="{{ asset('img/regurso.png') }}" alt="movimiento item"
                                                    class="picture" />
                                            </td>
                                            <td>{{ $item->idMovimiento }}</td>
                                            <td style="width: 20%">{{ explode(' ', $item->fechaMovimiento)[0] }} </td>
                                            <td style="width: 15%">{{ $item->tipo }}</td>
                                            <td style="width: 20%">{{ $item->recurso->recurso }}</td>
                                            <td style="width: 20%">
                                                {{ $item->valor . ' (' . $item->recurso->unidadmedida->simbolo . ')' }}</td>

                                            <td>
                                                <div
                                                    style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                                    <a href="{{ url('inventario/movimientos/' . $item->idMovimiento . '/edit') }}"
                                                        type="button" class="button button-blue btnUpdate"
                                                        data-id="{{ $item->idMovimiento }}" data-bs-pp="tooltip"
                                                        data-bs-placement="top" title="Editar">
                                                        <i class="svg-icon fas fa-pencil"></i>
                                                    </a>

                                                    <button type="button" id="btnDelete"
                                                        class="button button-red btnDelete" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalToggle"
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
                                        <div class="row">
                                            <div class="col-xl-6">
                                                @php
                                                    // Obtener la fecha actual
                                                    $fechaActual = new DateTime();

                                                    // Restar 7 días
                                                    $fechaResultado = $fechaActual->sub(new DateInterval('P15D'));

                                                @endphp
                                                <div class="inputContainer">
                                                    <input id="fecha" name="fecha"
                                                        value="{{ isset($MovimientoEdit) ? old('fecha', explode(' ', $MovimientoEdit->fechaMovimiento)[0]) : old('fecha') }}"
                                                        max="{{ date('Y-m-d') }}"
                                                        min="{{ $fechaResultado->format('Y-m-d') }}" class="inputField"
                                                        autocomplete="false" placeholder="Fecha de movimiento"
                                                        type="date">
                                                    <label class="inputFieldLabel" for="fecha">Fecha de
                                                        operación*</label>
                                                    <i class="inputFieldIcon fas fa-calendar"></i>
                                                    @error('fecha')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="inputContainer">
                                                    <select id="tipoMovimiento" name="tipoMovimiento" class="inputField">
                                                        <option value=""
                                                            {{ old('tipoMovimiento') == '' && !isset($MovimientoEdit) ? 'selected' : '' }}>
                                                            Seleccione...</option>
                                                        <option value="Ingreso"
                                                            @if (isset($MovimientoEdit)) @if ($MovimientoEdit->tipoMovimiento == 'Ingreso')
                                                        selected @endif
                                                        @else @if (old('tipoMovimiento') == 'Ingreso') selected @endif
                                                            @endif>
                                                            Ingreso</option>
                                                        <option value="Salida"
                                                            @if (isset($MovimientoEdit)) @if ($MovimientoEdit->tipoMovimiento == 'Salida')
                                                        selected @endif
                                                        @else @if (old('tipoMovimiento') == 'Salida') selected @endif
                                                            @endif>
                                                            Salida</option>
                                                    </select>
                                                    <label class="inputFieldLabel" for="raza">Tipo de
                                                        movimiento*</label>
                                                    <i class="inputFieldIcon fas fa-arrow-right-arrow-left"></i>
                                                    @error('tipoMovimiento')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <input name="donanteE" id="donanteE" class="inputField" type="hidden"
                                            value="{{ isset($MovimientoEdit) ? old('donanteE', $MovimientoEdit->idDonante) : (isset($donanteElejido) ? old('donanteE', $donanteElejido->idDonante) : old('donanteE')) }}">
                                        <div id="donante-container" class="row">
                                            @if ((isset($MovimientoEdit) && $MovimientoEdit->tipoMovimiento == 'Ingreso') || old('tipoMovimiento') == 'Ingreso')
                                                <div class="col-xl-5">
                                                    <div class="inputContainer">
                                                        <label class="inputFieldLabel">¿Es de una
                                                            donación?*</label>
                                                        <i class="inputFieldIcon fas fa-question"></i>
                                                        <div style="padding: 3px 15px">
                                                            @if (!isset($MovimientoEdit) && !isset($donanteElegido))
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="isDonado" id="inlineRadio1" value="Sí"
                                                                        {{ old('isDonado') == 'Sí' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="Sí">Sí</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="isDonado" id="inlineRadio2" value="No"
                                                                        {{ old('isDonado') == 'No' ? 'checked' : (old('isDonado') == '' ? 'checked' : '') }}>
                                                                    <label class="form-check-label"
                                                                        for="No">No</label>
                                                                </div>
                                                            @elseif (isset($MovimientoEdit))
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="isDonado" id="inlineRadio1" value="Sí"
                                                                        {{ $MovimientoEdit->idDonante != null ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="Sí">Sí</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="isDonado" id="inlineRadio2" value="No"
                                                                        {{ $MovimientoEdit->idDonante != null ? '' : 'checked' }}>
                                                                    <label class="form-check-label"
                                                                        for="No">No</label>
                                                                </div>
                                                            @else
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="isDonado" id="inlineRadio1" value="Sí"
                                                                        {{ $donanteElegido->idDonante != null ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="Sí">Sí</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="isDonado" id="inlineRadio2" value="No"
                                                                        {{ $donanteElegido->idDonante != null ? '' : 'checked' }}>
                                                                    <label class="form-check-label"
                                                                        for="No">No</label>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @error('isDonado')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-xl-7">
                                                    <div class="d-flex  align-items-center">
                                                        @if (!isset($MovimientoEdit) && !isset($donanteElegido))
                                                            <button type="button" id="btnDonante"
                                                                class="button button-pri" data-bs-toggle="modal"
                                                                data-bs-target="#buscarDonante"
                                                                style="width: 100%;padding: 7px 7px; justify-items: end;
                                                                @if (old('isDonado') == '' || old('isDonado') == 'No') visibility: hidden; @endif">
                                                                <i
                                                                    class="svg-icon fas fa-{{ old('nombreDonante') == '' ? 'search' : 'user' }}"></i>
                                                                <span
                                                                    class="lable">{{ old('nombreDonante', 'Seleccionar donante') }}</span>
                                                            </button>

                                                            <input placeholder="Seleccione" type="hidden"
                                                                value="{{ old('nombreDonante') }}" class="inputField"
                                                                name="nombreDonante">
                                                        @elseif (isset($MovimientoEdit))
                                                            @if ($MovimientoEdit->idDonante == null)
                                                                <button type="button" id="btnDonante"
                                                                    class="button button-pri" data-bs-toggle="modal"
                                                                    data-bs-target="#buscarDonante"
                                                                    style="width: 100%;padding: 7px 7px; justify-items: end; visibility: hidden;">
                                                                    <i class="svg-icon fas fa-search"></i>
                                                                    <span class="lable">Seleccionar donante</span>
                                                                </button>
                                                                <input placeholder="Seleccione" type="hidden"
                                                                    value="" class="inputField"
                                                                    name="nombreDonante">
                                                            @else
                                                                @php $nombre=$MovimientoEdit->donante->nombres.' '.$MovimientoEdit->donante->apellidos;@endphp
                                                                <button type="button" id="btnDonante"
                                                                    class="button button-pri" data-bs-toggle="modal"
                                                                    data-bs-target="#buscarDonante"
                                                                    style="width: 100%;padding: 7px 7px; justify-items: end;
                                                                    @if (old('isDonado') == '' || old('isDonado') == 'No') visibility: hidden; @endif">
                                                                    <i
                                                                        class="svg-icon fas fa-{{ old('nombreDonante') == '' ? 'search' : 'user' }}"></i>
                                                                    <span
                                                                        class="lable">{{ old('nombreDonante', $nombre) }}</span>
                                                                </button>

                                                                <input placeholder="Seleccione" type="hidden"
                                                                    value="{{ old('nombreDonante', $nombre) }}"
                                                                    class="inputField" name="nombreDonante">
                                                            @endif
                                                        @else
                                                            @php $nombre=$donanteElegido->nombres.' '.$donanteElegido->apellidos;@endphp
                                                            <button type="button" id="btnDonante"
                                                                class="button button-sec" data-bs-toggle="modal"
                                                                data-bs-target="#buscarDonante"
                                                                style="width: 100%;padding: 7px 7px; justify-items: end;
                                                                @if (old('isDonado') == '' || old('isDonado') == 'No') visibility: hidden; @endif">
                                                                <i
                                                                    class="svg-icon fas fa-{{ old('nombreDonante', $nombre) == '' ? 'search' : 'user' }}"></i>
                                                                <span
                                                                    class="lable">{{ old('nombreDonante', 'Buscar donante') }}</span>
                                                            </button>
                                                            <input type="hidden"
                                                                value="{{ old('nombreDonante', $nombre) }}"
                                                                class="inputField" name="nombreDonante">
                                                        @endif

                                                        @error('donanteE')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-7">
                                                <div class="inputContainer">
                                                    <label class="inputFieldLabel" for="">Recurso*</label>
                                                    <i class="inputFieldIcon fas fa-coins"></i>
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
                                            </div>
                                            <div class="col-xl-5">
                                                <div class="inputContainer">
                                                    <label class="inputFieldLabel" id="valorlabel" autocomplete="off"
                                                        for="valor"
                                                        style="color: #{{ isset($MovimientoEdit) ? '6067eb' : (old('valor') == '' ? '878787' : '6067eb') }}">
                                                        Valor*</label>
                                                    <i class="inputFieldIcon fas fa-cash-register" id="icValor"
                                                        style="color: #{{ isset($MovimientoEdit) ? '6067eb' : (old('valor') == '' ? '878787' : '6067eb') }}"></i>
                                                    <input autocomplete="off"
                                                        value="{{ isset($MovimientoEdit) ? old('valor', $MovimientoEdit->valor) : old('valor', '1') }}"
                                                        {{ isset($MovimientoEdit) ? '' : (old('valor') == '' ? 'disabled' : '') }}
                                                        class="inputField" type="number" min="1" step="1"
                                                        value="1" name="valor">
                                                    @error('valor')
                                                        <small style="color:red">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="inputContainer">
                                            <label class="inputFieldLabel" autocomplete="off"
                                                for="movimiento">Concepto*</label>
                                            <i class="inputFieldIcon fas fa-pencil"></i>
                                            <textarea id="particularidad" name="concepto" class="inputField" placeholder="Ej. Gasto en 'x' asunto del mes 'y'."
                                                rows="2" cols="50">{{ isset($MovimientoEdit) ? old('concepto', $MovimientoEdit->descripcion) : old('concepto') }}</textarea>
                                            @error('concepto')
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
