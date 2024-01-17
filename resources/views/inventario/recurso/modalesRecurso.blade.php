@if ($Recursos != null)
    <!-- Modal para los registros dados de baja-->
    <div class="modal fade" id="tabla" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="margin-left: auto; margin-right: auto;">Lista de albergues de baja</h5>
                </div>
                <div class="modal-body">
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
                        <tbody id="table">

                            @foreach ($Recursos as $item)
                                @if ($item->estado == 0)
                                    <tr class="recursoDetalles-row" data-recurso="{{ $item }}">
                                        <td style="width: 8%">
                                            <img src="{{ asset('img/recurso.png') }}" alt="recurso item"
                                                class="picture" />
                                        </td>
                                        <td>{{ $item->idRecurso }}</td>
                                        <td style="width: 40%">{{ $item->recurso }} </td>
                                        <td style="width: 20%">{{ $item->categoria->categoria }}</td>
                                        <td style="width: 15%">{{ $item->unidadmedida->unidadMedida }}</td>

                                        <td>
                                            <div
                                                style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                                <a href="{{ url('inventario/recursos/' . $item->idRecurso . '/edit') }}"
                                                    type="button" class="button button-blue btnUpdate"
                                                    data-id="{{ $item->idRecurso }}" data-bs-pp="tooltip"
                                                    data-bs-placement="top" title="Editar">
                                                    <i class="svg-icon fas fa-up-long"></i>
                                                </a>

                                                <button type="button" id="btnDelete"
                                                    class="button button-red btnDelete" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalToggle"
                                                    data-recurso="{{ $item }}" data-bs-pp="tooltip"
                                                    data-bs-placement="top" title="Eliminar">
                                                    <i class="svg-icon fas fa-trash-can"></i>
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif


<!-- Modal para dar de baja un elemento de la lista-->
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: auto; margin-right: auto;">¿Desea dar de baja este registro?</h5>
            </div>
            <div class="modal-body text-center">
                <!-- Utiliza la clase text-center para centrar los elementos -->
                <p> <img src="{{ asset('img/recurso.png') }}" alt="user" class="picture"
                        style="width: 35%; height: auto; margin-left: auto; margin-right: auto;"> </p>
                <p>Código: <span id="Codigo"></span></p>
                <p>Descripcion: <span id="Nombre"></span></p>
                <p>Categoría: <span id="Categoria"></span>

            </div>
            <div class="modal-footer text-center" style="margin-left: auto; margin-right: auto;">
                <button id="confirmar" type="submit" class="button button-pri" style="margin-right: 40px">
                    <i class="svg-icon fas fa-check"></i>
                    <span class="lable">Eliminar</span></button>
                <button type="button" class="button button-red" data-bs-dismiss="modal"> <i
                        class="svg-icon fas fa-xmark"></i>
                    <span class="lable">Cancelar</span> </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles de elementos de la lista-->
<div class="modal fade" id="MovimientoRecurso" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: auto; margin-right: auto;">Detalles del registro</h5>
            </div>
            <div class="modal-body text-center">
                <!-- Utiliza la clase text-center para centrar los elementos -->
                <p> <img src="{{ asset('img/recurso.png') }}" alt="user" class="picture"
                        style="width: 35%; height: auto; margin-left: auto; margin-right: auto;"> </p>
                <p>Fecha de movimiento: <span id="FechaMovimiento"></span></p>
                <p>Tipo de movimiento: <span id="tipoMovimiento"></span></p>
                <p>Valor: <span id="valor"></span>
                <p>Donado: <span id="Donante"></span></p>
                <p>Descripcion: <span id="Descripcion"></span>
                <p>Registrado por: <span id="miembro"></span>
            </div>
        </div>
    </div>
</div>
