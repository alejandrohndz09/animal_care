<!-- Modal para los registros dados de baja-->
<div class="modal fade" id="tabla" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="margin-left: auto; margin-right: auto;">Lista de albergues de baja</h5>
            </div>
            <div class="modal-body">
                <table>
                    <thead>
                        <tr class="head">
                            <th style="width: 10%"></th>
                            <th>Código</th>
                            <th style="width: 40%">Direccion</th>
                            <th>Responsable</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody id="tableBody">

                        @foreach ($Albergues as $item)
                            @if ($item->estado == 0)
                                <tr class="registro-row">
                                    <td style="width: 10%">
                                        <img src="{{ asset('img/albergue.png') }}" alt="user" class="picture" />
                                    </td>
                                    <td>{{ $item->idAlvergue }}</td>
                                    <td style="width: 40%">{{ $item->direccion }} </td>
                                    <td>{{ $item->miembro->nombres }} {{ $item->miembro->apellidos }}</td>

                                    <td>
                                        <div
                                            style="display: flex; align-items: flex-end; gap: 5px; justify-content: center">
                                            <button
                                                onclick="window.location.href = '{{ url('albergue/alta/' . $item->idAlvergue) }}';"
                                                type="button" class="button button-blue btnUpdate"
                                                data-id="{{ $item->idAlvergue }}" style="width: 45%"
                                                data-bs-pp="tooltip" data-bs-placement="top" title="Dar de alta">
                                                <i class="svg-icon fas fa-up-long"></i>
                                            </button>

                                            <button type="button" class="button button-red btnDelete"
                                                style="width: 45%" data-bs-toggle="modal" data-bs-target="#modalDetalle"
                                                data-id="{{ $item->idAlvergue }}"
                                                data-nombre="{{ $item->miembro->nombres }}"
                                                data-apellido="{{ $item->miembro->apellidos }}"
                                                data-direccion="{{ $item->direccion }}" data-bs-pp="tooltip"
                                                data-bs-placement="top" title="Dar de baja">
                                                <i class="svg-icon fas fa-trash"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para dar de baja un elemento de la lista-->
<div class="modal fade" id="modalDetalle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 style="margin-left: auto; margin-right: auto;">¿Desea dar de baja este registro?</h5>
            </div>
            <div class="modal-body text-center">
                <!-- Utiliza la clase text-center para centrar los elementos -->
                <p> <img src="{{ asset('img/albergue.png') }}" alt="user" class="picture"
                        style="width: 35%; height: auto; margin-left: auto; margin-right: auto;"> </p>
                <p>Código: <span id="modalRecordId"></span></p>
                <p>Nombres: <span id="modalRecordNombre"></span> <span id="modalRecordApellido"></span></p>
                <p>Dirección: <span id="modalRecorddireccion"></span></p>
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



  <!-- Modal -->
  <div class="modal fade" id="abrirModal" tabindex="-1" aria-labelledby="abrirModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="abrirModalLabel">Nuevo animal a alabergar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <div class="inputContainer">
                        <select id="animal" name="animal" class="inputField">
                            <option value=""
                                {{ old('animal') == '' && isset($miembro) == null ? 'selected' : '' }}>
                                Seleccione...
                            </option>
                            @php use App\Models\Animal; @endphp
                            @foreach (Animal::all() as $e)
                                <option value="{{ $e->idAnimal }}"
                                    {{ isset($miembro) ? ($miembro->idAnimal == $e->idAnimal ? 'selected' : '') : (old('animal') == $e->idAnimal ? 'selected' : '') }}>
                                    {{ $e->animal }}
                                </option>
                            @endforeach
                        </select>

                        <label class="inputFieldLabel" for="animal">Animal*</label>
                        <i class="inputFieldIcon fas fa-dog"></i>
                        @error('animal')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                <div class="form-group">
                  <label for="formGroupExampleInput2">Another label</label>
                  <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Another input placeholder">
                </div>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>

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
                                    <img src="{{ isset($a->imagen) ? asset($a->imagen) : asset('img/especie.png') }}"
                                        alt="user" class="picture" />
                                </td>
                                <td>{{ $a->animal->idAnimal }}</td>
                                <td>{{ $a->animal->raza->nombre }}</td>
                                <td>{{ $a->animal->raza->especie->especie }}</td>
                                <td>{{ $a->animal->raza }}</td>
                                <td>{{ AnimalControlador::calcularEdad(explode(' ', $a->animal->fechaNacimiento)[0]) }}
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
