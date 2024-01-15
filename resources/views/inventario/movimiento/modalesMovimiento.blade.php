
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
                <h5 style="margin-left: auto; margin-right: auto;">Detalles del registro</h5>
            </div>
            <div class="modal-body text-center">
                <!-- Utiliza la clase text-center para centrar los elementos -->
                <p> <img src="{{ asset('img/recurso.png') }}" alt="user" class="picture"
                        style="width: 35%; height: auto; margin-left: auto; margin-right: auto;"> </p>
                <p>Código: <span id="CodigoD"></span></p>
                <p>Descripcion: <span id="NombreD"></span></p>
                <p>Categoría: <span id="CategoriaD"></span>
            </div>
        </div>
    </div>
</div>
