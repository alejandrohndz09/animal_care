
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

<!-- Modal de ayuda -->
<div class="modal fade" id="ayudaMovimiento" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h3 style="margin-left: auto; margin-right: auto;">Ayuda</h5>
            </div>
            <div class="modal-body text-center">
                <!-- Utiliza la clase text-center para centrar los elementos -->
               
                <p> °En la tabla estan los animales registrados, al seleccionar cualquiera de los registros nos envia al expediente de dicho registro y su control. </p>
                <img src="img/expe.png" alt="Descripción de la imagen" class="img-fluid">
                <p></p>
                <p>°Para poder subri la foto presionamos el icono de la fotografía.</p>
                <img src="img/camar.png" alt="Descripción de la imagen" class="img-fluid">
                <p></p>
                <p>°Para poder guardar un registro nuevo no deben haber campos vacios.</p>
                
                
            </div>
            <div class="modal-footer text-center" style="margin-left: auto; margin-right: auto;">

                <button type="button" class="button button-red" data-bs-dismiss="modal"> <i
                        class="svg-icon fas fa-xmark"></i>
                    <span class="lable">cerrar</span> </button>
            </div>
        </div>
    </div>
</div>