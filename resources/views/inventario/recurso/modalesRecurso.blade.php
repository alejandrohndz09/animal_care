<!-- Modal para los registros dados de baja-->
{{-- <div class="modal fade" id="tabla" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="margin-left: auto; margin-right: auto;">Lista de albergues de baja</h5>
            </div>
            <div class="modal-body">
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
                            @if ($item->estado == 0)
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
                                            <button
                                                onclick="window.location.href = '{{ url('albergue/alta/' . $item->idAlvergue) }}';"
                                                type="button" class="button button-blue btnUpdate"
                                                data-id="{{ $item->idAlvergue }}" style="width: 45%"
                                                data-bs-pp="tooltip" data-bs-placement="top" title="Dar de alta">
                                                <i class="svg-icon fas fa-up-long"></i>
                                            </button>

                                            <button type="button" class="button button-red btnDelete"
                                                style="width: 45%" data-bs-toggle="modal" data-bs-target="#modalDetalle"
                                                data-id="{{ $item->idAlvergue }}"
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
            </div>
        </div>
    </div>
</div> --}}

<!-- Modal para dar de baja un elemento de la lista-->
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
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
                    <span class="lable">Dar de baja</span></button>
                <button type="button" class="button button-red" data-bs-dismiss="modal"> <i
                        class="svg-icon fas fa-xmark"></i>
                    <span class="lable">Cancelar</span> </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles de elementos de la lista-->
<div class="modal fade" id="modalDetalle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: auto; margin-right: auto;">¿Desea dar de baja este registro?</h5>
            </div>
            <div class="modal-body text-center">
                <!-- Utiliza la clase text-center para centrar los elementos -->
                <p> <img src="{{ asset('img/recurso.png') }}" alt="user" class="picture"
                        style="width: 35%; height: auto; margin-left: auto; margin-right: auto;"> </p>
                <p>Código: <span id="CodigoD"></span></p>
                <p>Descripcion: <span id="NombreD"></span></p>
                <p>Categoría: <span id="CategoriaC"></span>
            </div>
        </div>
    </div>
</div>
