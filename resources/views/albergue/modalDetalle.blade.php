
<!--Modal para mostrar Animales sin ser albergados-->

<div class="modal fade" id="modalAlvergar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="margin-left: auto; margin-right: auto;">Lista de Animales no Albergados</h5>
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
                        @php use App\Http\Controllers\ExpedienteController; @endphp
                        @php use App\Models\Expediente; @endphp
                        @php $expedientesinAlbergar = Expediente::whereDoesntHave('alvergue')->get();@endphp
                        @foreach ($expedientesinAlbergar as $a)
                            <tr>
                                <td>
                                    <img src="{{ isset($a->animal->imagen) ? asset($a->animal->imagen) : asset('img/especie.png') }}"
                                        alt="user" class="picture" />
                                </td>
                                <td>{{ $a->animal->idAnimal }}</td>
                                <td>{{ $a->animal->nombre }}</td>
                                <td>{{ $a->animal->raza->especie->especie }}</td>
                                <td>{{ $a->animal->raza->raza }}</td>
                                <td>{{ AnimalControlador::calcularEdad(explode(' ', $a->animal->fechaNacimiento)[0]) }}
                                </td>
                                <td>
                                    <div
                                        style="display: flex; align-items: flex-end; gap: 3px; justify-content: center">
                                        <a href="{{url('/albergar',['idExpediente' => $a->idExpediente, 'idAlvergue' => $albergue->idAlvergue])}}"
                                            class="button button-blue" style="width: 45%;" data-bs-pp="tooltip"
                                            data-bs-placement="top" title="Albergar">
                                            <i class="svg-icon fas fa-house"></i>
                                        </a>
                                        

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

<!--Dar de baja a un animal del albergue-->
<div class="modal fade" id="modaldeBaja" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
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
                <p>Id Albergado: <span id="modalRecordid"></span></p>
                <p>Nombre: <span id="modalRecordAni"></span></p>
            </div>
            <div class="modal-footer text-center" style="margin-left: auto; margin-right: auto;">

                <button id="confirmarOperacion" type="submit" class="button button-pri" style="margin-right: 40px">
                    <i class="svg-icon fas fa-check"></i>
                    <span class="lable">Dar de baja</span></button>
                <button type="button" class="button button-red" data-bs-dismiss="modal"> <i
                        class="svg-icon fas fa-xmark"></i>
                    <span class="lable">Cancelar</span> </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ayudaAlbergueD" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h3 style="margin-left: auto; margin-right: auto;">Ayuda</h5>
            </div>
            <div class="modal-body text-center">
                
               
                <p> °Para albergar un nuevo animal desde aca mismo seleccionamos el signo de mas.</p>
                <p></p>
                <p>°Selecionamos el animal que queremos albergar, presionando el icono de la casita.</p>
                <p></p>
                <img src="/img/Alb.png" alt="Descripción de la imagen" class="img-fluid">
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
