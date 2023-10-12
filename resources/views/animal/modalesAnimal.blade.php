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

<!-- Modal para los registros dados de baja-->
<div class="modal fade" id="tabla" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="margin-left: auto; margin-right: auto;">Lista de miembros de baja</h5>
            </div>
            <div class="modal-body">

                <table>
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
                        @php use App\Http\Controllers\AnimalControlador; @endphp
                        @foreach ($animales as $a)
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
                                        <a href="{{ url('animal/' . $a->idAnimal . '/edit') }}"
                                            class="button button-blue" style="width: 45%;" data-bs-pp="tooltip"
                                            data-bs-placement="top" title="Editar">
                                            <i class="svg-icon fas fa-pencil"></i>
                                        </a>
                                        <button type="button" class="button button-red" style="width: 45%"
                                            data-bs-toggle="modal" data-bs-target="#exampleModalToggle"
                                            data-animal="{{ json_encode($a) }}" data-bs-pp="tooltip"
                                            data-bs-placement="top" title="Dar de baja">
                                            <i class="svg-icon fas fa-trash"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal para ver detalles de los elementos de la lista-->
<div class="modal fade" id="ModalDetalle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: 35%">Detalles de Animal</h5>
                <button type="button" class="circle-button" style="margin-right: 4%" data-bs-dismiss="modal">
                    <i style="height: 30px;width: 45px;margin-right: 8%"
                        class="svg-icon fas fa-regular fa-circle-xmark"></i></button>
            </div>
            <div class="modal-body text-center">

                <p><img src="{{ isset($a->imagen) ? asset($a->imagen) : asset('img/especie.png') }}" alt="user"
                        class="picture " id="imagenModal"
                        style="width: 35%; height: auto; margin-left: auto; margin-right: auto;"> </p>
                <p>Código: <span id="modalCodigo"></span></p>
                <p>Nombre: <span id="modalNombre"></span></p>
                <p>Especie: <span id="modalEspecie"></span></p>
                <p>Raza: <span id="modalRaza"></span></p>

            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles de los elementos de la lista-->
<div class="modal fade" id="newHistorial" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: 35%">Detalles de miembro</h5>
                <button type="button" class="circle-button" style="margin-right: 4%" data-bs-dismiss="modal">
                    <i style="height: 30px;width: 45px;margin-right: 8%"
                        class="svg-icon fas fa-regular fa-circle-xmark"></i></button>
            </div>
            <div class="modal-body text-center">

                <p><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                        alt="user" class="picture " id="imagenModal"
                        style="width: 35%; height: auto; margin-left: auto; margin-right: auto;"> </p>
                <p>Código: <span id="modalCodigo"></span></p>
                <p>Nombre: <span id="modalNombre"></span></p>
                <p>Especie: <span id="modalEspecie"></span></p>
                <p>Raza: <span id="modalRaza"></span></p>

            </div>
        </div>
    </div>
</div>
