<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AnimalCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet"
        href="{{ url('https://cdn.jsdelivr.net/npm/sweetalert2@10.3.5/dist/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="<?php echo asset('css/f1.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/f3.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/input.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/styles.css'); ?>" type="text/css">
</head>

<body style="background: #6067eb; padding: 3%;">

    <div class="row" style="height:80vh;justify-content: center; align-content: center">

        <div class="col-xl-4"
            style="display: flex; font-size: 46px; color:#fff; align-items: center; justify-content: center; gap: 5px; ">
            <img src="{{ asset('img/logo.png') }}" height="120px;" style="padding-bottom: 3px">
            <strong style="font-family: 'Raleway','More Sugar','Dosis',Arial, sans-serif;">AnimalCare</strong>
        </div>

        <div class="col-xl-4">
            <div class="card  py-5" style="border:none;  padding-bottom: 50px !important; width: 100%">
                <h1 style="padding: -5px 0px !important; margin-bottom:25px ">
                    Inicio de sesión
                </h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="inputContainer">
                        <input type="text" class="inputField" autocomplete="off" name="usuario" placeholder="Ingrese su usuario.">
                        <label class="inputFieldLabel" for="usuario">Usuario o Correo:</label>
                        <i class="inputFieldIcon fas fa-user"></i>
                        @error('usuario')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="inputContainer ">
                        <input type="password" class="inputField" name="clave" placeholder="Ingrese su clave.">
                        <label class="inputFieldLabel" for="clave">Clave:</label>
                        <i class="inputFieldIcon fas fa-key"></i>
                        @error('clave')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <p style="text-align: end"><a class="" style="text-decoration: none; color: #6067eb"  data-bs-toggle="modal" data-bs-target="#recuperar" href="">¿Olvidó su clave?</a></p>
                    </div>

                    <button type="submit" class="button "
                        style="width: 100%;padding: 7px 7px; justify-items: end; background: #606eed;" >
                        <span class="lable" style="color:#fff" >Ingresar<span>
                    </button>
                </form>

            </div>
        </div>
    </div>
    <div style="text-align: center; color:#e8e5e5">
        <p>©️Tejutepets-Todos los derechos reservados.</p>
    </div>
    <div class="modal fade" id="recuperar" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 style="margin-left: auto; margin-right: auto;">Recuperacion de contraseña</h5>
                </div>
                <div class="modal-body text-center">
                    <!-- Utiliza la clase text-center para centrar los elementos -->
                    <p> <img src="{{ asset('img/recurso.png') }}" alt="user" class="picture"
                            style="width: 35%; height: auto; margin-left: auto; margin-right: auto;"> </p>
                    <p>Código: <span id="Codigo"></span></p>
                    <p>Descripcion: <span id="Nombre"></span></p>
                    <p>Categoría: <span id="Categoria"></span>
    
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="{{ url('https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js') }}"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>

    <script src="{{ url('https://cdn.jsdelivr.net/npm/sweetalert2@10.3.5/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/tablas.js') }}"></script>
    @if (session('alert'))
        <script>
            Toast.fire({
                icon: "{{ session('alert')['type'] }}",
                title: "{{ session('alert')['message'] }}",
            });
        </script>
        @php
            session()->forget('alert');
        @endphp
    @endif
</body>

</html>
