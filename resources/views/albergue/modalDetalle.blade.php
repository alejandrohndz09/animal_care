
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

