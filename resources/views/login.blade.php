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
                        <input type="text" value="{{ old('usuario') }}"class="inputField" autocomplete="off"
                            name="usuario" placeholder="Ingrese su usuario.">
                        <label class="inputFieldLabel" for="usuario">Usuario o Correo:</label>
                        <i class="inputFieldIcon fas fa-user"></i>
                        @error('usuario')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="inputContainer ">
                        <input type="password" class="inputField" id="clave" name="clave"
                            placeholder="Ingrese su clave.">
                        <label class="inputFieldLabel" for="clave">Clave:</label>
                        <i class="inputFieldIcon fas fa-key"></i>
                        @error('clave')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="d-flex mt-3 align-items-center">
                            <div class="d-flex flex-grow-1 " style="margin-left:5px; gap:3px">
                                <input type="checkbox" id="mostrarClave"> Mostrar Clave
                            </div>
                            <p style="text-align: end; margin-bottom: 0;"><a class=""
                                    style="text-decoration: none; color: #6067eb" data-bs-toggle="modal"
                                    data-bs-target="#recuperar" href="">¿Olvidó su
                                    clave?</a>
                            </p>
                        </div>
                    </div>

                    <button type="submit" class="button "
                        style="width: 100%;padding: 7px 7px; justify-items: end; background: #606eed;">
                        <span class="lable" style="color:#fff">Ingresar<span>
                    </button>
                </form>

            </div>
        </div>
    </div>
    <div style="text-align: center; color:#e8e5e5">
        <p>©️UES FMP - Todos los derechos reservados.</p>
    </div>
    <div class="modal fade" id="recuperar" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <form action="/recuperarClaveMail" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 style="margin-left: auto; margin-right: auto;">Recuperar clave</h5>
                    </div>

                    <div class="modal-body text-center px-5">
                        <div
                            style="margin: 0; display: flex;flex-direction: column; align-items: center; justify-content: center ">

                            <div class="inputContainer mt-4 mb-2">
                                <input type="email" id="correo" name="correo"
                                    placeholder="ejemplo@email.com"class="inputField">
                                <label class="inputFieldLabel" for="raza">Ingrese un correo electrónico asociado al
                                    miembro:</label>
                                <i class="inputFieldIcon fas fa-user"></i>

                            </div>
                            <div
                                style="margin: 0; display: flex; align-items: center;width:auto; color:#867596; font-size: 14px ">
                                <i class="fas fa-circle-info" style="margin-right: 3px;"></i>
                                Se enviará un código de seguridad al correo indicado.
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
    <!-- resources/views/tu_vista.blade.php -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var checkbox = document.getElementById('mostrarClave');
            var claveInput = document.getElementById('clave');

            checkbox.addEventListener('change', function() {
                if (checkbox.checked) {
                    // Si el checkbox está marcado, cambia el tipo del input a 'text'
                    claveInput.type = 'text';
                } else {
                    // Si el checkbox está desmarcado, vuelve a establecer el tipo del input a 'password'
                    claveInput.type = 'password';
                }
            });
        });
    </script>
</body>

</html>
