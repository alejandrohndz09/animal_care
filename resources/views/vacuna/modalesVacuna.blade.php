<!-- Modal de confirmacion de eliminar telefono -->
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
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
                <p>¿Realmente desea eliminar esta vacuna de la lista ?</p>
            </div>
            <p>Vacuna: <span id="modalRecordeVacuna" style=""></span></p>
            <br>
            <div class="modal-footer text-center" style="margin-left: auto; margin-right: auto;">

                <button id="confirmar" data-dismiss="modal" type="submit" class="button button-pri"
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