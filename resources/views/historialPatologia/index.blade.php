@section('scripts')
    <script src="{{ asset('js/validaciones/jsHistorialP.js') }}"></script>
@endsection
<!-- Modal para agregar o modificar vacunas al historial de vacunas-->
<div class="modal fade" id="newHistorialPatologia" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header">
                <h3 style="margin-left: 33%" id="Texto">Nuevo Registro</h3>
                <button type="button" class="circle-button" style="margin-right: 4%" data-bs-dismiss="modal">
                    <i style="height: 30px;width: 45px;margin-right: 8%"
                        class="svg-icon fas fa-regular fa-circle-xmark"></i></button>
            </div>
            <form id="formularioP">
                @csrf
                <div class="modal-body ">
                    <br>
                    <input type="hidden" name="operacionPatologia" id="operacionPatologia" value="Agregar">
                    <input type="hidden" id="idHistPatologia" name="idHistPatologia" value="">
                    <input type="hidden" id="idAnimal" name="idAnimal" value="{{ $animal->idAnimal }}">
                    <input type="hidden" name="idExpediente" id="idExpediente" value="{{ $idExpediente }}">

                    <div class="inputContainer">
                        <select id="idPatologia" name="idPatologia" class="inputField">
                            <option value="" {{ old('idPatologia') == '' ? 'selected' : '' }}>
                            </option>
                        </select>
                        <label class="inputFieldLabel" for="idPatologia">Tipo de patología*</label>
                        <i class="inputFieldIcon fas fa-file-medical"></i>
                        <small id="idPatologia-error" style="color: red;"></small>
                    </div>

                    <div class="inputContainer">
                        <textarea id="detalles" name="detalles" class="inputField"
                            placeholder="Ej. Dolor de alguna parte de cuerpo, fracturas en extremidades, etc." rows="2" cols="50">{{ old('detalles') }}</textarea>
                        <label class="inputFieldLabel" for="detalles">Detalles*</label>
                        <i class="inputFieldIcon fas fa-comment-medical"></i>
                        <small id="detalles-error" style="color: red;"></small>
                    </div>

                    <div class="inputContainer">
                        <input id="fechaDiagnostico" name="fechaDiagnostico" value="{{ old('fechaDiagnostico') }}"
                            max="{{ date('Y-m-d') }}" class="inputField" autocomplete="false" type="date">
                        <label class="inputFieldLabel" for="fechaDiagnostico">Fecha de diagnostico*</label>
                        <i class="inputFieldIcon fas fa-calendar"></i>
                        <small id="fechaDiagnostico-error" style="color: red;"></small>
                    </div>

                    <div class="inputContainer">
                        <select id="estado" name="estado" class="inputField">
                            <option value="" {{ old('estado') == '' ? 'selected' : '' }}>
                                Seleccione...
                            </option>
                            <option value="De alta" {{ old('estado') == 'De alta' ? 'selected' : '' }}>
                                De alta
                            </option>
                            <option value="En espera de tratamiento"
                                {{ old('estado') == 'En espera de tratamiento' ? 'selected' : '' }}>
                                En espera de tratamiento
                            </option>
                            <option value="En tratamiento" {{ old('estado') == 'En tratamiento' ? 'selected' : '' }}>
                                En tratamiento
                            </option>
                        </select>
                        <label class="inputFieldLabel" for="vacuna">Estado*</label>
                        <i class="inputFieldIcon fas fa-notes-medical"></i>
                        <small id="estado-error" style="color: red;"></small>
                    </div>

                    <p style="margin-top: -25px;">(*)Campos Obligatorios</p>
                </div>

                <div class="modal-footer " id="btnGuardarP" style="justify-content: center;">
                    <button type="button" class="button button-pri">
                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                        <span class="lable">
                            Guardar
                        </span>
                    </button>
                    <button type="reset" id="btnCancelarPatologia" class="button button-red" data-bs-dismiss="modal">
                        <i class="svg-icon fas fa-rotate-right"></i>
                        <span class="lable">Cancelar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para ver detalles de los elementos de la lista-->
<div class="modal fade" id="ModalDetallePatologia" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h4 style="margin-left: 43%"><span id="patologia"></span></h4>
                <button type="button" class="circle-button" style="margin-right: 4%" data-bs-dismiss="modal">
                    <i style="height: 30px;width: 45px;margin-right: 8%"
                        class="svg-icon fas fa-regular fa-circle-xmark"></i></button>
            </div>
            <div class="modal-body text-center">
                <div class="d-flex justify-content-end mb-2">

                    <input id="searchInput" class="inputField card" style="width: 50%; margin-right: 8px; "
                        autocomplete="off" placeholder="🔍︎ Buscar" type="search">

                    <button type="submit" id="mostrarPatologia" class="button button-pri" id="abrir"
                        data-bs-toggle="modal" data-bs-target="#newActualiacionPatologia"
                        style="width: 30px;padding: 7px 3px">
                        <i class="svg-icon fas fa-plus"></i>
                    </button>
                </div>
                <table>
                    <thead>
                        <tr class="head">
                            <th style="width: 5%">No.</th>
                            <th>Fecha de diagnostico</th>
                            <th style="width: 25%">Detalles</th>
                            <th style="width: 22%">Estado</th>
                            <th style="width: 5%"></th>
                        </tr>
                    </thead>
                    <tbody id="detallepatologiaTableBody">
                        <!-- Aquí se insertarán las filas de la tabla -->
                    </tbody>
                    <div id="pagination">
                    </div>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newActualiacionPatologia" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header">
                <h3 style="margin-left: 27%">Nueva actualización</h3>
                <button type="button" class="circle-button" style="margin-right: 4%" data-bs-dismiss="modal">
                    <i style="height: 30px;width: 45px;margin-right: 8%"
                        class="svg-icon fas fa-regular fa-circle-xmark"></i></button>
            </div>
            <form id="formularioActualizacion">
                @csrf
                <div class="modal-body ">
                    <br>
                    <input type="hidden" id="Patologium" name="Patologium" value="">
                    <input type="hidden" name="idExpediente" id="idExpediente" value="{{ $idExpediente }}">

                    <div class="inputContainer">
                        <textarea id="datalles" name="datalles" class="inputField"
                            placeholder="Ej. Dolor de alguna parte de cuerpo, fracturas en extremidades, etc." rows="2" cols="50">{{ old('detalles') }}</textarea>
                        <label class="inputFieldLabel" for="datalles">Detalles*</label>
                        <i class="inputFieldIcon fas fa-comment-medical"></i>
                        <small id="datalles-error" style="color: red;"></small>
                    </div>

                    <div class="inputContainer">
                        <input id="fecha" name="fecha" value="{{ old('fecha') }}"
                            max="{{ date('Y-m-d') }}" class="inputField" autocomplete="false" type="date">
                        <label class="inputFieldLabel" for="fechaDiagnostico">Fecha de diagnostico*</label>
                        <i class="inputFieldIcon fas fa-calendar"></i>
                        <small id="fecha-error" style="color: red;"></small>
                    </div>

                    <div class="inputContainer">
                        <select id="state" name="state" class="inputField">
                            <option value="" {{ old('state') == '' ? 'selected' : '' }}>
                                Seleccione...
                            </option>
                            <option value="De alta" {{ old('state') == 'De alta' ? 'selected' : '' }}>
                                De alta
                            </option>
                            <option value="En espera de tratamiento"
                                {{ old('state') == 'En espera de tratamiento' ? 'selected' : '' }}>
                                En espera de tratamiento
                            </option>
                            <option value="En tratamiento" {{ old('state') == 'En tratamiento' ? 'selected' : '' }}>
                                En tratamiento
                            </option>
                        </select>
                        <label class="inputFieldLabel" for="state">Estado*</label>
                        <i class="inputFieldIcon fas fa-notes-medical"></i>
                        <small id="state-error" style="color: red;"></small>
                    </div>

                    <p style="margin-top: -25px;">(*)Campos Obligatorios</p>
                </div>

                <div class="modal-footer " id="btnGuardarActualizacion" style="justify-content: center;">
                    <button type="button" class="button button-pri">
                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                        <span class="lable">
                            Guardar
                        </span>
                    </button>
                    <button type="button" id="btnCancelarActualizacion" class="button button-red" data-bs-dismiss="modal">
                        <i class="svg-icon fas fa-rotate-right"></i>
                        <span class="lable">Cancelar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>