<div class="modal fade" id="asignarUsuario" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <form action="/usuario" method="post">
                @csrf
                <div class="modal-header">
                    <h5 style="margin-left: auto; margin-right: auto;">Asignar nuevo usuario</h5>
                </div>
                <input type="hidden" name="miembro" value="{{$miembro->idMiembro}}">
                <div class="modal-body text-center">
                    <div
                        style="margin: 0; display: flex;flex-direction: column; align-items: center; justify-content: center ">

                        <div class="inputContainer mt-4 mb-2">
                            <select id="rol" name="rol" class="inputField">
                                <option value="2">Usuario</option>
                                <option value="1">Administrador</option>
                            </select>
                            <label class="inputFieldLabel" for="raza">¿Qué rol cumplirá dentro del sistema?</label>
                            <i class="inputFieldIcon fas fa-user"></i>
                       
                        </div>
                        <div
                        style="margin: 0; display: flex; align-items: center;width:auto; color:#867596; font-size: 14px ">
                        <i class="fas fa-circle-info" style="margin-right: 3px;"></i>
                        Se enviarán las credenciales de acceso al correo del miembro indicado.
                    </div>
                    </div>

                </div>
                <div class="modal-footer" style="display:flex; justify-content: center; gap:40px">
                    <button id="confirmar" type="submit" class="button button-pri">
                        <i class="svg-icon fas fa-check"></i>
                        <span class="lable">Confirmar</span></button>
                    <button type="button" class="button button-red" data-bs-dismiss="modal"> <i
                            class="svg-icon fas fa-xmark"></i>
                        <span class="lable">Cancelar</span> </button>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
