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
                <p>Donante: <span id="modalRecordNombre"></span> <span id="modalRecordApellido"></span>
                </p>
                <p>DUI: <span id="modalRecordCorreo"></span></p>
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
                <h5 class="modal-title" style="margin-left: auto; margin-right: auto;">Lista de miembros de baja</h5>
            </div>
            <div class="modal-body">
                <!-- Aquí puedes agregar tu tabla -->
                <table id="table">
                    <thead>
                        <tr class="head">
                            <th style="width: 10%"></th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>dui</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody id="tableBody">

                        @foreach ($donantes as $item)
                            @if ($item->estado == 0)
                                <tr class="donante-row" data-donante="{{ json_encode($item) }}">
                                    <td style="width: 10%">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                            alt="user" class="picture" />
                                    </td>
                                    <td>{{ $item->nombres }}</td>
                                    <td>{{ $item->apellidos }}</td>
                                    <td>{{ $item->dui }} </td>
                                    <td>
                                        <div
                                            style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                            <button
                                                onclick="window.location.href = '{{ url('/donantes/Alta/' . $item->idDonante) }}';"
                                                type="button" class="button button-blue btnUpdate" style="width: 45%"
                                                data-id="{{ $item->idMiembro }}" data-bs-pp="tooltip"
                                                data-bs-placement="top" title="Dar de alta">
                                                <i class="svg-icon fas fa-up-long"></i>
                                            </button>

                                            <button type="button" class="button button-red btnDelete ver-button"
                                                data-bs-pp="tooltip" style="width: 45%"
                                                data-donante="{{ json_encode($item) }}" data-bs-placement="top"
                                                onclick="window.location.href = '{{ url('/destroyDonante/'. $item->idDonante) }}'"
                                                title="Eliminar">
                                                <i class="svg-icon fas fa-trash-can"></i>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmacion de eliminar telefono -->
<div class="modal fade" id="modalDonante" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
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
                <p>Donante: <span id="modalNombre"></span> <span id="modalApellido"></span>
                </p>
                <p>Dui: <span id="modalCorreo"></span></p>
            </div>
            <div class="modal-footer text-center" style="margin-left: auto; margin-right: auto;">

                <button id="Eliminar" type="submit" class="button button-pri" style="margin-right: 40px">
                    <i class="svg-icon fas fa-check"></i>
                    <span class="lable">Eliminar</span></button>
                <button type="button" class="button button-red" data-bs-dismiss="modal"> <i
                        class="svg-icon fas fa-xmark"></i>
                    <span class="lable">Cancelar</span> </button>
            </div>
        </div>
    </div>
</div>
{{-- 
<!-- Modal de eliminacion exitosa-->
<div class="modal fade" id="Eliminacion" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: auto; margin-right: auto;">Aviso</h5>
            </div>
            <div class="modal-body text-center">
                <button type="button" class="circle-button-accept" style="margin-right: 4%"
                    data-bs-dismiss="modal">
                    <i style="height: 30px;width: 45px;margin-right: 8%" class="svg-icon fas fa-check"></i></button>
            </div>
            <p>Registro eliminado de la BD exitosamente!</p>
            <br>
            <br>
        </div>
    </div>
</div>
--}}

<!-- Modal para ver detalles de los elementos de la lista-->
<div class="modal fade" id="ModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: 35%">Detalles de donante</h5>
                <button type="button" class="circle-button" style="margin-right: 4%" data-bs-dismiss="modal">
                    <i style="height: 30px;width: 45px;margin-right: 8%"
                        class="svg-icon fas fa-regular fa-circle-xmark"></i></button>
            </div>
            <div class="modal-body text-center">
                <!-- Utiliza la clase text-center para centrar los elementos -->
                <p><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                        alt="user" class="picture "
                        style="width: 15%; height: auto; margin-left: auto; margin-right: auto;"> </p>
                <p>DUI: <span id="Dui"></span></p>
                <p>Donante: <span id="Nombres"></span> <span id="Apellidos"></span></p>
                <p>Telefono: <span id="telefonos"></span></p>

            </div>
        </div>
    </div>
</div>


                <!-- Modal para ver ayuda en Animal-->


<div class="modal fade" id="ayudaD" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h3 style="margin-left: auto; margin-right: auto;">Ayuda</h5>
            </div>
            <div class="modal-body text-center">

                <p> °Aca se registran los donantes sus datos basicos y requeridos. </p>
                <p></p>
                <p>°Para tenes un mayor control se solicita su Dui. </p>
                <p></p>
                <p>°No deben de haber ningun campo vacio para tener un registro con exito.</p>
                

            </div>
            <div class="modal-footer text-center" style="margin-left: auto; margin-right: auto;">

                <button type="button" class="button button-red" data-bs-dismiss="modal"> <i
                        class="svg-icon fas fa-xmark"></i>
                    <span class="lable">cerrar</span> </button>
            </div>
        </div>
    </div>
</div>