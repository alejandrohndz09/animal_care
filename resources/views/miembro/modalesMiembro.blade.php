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
                <p>Miembro: <span id="modalRecordNombre"></span> <span id="modalRecordApellido"></span>
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

<!-- Modal para dar de baja un elemento de la lista-->
<div class="modal fade" id="miembroBajas" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: auto; margin-right: auto;">Miembros de baja</h5>
            </div>
            <div class="modal-body text-center">
                <table>
                    <thead>
                        <tr class="head">
                            <th style="width: 10%"></th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Correo</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody id="tableBody">

                        @foreach ($datos as $item)
                            @if ($item->estado == 0)
                                <tr class="miembro-row">
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
                                                onclick="window.location.href = '{{ url('miembro/Alta/' . $item->idMiembro) }}';"
                                                type="button" class="button button-blue btnUpdate" style="width: 45%"
                                                data-bs-pp="tooltip" data-bs-placement="top" title="Dar de alta">
                                                <i class="svg-icon fas fa-up-long"></i>
                                            </button>


                                            <button type="button" class="button button-red btnDelete"
                                                data-bs-pp="tooltip" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalToggle" style="width: 45%"
                                                data-id="{{ $item->idMiembro }}" data-nombre="{{ $item->nombres }}"
                                                data-apellido="{{ $item->apellidos }}" data-dui="{{ $item->dui }}"
                                                data-correo="{{ $item->correo }}" data-bs-placement="top"
                                                title="Eliminar">
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
        </div>
    </div>

    <!-- Modal de confirmacion de eliminar telefono -->
    <div class="modal fade" id="modalTelefono" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 style="margin-left: auto; margin-right: auto;">Aviso</h5>
                </div>
                <div class="modal-body text-center">
                    <button type="button" class="circle-button-warning" style="margin-right: 4%"
                        data-bs-dismiss="modal">
                        <i style="height: 50px;width: 45px;margin-right: 8%"
                            class="svg-icon fas fa-warning"></i></button>
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
                        <i style="height: 30px;width: 45px;margin-right: 8%"
                            class="svg-icon fas fa-check"></i></button>
                </div>
                <p>Registro eliminado de la BD exitosamente!</p>
                <br>
                <br>
            </div>
        </div>
    </div>


    <!-- Modal para ver detalles de elementos de la lista-->
    <div class="modal fade" id="ModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 style="margin-left: 35%">Detalles de miembro</h5>
                    <button type="button" class="circle-button" style="margin-right: 4%" data-bs-dismiss="modal">
                        <i style="height: 30px;width: 45px;margin-right: 8%"
                            class="svg-icon fas fa-regular fa-circle-xmark"></i></button>
                </div>
                <div class="modal-body text-center">
                    <!-- Utiliza la clase text-center para centrar los elementos -->
                    <p><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                            alt="user" class="picture "
                            style="width: 15%; height: auto; margin-left: auto; margin-right: auto;"> </p>
                    <p>DUI: <span id="modalDui"></span></p>
                    <p>Miembro: <span id="modalNombres"></span> <span id="modalApellidos"></span></p>
                    <p>Correo: <span id="modalCorreo"></span></p>
                    <p>Telefono: <span id="telefonos"></span></p>


                </div>
                {{-- <div class="modal-footer text-center" style="margin-left: auto; margin-right: auto;">
                            <button id="confirmar" type="submit" class="button button-pri" style="margin-right: 40px">
                                <i class="svg-icon fas fa-check"></i>
                                <span class="lable">Dar de baja</span></button>
                            <button type="button" class="button button-red" data-bs-dismiss="modal"> <i
                                    class="svg-icon fas fa-xmark"></i>
                                <span class="lable">Cancelar</span> </button>
                        </div> --}}
            </div>
        </div>
    </div>
