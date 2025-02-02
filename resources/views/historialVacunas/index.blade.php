<!-- Modal para agregar o modificar vacunas al historial de vacunas-->
<div class="modal fade" id="newHistorial" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header">
                <h3 style="margin-left: 33%">Nuevo Registro</h3>
                <button type="button" class="circle-button" style="margin-right: 4%" data-bs-dismiss="modal">
                    <i style="height: 30px;width: 45px;margin-right: 8%"
                        class="svg-icon fas fa-regular fa-circle-xmark"></i></button>
            </div>
            <form id="formulario">
                @csrf
                <div class="modal-body ">
                    <br>
                    <input type="hidden" name="operacion" id="operacion" value="agregar">
                    <input type="hidden" name="idAnimal" value="{{ $animal->idAnimal }}">
                    <input type="hidden" name="idExpediente" value="{{ $idExpediente }}">

                    <div class="inputContainer">
                        <select id="vacuna" name="vacuna" class="inputField">
                            <option value="" {{ old('vacuna') == '' ? 'selected' : '' }}>
                                Seleccione...
                            </option>
                        </select>
                        <label class="inputFieldLabel" for="vacuna">Vacuna*</label>
                        <i class="inputFieldIcon fas fa-syringe"></i>
                        <small id="vacuna-error" style="color: red;"></small>
                    </div>

                    <div class="inputContainer">
                        <input id="fechaAplicacion" name="fechaAplicacion" value="{{ old('fechaAplicacion') }}"
                            max="{{ date('Y-m-d') }}" class="inputField" autocomplete="false" type="date">
                        <label class="inputFieldLabel" for="fechaAplicacion">Fecha de aplicación*</label>
                        <i class="inputFieldIcon fas fa-calendar"></i>
                        <small id="fechaAplicacion-error" style="color: red;"></small>
                    </div>

                    <div class="inputContainer">
                        <input id="dosis" name="dosis" class="inputField" placeholder="Cantidad" type="number"
                            value="{{ old('dosis') }}" autocomplete="off">
                        <label class="inputFieldLabel" for="dosis">Dosis*</label>
                        <i class="inputFieldIcon fas fa-vial-circle-check"></i>
                        <small id="dosis-error" style="color: red;"></small>
                    </div>

                    <p style="margin-top: -25px;">(*)Campos Obligatorios</p>
                </div>

                <div class="modal-footer " id="btnGuardar" style="justify-content: center;">
                    <button type="button" class="button button-pri">
                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                        <span class="lable" id="btn">
                            Guardar
                        </span>
                    </button>
                    <button type="reset" id="btnCancelar" class="button button-red" data-bs-dismiss="modal">
                        <i class="svg-icon fas fa-rotate-right"></i>
                        <span class="lable">Cancelar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detalleVacunaModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header text center">
                <h5 style="margin-left: auto; margin-right: auto;"> Detalles de <span id="name"></span></h5>

            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-end mb-2">

                    <input id="searchInput" class="inputField card" style="width: 50%; margin-right: 8px; "
                        autocomplete="off" placeholder="🔍︎ Buscar" type="search">

                    <button type="submit" id="actualizacionVacuna" class="button button-pri" id="abrir"
                        data-bs-toggle="modal" data-bs-target="#newActualizacionVacuna" data-bs-pp="tooltip"
                        data-bs-placement="top" title="Nueva vacuna"
                        style="width: 30px;padding: 7px 3px">
                        <i class="svg-icon fas fa-plus"></i>
                    </button>
                </div>
                <table>
                    <thead>
                        <tr class="head">
                            <th>No.</th>
                            <th>Dosis (ml)</th>
                            <th>Fecha de Aplicación</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="detalleVacunaTableBody">
                        <!-- Aquí se insertarán las filas de la tabla -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newActualizacionVacuna" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header">
                <h3 style="margin-left: 28%">Nueva actualización</h3>
                <button type="button" class="circle-button" style="margin-right: 4%" data-bs-dismiss="modal">
                    <i style="height: 30px;width: 45px;margin-right: 8%"
                        class="svg-icon fas fa-regular fa-circle-xmark"></i></button>
            </div>
            <form id="formularioActualizacionV">
                @csrf
                <div class="modal-body ">
                    <br>
                    <input type="hidden" id="Vacuna" name="Vacuna" value="">
                    <input type="hidden" name="idExpediente" value="{{ $idExpediente }}">

                    <div class="inputContainer">
                        <input id="fechaA" name="fechaA" value="{{ old('fechaA') }}" max="{{ date('Y-m-d') }}"
                            class="inputField" autocomplete="false" type="date">
                        <label class="inputFieldLabel" for="fechaA">Fecha de aplicación*</label>
                        <i class="inputFieldIcon fas fa-calendar"></i>
                        <small id="fechaA-error" style="color: red;"></small>
                    </div>

                    <div class="inputContainer">
                        <input id="number" name="number" class="inputField" placeholder="Cantidad"
                            type="number" value="{{ old('dosis') }}" autocomplete="off">
                        <label class="inputFieldLabel" for="number">Dosis*</label>
                        <i class="inputFieldIcon fas fa-vial-circle-check"></i>
                        <small id="number-error" style="color: red;"></small>
                    </div>

                    <p style="margin-top: -25px;">(*)Campos Obligatorios</p>
                </div>

                <div class="modal-footer " id="btnGuardarActualizacionV" style="justify-content: center;">
                    <button type="button" class="button button-pri">
                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                        <span class="lable">
                            Guardar
                        </span>
                    </button>
                    <button type="reset" id="btnCancelarActualizacionV" class="button button-red"
                        data-bs-dismiss="modal">
                        <i class="svg-icon fas fa-rotate-right"></i>
                        <span class="lable">Cancelar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
