@extends('layouts.master')
@section('styles')
  
@endsection

@section('scripts')
  
@endsection

<link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div style="width: 100%; display: flex;align-items: center; justify-content: space-between; gap:20px">
                    <h1>Animales </h1>
                    
                        <div class="inputContainer" style="margin: auto; align-items: end">
                            <input id="searchInput" class="inputField card" style="width: 50%" 
                            autocomplete="off" placeholder="🔍︎ Buscar" type="search">
                        </div>
                    
                    {{-- <button class="btn button-pri">
                        <i class="fas fa-plus"></i>
                        <span class="lable">Agregar nuevo registro</span>
                    </button> --}}
                </div>

                <div class="row mt-3">
                    <div class="col-xl-7">
                        <table>
                            <thead>
                                <tr class="head">
                                    <th></th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Edad</th>
                                    <th>Sexo</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <tr>
                                    <td>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                            alt="user" class="picture" />
                                    </td>
                                    <td>John</td>
                                    <td>Doe</td>
                                    <td>25</td>
                                    <td>Masculino</td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                            alt="user" class="picture" />
                                    </td>
                                    <td>Jane</td>
                                    <td>Smith</td>
                                    <td>30</td>
                                    <td>Femenino</td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                            alt="user" class="picture" />
                                    </td>
                                    <td>Michael</td>
                                    <td>Johnson</td>
                                    <td>45</td>
                                    <td>Masculino</td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                            alt="user" class="picture" />
                                    </td>
                                    <td>Sarah</td>
                                    <td>Williams</td>
                                    <td>35</td>
                                    <td>Femenino</td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                            alt="user" class="picture" />
                                    </td>
                                    <td>Robert</td>
                                    <td>Brown</td>
                                    <td>28</td>
                                    <td>Masculino</td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                            alt="user" class="picture" />
                                    </td>
                                    <td>Emily</td>
                                    <td>Davis</td>
                                    <td>32</td>
                                    <td>Femenino</td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                            alt="user" class="picture" />
                                    </td>
                                    <td>David</td>
                                    <td>Miller</td>
                                    <td>50</td>
                                    <td>Masculino</td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                            alt="user" class="picture" />
                                    </td>
                                    <td>Emma</td>
                                    <td>Wilson</td>
                                    <td>29</td>
                                    <td>Femenino</td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                            alt="user" class="picture" />
                                    </td>
                                    <td>Christopher</td>
                                    <td>Taylor</td>
                                    <td>42</td>
                                    <td>Masculino</td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                            alt="user" class="picture" />
                                    </td>
                                    <td>Olivia</td>
                                    <td>Anderson</td>
                                    <td>31</td>
                                    <td>Femenino</td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="pagination">
                            
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="card  mb-4" style="border:none; padding-bottom: 25px !important; width: 100%">
                            <h3 style="padding: -5px 0px !important;">Nuevo Registro</h3>
                            <form action="post">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="custum-file-upload" for="file"
                                            style="margin-top:-10px; width: auto; height: 75%;">
                                            <div class="icon" style="color:#c4c4c4;">
                                                <i style="height: 55px; padding: 10px" class="fas fa-camera"></i>
                                            </div>

                                            <input type="file" id="file">
                                        </label>
                                    </div>
                                    <div class="col-xl-8">
                                        <div class="inputContainer">
                                            <input required="required" id="nombre" class="inputField"
                                                placeholder="Nombre" type="text" autocomplete="off">
                                            <label class="inputFieldLabel" for="nombre">Nombre</label>
                                            <i class="inputFieldIcon fas fa-pen"></i>
                                        </div>
                                        <div class="inputContainer">
                                            <input required="required" id="fecha" class="inputField"
                                                autocomplete="false" placeholder="Fecha de nacimiento" type="date">
                                            <label class="inputFieldLabel" for="fecha">Fecha de nacimiento
                                                estimada</label>
                                            <i class="inputFieldIcon fas fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="inputContainer">
                                    <select required="required" id="especie" class="inputField">
                                        <option selected>Seleccione...</option>
                                        <option>Perro</option>
                                        <option>Gato</option>
                                    </select>
                                    <label class="inputFieldLabel" for="especie">Especie</label>
                                    <i class="inputFieldIcon fas fa-dog"></i>
                                </div>
                                <div class="inputContainer">
                                    <select required="required" id="raza" class="inputField">
                                        <option>Seleccione...</option>
                                        <option>Chiguagua</option>
                                        <option>Dalmata</option>
                                        <option>Pitbull</option>
                                        <option>Mestizo</option>
                                    </select>
                                    <label class="inputFieldLabel" for="raza">Raza</label>
                                    <i class="inputFieldIcon fas fa-paw"></i>
                                </div>
                                <div class="inputContainer">
                                    <label class="inputFieldLabel">sexo</label>
                                    <i class="inputFieldIcon fas fa-question"></i>
                                    <div style="padding: 3px 15px">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sexo"
                                                id="inlineRadio1" value="option1">
                                            <label class="form-check-label" for="Hembra">Hembra</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sexo"
                                                id="inlineRadio2" value="option2">
                                            <label class="form-check-label" for="Macho">Macho</label>
                                        </div>
                                    </div>

                                </div>
                                <div style="display: flex; align-items: flex-end; gap: 10px; justify-content: center">
                                    <button type="reset" class="button button-sec">
                                        <i class="svg-icon fas fa-rotate-right"></i>
                                        <span class="lable">Cancelar</span>
                                    </button>
                                    <button type="submit" class="button button-pri">
                                        <i class="svg-icon fa-regular fa-floppy-disk"></i>
                                        <span class="lable">Guardar</span>
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

