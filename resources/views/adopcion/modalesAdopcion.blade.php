<!-- Modal para dar de baja un elemento de la lista-->
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: auto; margin-right: auto;">¿Desea dar de baja este registro?</h5>
            </div>
            <div class="modal-body text-center">
                <!-- Utiliza la clase text-center para centrar los elementos -->
                <p><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                        alt="user" class="picture "
                        style="width: 15%; height: auto; margin-left: auto; margin-right: auto;"> </p>
                <p>Expediente: <span id="modalRecordNombre"></span> <span id="modalRecordApellido"></span>
                </p>
                <p>Correo: <span id="modalRecordCorreo"></span></p>
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

<!-- Modal para los registros dados de baja-->
<div class="modal fade" id="tabla" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="margin-left: auto; margin-right: auto;">Lista de expedientes de baja</h5>
            </div>
            <div class="modal-body">
                <!-- Aquí puedes agregar tu tabla -->
                <table id="tablaBaja">
                    <thead>
                        <tr class="head">
                            <th style="width: 10%"></th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Correo</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>

                        {{-- @foreach ($expedientes as $item)
                            @if ($item->estado == 0)
                                <tr>
                                    <td style="width: 10%">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                            alt="user" class="picture" />
                                    </td>
                                    <td>{{ $item->nombres }}</td>
                                    <td>{{ $item->apellidos }}</td>
                                    <td>{{ $item->correo }} </td>
                                    <td>
                                        <div
                                            style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                            <button
                                                onclick="window.location.href = '{{ url('expediente/Alta/' . $item->idExpediente) }}';"
                                                type="button" class="button button-blue btnUpdate" style="width: 45%"
                                                data-id="{{ $item->idExpediente }}" data-bs-pp="tooltip"
                                                data-bs-placement="top" title="Dar de alta">
                                                <i class="svg-icon fas fa-up-long"></i>
                                            </button>

                                            <button type="button" class="button button-primary btnDelete ver-button"
                                                data-bs-pp="tooltip" data-bs-toggle="modal"
                                                data-bs-target="#ModalToggle" style="width: 45%"
                                                data-id="{{ $item->idExpediente }}" data-nombre="{{ $item->nombres }}"
                                                data-apellido="{{ $item->apellidos }}" data-dui="{{ $item->dui }}"
                                                data-correo="{{ $item->correo }}" data-bs-placement="top"
                                                title="Ver detalles">
                                                <i class="svg-icon fas fa-eye"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach --}}
                    </tbody>
                </table>
                <div id="pagination">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <!-- Puedes agregar botones adicionales si es necesario -->
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmacion de eliminar telefono -->
<div class="modal fade" id="modalTelefono" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: auto; margin-right: auto;">Aviso</h5>
            </div>
            <div class="modal-body text-center">
                <button type="button" class="circle-button-warning" style="margin-right: 4%" data-bs-dismiss="modal">
                    <i style="height: 50px;width: 45px;margin-right: 8%" class="svg-icon fas fa-warning"></i></button>
            </div>
            <div class="modal-body text-center">
                <p>¿Realmente desea eliminar el telefono de la lista ?</p>
            </div>
            <p><span id="telefono"></span></p>
            <br>
            <div class="modal-footer text-center" style="margin-left: auto; margin-right: auto;">

                <button id="confirmarCell" data-dismiss="modal" type="submit" class="button button-pri"
                    style="margin-right: 40px">
                    <i class="svg-icon fas fa-check"></i>
                    <span class="lable">Aceptar</span></button>
                <button type="button" class="button button-red" data-bs-dismiss="modal"> <i
                        class="svg-icon fas fa-xmark"></i>
                    <span class="lable">Cancelar</span> </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de eliminacion exitosa-->
<div class="modal fade" id="Eliminacion" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: auto; margin-right: auto;">Aviso</h5>
            </div>
            <div class="modal-body text-center">
                <button type="button" class="circle-button-accept" style="margin-right: 4%" data-bs-dismiss="modal">
                    <i style="height: 30px;width: 45px;margin-right: 8%" class="svg-icon fas fa-check"></i></button>
            </div>
            <p>Registro eliminado de la BD exitosamente!</p>
            <br>
            <br>
        </div>
    </div>
</div>


<!-- Modal para ver detalles de los expedientes disponibles-->
<div class="modal fade" id="buscarExpediente" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg ">
        <div class="modal-content"  style="min-height: 80vh !important">
            <div class="modal-header">
                <h3 class="modal-title" style="">Seleccione un expediente:</h3>
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
                <div class="d-flex justify-content-end mb-2">
                    
                    <input id="searchInputGrid" class="inputField card" style="width: 50%; margin-right: 8px; " autocomplete="off"
                        placeholder="🔍︎ Buscar" type="search">
                </div>

                <!-- Aquí puedes agregar tu tabla -->
                <div id="grid" class="d-flex justify-content-center">
                    <div class="row col-xl-12">
                    </div>
                </div>
                <div id="paginationGrid">

                </div>
            </div>

        </div>
    </div>
</div>
