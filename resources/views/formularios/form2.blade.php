@extends('layouts.master')

@section('content')
<div id="layoutSidenav_content">
    <main>  
        <div class="container-fluid px-4">
            <div class="container w-40 border p-4 mt-4">
                <form>
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Nombre</label>
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Rocky">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Direccion de permanencia</label>
                                <input type="password" class="form-control" id="inputPassword4" placeholder="Col.San Luis, pasaje #3">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Fecha de nacimiento o estimada</label>
                                <input type="password" class="form-control" id="inputPassword4" placeholder="dd/mm/yyyy">
                            </div>
                        </div>
            
                        <div class="form-row">
                            <div class="form-group col-md-4 $purple-700">
                                <label for="inputState">Raza</label>
                                <select id="inputState" class="form-control">
                                    <option selected>Seleccione...</option>
                                    <option>Chiguagua</option>
                                    <option>Dalmata</option>
                                    <option>Pitbull</option>
                                    <option>Mestizo</option>
                                </select>
                            </div>
            
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-check">
            
                                <label class="form-check-label" for="gridCheck">
                                    Sexo
                                </label>
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Femenina
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                            <label class="form-check-label" for="exampleRadios2">
                                Masculino
                            </label>
                        </div>
                        <div class="text-center">
                        <img src="./Raster.jpg" class="rounded" alt="">
                      </div>
                    </form>
                    <form>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Particularidad</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                            <small id="emailHelp" class="form-text text-muted">Alguna caracteristica particular
                            </small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="inputState">Subir foto</label>
                            <input type="file" class="form-control" aria-label="file example" required>
                            <div class="invalid-feedback">Example invalid form file feedback</div>
                          </div>
                        <div> <button type="submit" class="btn btn-primary ">Guardar</button></div>
            
                    </form>
                    
            </div>
        </div>
    </main>
</div>
@endsection