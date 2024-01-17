<!-- Modal para dar de baja un elemento de la lista-->
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: auto; margin-right: auto;">¿Desea eliminar este registro?</h5>
            </div>
            <div class="modal-body text-center">
                <!-- Utiliza la clase text-center para centrar los elementos -->
                <p><img src="{{asset('img/categoria.png')}}"
                        alt="user" class="picture " id="imagenModal"
                        style="width: 15%; height: auto; margin-left: auto; margin-right: auto;"> </p>
                <p>Código: <span id="modalRecordCodigo"></span></p>
                <p>Nombre: <span id="modalRecordNombre"></span></p>                
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
<div class="modal fade" id="modalDetalle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: 35%">Detalles de categoría</h5>
                <button type="button" class="circle-button" style="margin-right: 4%" data-bs-dismiss="modal">
                    <i style="height: 30px;width: 45px;margin-right: 8%"
                        class="svg-icon fas fa-regular fa-circle-xmark"></i></button>
            </div>
            <div class="modal-body text-center">
                <!-- Utiliza la clase text-center para centrar los elementos -->
                <p><img src="{{asset('img/categoria.png')}}"
                    alt="user" class="picture " id="imagenModal"
                    style="width: 15%; height: auto; margin-left: auto; margin-right: auto;"> </p>
            <p>Código: <span id="Codigo"></span></p>
            <p>Nombre: <span id="Raza"></span></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal de ayuda -->
<div class="modal fade" id="ayudaCategoria" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h3 style="margin-left: auto; margin-right: auto;">Ayuda</h5>
            </div>
            <div class="modal-body text-center">
                <!-- Utiliza la clase text-center para centrar los elementos -->
               
                <p> °En categorias registramos las categorias de los recursos recibidos, en tipos de categorias podemos tomar en cuenta: utencilios de limpieza, frasads, comida, jugetes, e.c.t</p>
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