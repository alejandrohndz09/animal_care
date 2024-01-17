<div class="modal fade" id="buscarDonante" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="margin-left: auto; margin-right: auto;">Donantes</h5>
            </div>
            <div class="modal-body">
                <table id="table">
                    <thead>
                        <tr class="head">
                            <th style="width: 10%"></th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>DUI</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody id="tableBody">

                        @foreach ($donantes as $item)
                            <tr class="donante-row">
                                <td style="width: 10%">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                        alt="user" class="picture" />
                                </td>
                                <td>{{ $item->nombres }}</td>
                                <td>{{ $item->apellidos }}</td>
                                <td>{{ $item->dui }} </td>
                                <td>
                                    <div
                                        style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                        <button data-id="{{ $item->idDonante }}" data-nombre="{{ $item->nombres }}"
                                            data-apellido="{{ $item->apellidos }}"type="button"
                                            class="button button-blue seleccion" style="width: 45%" data-bs-pp="tooltip"
                                            data-bs-dismiss="modal" data-bs-placement="top" title="Seleccionar">
                                            <i class="svg-icon fas fa-check"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                </table>
                <div id="pagination">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <!-- Puedes agregar botones adicionales si es necesario -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles de elementos de la lista-->
<div class="modal fade" id="modalDetalleMovimiento" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: auto; margin-right: auto;">Detalles del registro</h5>
            </div>
            <div class="modal-body text-center">
                <!-- Utiliza la clase text-center para centrar los elementos -->
                <p> <img src="{{ asset('img/recurso.png') }}" alt="user" class="picture"
                        style="width: 35%; height: auto; margin-left: auto; margin-right: auto;"> </p>
                <p>Código: <span id="CodigoMovimiento"></span></p>
                <p>Fecha: <span id="fechaMovimiento"></span></p>
                <p>Valor: <span id="ValorMovimiento"></span></p>
                <p>Recurso: <span id="RecursoMovimiento"></span></p>
                <p>Donante: <span id="DonanteMovimiento"></span></p>
                <p>Miembro: <span id="MiembroMovimiento"></span></p>

            </div>
        </div>
    </div>
</div>
