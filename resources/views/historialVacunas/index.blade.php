@section('scripts')
    <script src="{{ asset('js/validaciones/jsHistorialV.js') }}"></script>
@endsection
<!-- Modal para agregar o modificar vacunas al historial de vacunas-->
<div class="modal fade" id="newHistorial" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 style="margin-left: 35%"> {{ isset($HistorialV) ? 'Editar Registro' : 'Nuevo Registro' }}</h5>

            </div>
            <form id="formulario">
                @csrf
                <div class="modal-body ">
                    <br>
                    <input type="hidden" name="idAnimal" value="{{ $animal->idAnimal }}">
                    <input type="hidden" name="idExpediente" value="{{ $idExpediente }}">
                    <div class="inputContainer">
                        <select id="vacuna" name="vacuna" class="inputField">
                            <option value=""
                                {{ old('vacuna') == '' && isset($historialV) == null ? 'selected' : '' }}>
                                Seleccione...
                            </option>
                            @php use App\Models\vacuna; @endphp
                            @foreach (Vacuna::all() as $v)
                                <option value="{{ $v->idVacuna }}"
                                    {{ isset($historialV) ? ($historialV->vacuna->idVacuna == $v->idVacuna ? 'selected' : '') : (old('vacuna') == $v->idVacuna ? 'selected' : '') }}>
                                    {{ $v->vacuna }}
                                </option>
                            @endforeach
                        </select>
                        <label class="inputFieldLabel" for="vacuna">Vacuna*</label>
                        <i class="inputFieldIcon fas fa-syringe"></i>
                        <small id="vacuna-error" style="color: red;"></small>
                    </div>

                    <div class="inputContainer">
                        <input id="fechaAplicacion" name="fechaAplicacion"
                            value="{{ isset($historialV) ? old('fechaAplicacion', explode(' ', $historialV->fechaAplicacion)[0]) : old('fechaAplicacion') }}"
                            max="{{ date('Y-m-d') }}" class="inputField" autocomplete="false" type="date">
                        <label class="inputFieldLabel" for="fechaAplicacion">Fecha de aplicación*</label>
                        <i class="inputFieldIcon fas fa-calendar"></i>
                        <small id="fechaAplicacion-error" style="color: red;"></small>
                    </div>

                    <div class="inputContainer">
                        <input id="dosis" name="dosis" class="inputField" placeholder="Cantidad" type="number"
                            value="{{ isset($historialV) ? old('dosis', $historialV->dosis) : old('dosis') }}"
                            autocomplete="off">
                        <label class="inputFieldLabel" for="dosis">Dosis*</label>
                        <i class="inputFieldIcon fas fa-vial-circle-check"></i>
                        <small id="dosis-error" style="color: red;"></small>
                    </div>
                </div>

                <div class="modal-footer " id="btnGuardar" style="justify-content: center;">
                    <button type="button" class="button button-pri">
                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                        <span class="lable">
                            {{ isset($historialV) ? 'Modificar' : 'Guardar' }}
                        </span>
                    </button>
                    <button type="button" id="btnCancelar" class="button button-red" data-bs-dismiss="modal">
                        <i class="svg-icon fas fa-rotate-right"></i>
                        <span class="lable">Cancelar</span>
                    </button>
                </div>
            </form>


        </div>
    </div>
</div>
