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
                        alt="user" class="picture " id="imagenModal"
                        style="width: 35%; height: auto; margin-left: auto; margin-right: auto;"> </p>
                <p>Código: <span id="modalRecordCodigo"></span></p>
                <p>Nombre: <span id="modalRecordNombre"></span></p>
                <p>Especie: <span id="modalRecordEspecie"></span></p>
                <p>Raza: <span id="modalRecordRaza"></span></p>
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


<!-- Modal para los registros dados de baja -->
<div class="modal fade" id="tabla" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="margin-left: auto; margin-right: auto;">Lista de miembros de baja</h5>
            </div>
            <div class="modal-body">
                <!-- Aquí puedes agregar tu tabla -->
                <table id="table">
                    <thead>
                        <tr class="head">
                            <th></th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Especie</th>
                            <th>Raza</th>
                            <th>Edad</th>
                            <th>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">

                        @php
                            use App\Http\Controllers\AnimalControlador;
                            use App\Models\Animal;
                            $animalesBaja = Animal::where('estado', 0)->get();
                        @endphp

                        @foreach ($animalesBaja as $a)
                            @if ($e->estado == 0)
                                <tr>
                                    <td>
                                        <img src="{{ isset($a->imagen) ? asset($a->imagen) : asset('img/especie.png') }}"
                                            alt="user" class="picture" />
                                    </td>
                                    <td>{{ $a->idAnimal }}</td>
                                    <td>{{ $a->nombre }}</td>
                                    <td>{{ $a->raza->especie->especie }}</td>
                                    <td>{{ $a->raza->raza }}</td>
                                    <td>{{ AnimalControlador::calcularEdad(explode(' ', $a->fechaNacimiento)[0]) }}
                                    </td>
                                    <td>
                                        <div
                                            style="display: flex; align-items: flex-end; gap: 3px; justify-content: center">
                                            <a href="{{ url('animal/alta/' . $a->idAnimal) }}"
                                                class="button button-blue" style="width: 45%;" data-bs-pp="tooltip"
                                                data-bs-placement="top" title="Dar de alta">
                                                <i class="svg-icon fas fa-up-long"></i>
                                            </a>
                                            <button type="button" class="button button-primary ver-button"
                                                data-bs-pp="tooltip" data-bs-toggle="modal"
                                                data-bs-target="#ModalToggle" style="width: 45%"
                                                data-foto="{{ isset($a->imagen) ? asset($a->imagen) : asset('img/especie.png') }}"
                                                data-id="{{ $a->idAnimal }}" data-nombre="{{ $a->nombre }}"
                                                data-especie="{{ $a->raza->especie->especie }}"
                                                data-raza="{{ $a->raza->raza }}"
                                                data-fecha="{{ AnimalControlador::calcularEdad(explode(' ', $a->fechaNacimiento)[0]) }}"
                                                data-bs-placement="top" title="Ver detalles">
                                                <i class="svg-icon fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                            @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="pagination"></div>
            </div>
        </div>
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
