<!-- Modal para agregar o modificar vacunas al historial de vacunas-->
<div class="modal fade" id="newHistorial" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: 35%"> {{ isset($HistorialV) ? 'Editar Registro' : 'Nuevo Registro' }}</h5>
                <button type="button" class="circle-button" style="margin-right: 4%" data-bs-dismiss="modal">
                    <i style="height: 30px;width: 45px;margin-right: 8%"
                        class="svg-icon fas fa-regular fa-circle-xmark"></i></button>
            </div>
            <form
                action="{{ isset($historialV) ? url('historialV/update/' . $historialV->idHistVacuna) : url('animal/' . $animal->idAnimal . '/historialVacuna') }}"
                enctype="multipart/form-data" method="POST">
                @csrf
                @if (isset($historialV))
                    @method('PUT')
                @endif
                <div class="modal-body text-center">
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
                                    {{ isset($historialV) ? ($historialV->vacuna->vacuna == $v->idVacuna ? 'selected' : '') : (old('vacuna') == $v->idVacuna ? 'selected' : '') }}>
                                    {{ $v->vacuna }}
                                </option>
                            @endforeach
                        </select>

                        <label class="inputFieldLabel" for="vacuna">Vacuna*</label>
                        <i class="inputFieldIcon fas fa-syringe"></i>
                        @error('vacuna')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="inputContainer">
                        <input id="fechaAplicacion" name="fechaAplicacion"
                            value="{{ isset($historialV) ? old('fecha', explode(' ', $historialV->fechaAplicacion)[0]) : old('fechaAplicacion') }}"
                            max="{{ date('Y-m-d') }}" class="inputField" autocomplete="false" type="date">
                        <label class="inputFieldLabel" for="fechaAplicacion">Fecha de aplicación*</label>
                        <i class="inputFieldIcon fas fa-calendar"></i>
                        @error('fechaAplicacion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="inputContainer">
                        <input id="dosis" name="dosis" class="inputField" placeholder="Cantidad" type="number"
                            value="{{ isset($historialV) ? old('dosis', $historialV->dosis) : old('dosis') }}"
                            autocomplete="off">
                        <label class="inputFieldLabel" for="dosis">Dosis*</label>
                        <i class="inputFieldIcon fas fa-vial-circle-check"></i>
                        @error('nombre')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer " style="justify-content: center;">
                    <button type="submit" class="button button-pri">
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
