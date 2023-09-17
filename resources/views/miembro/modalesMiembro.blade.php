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

<!-- Modal para confirmar eliminar un elemento de la lista de telefono-->
{{-- <div class="modal fade" id="ModalTelefono" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: auto; margin-right: auto;">¿Desea eliminar este registro?</h5>
            </div>
            <div class="modal-body text-center">
                <!-- Utiliza la clase text-center para centrar los elementos -->
                <p> <button type="button" class="circle-button" style="margin-right: 4%" data-bs-dismiss="modal">
                        <i style="height: 30px;width: 45px;margin-right: 8%"
                            class="svg-icon fas fa-regular fa-circle-xmark"> </p>
                <p>Miembro: <span id="modalRecordNombre"></span> <span id="modalRecordApellido"></span>
                </p>
                <p>Correo: <span id="modalRecordCorreo"></span></p>
            </div>
            <div class="modal-footer text-center" style="margin-left: auto; margin-right: auto;">

                <button id="confirmar" type="submit" class="button button-pri" style="margin-right: 40px">
                    <i class="svg-icon fas fa-check"></i>
                    <span class="lable">Aceptar</span></button>
                <button type="button" class="button button-red" data-bs-dismiss="modal"> <i
                        class="svg-icon fas fa-xmark"></i>
                    <span class="lable">Cancelar</span> </button>
            </div>
        </div>
    </div>
</div> --}}

<!-- Modal de eliminacion exitosa-->
<div class="modal fade" id="modalEliminacion" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
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


<!-- Modal para ver detalles de elementos de la lista-->
<div class="modal fade" id="ModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
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
