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

        <div class="col-xl-4">
            <div class="card  py-5" style="border:none;  padding-bottom: 50px !important; width: 100%">
                <div class="col-xl-12"
                    style="display: flex; font-size: 24px; color:#000; align-items: center; justify-content: center; gap: 5px; ">
                    <img src="{{ asset('img/logo.png') }}" height="44px;" style="padding-bottom: 3px">
                    <strong style="font-family: 'Raleway','More Sugar','Dosis',Arial, sans-serif;">AnimalCare</strong>
                </div>
                <div style="display: flex; flex-direction: column">
                    <h5 style="padding: -5px 0px !important; margin-bottom:0px ">
                        Bienvenido {{ $usuario->usuario }}.
                    </h5>
                    @if (!isset($opcion))
                        <p style="color: #867596; font-size: 14px; margin-bottom: 0">Debes cambiar tu clave temporal.
                        </p>
                    @else
                        <p style="color: #867596; font-size: 14px; margin-bottom: 0">Debes ingresar una nueva clave de acceso.
                        </p>
                    @endif
                </div>

                <form method="POST" action="{{ url('/cambiarClaveTemporal') }}">
                    @csrf
                    <input type="hidden" class="inputField" name="usuario" id="usuario"
                        value="{{ $usuario->idUsuario }}">
                    <div class="inputContainer ">
                        <input type="password" class="inputField" name="clave1" id="clave1"
                            placeholder="Ingrese su clave.">
                        <label class="inputFieldLabel" for="clave1">Nueva clave:</label>
                        <i class="inputFieldIcon fas fa-key"></i>
                        @error('clave1')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="inputContainer ">
                        <input type="password" class="inputField" id="clave2"name="clave2"
                            placeholder="Confirme su clave.">
                        <label class="inputFieldLabel" for="clave2">Confirmar clave:</label>
                        <i class="inputFieldIcon fas fa-key"></i>
                        @error('clave2')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="d-flex mt-3 align-items-center">
                            <div class="d-flex flex-grow-1 " style="margin-left:5px; gap:3px">
                                <input type="checkbox" id="mostrarClave"> Mostrar Clave
                            </div>
                        </div>
                        <label id="advertencia"></label>
                    </div>


                    <button type="submit" class="button mb-2"
                        style="width: 100%;padding: 7px 7px; justify-items: end; background: #606eed;">
                        <i class="svg-icon fas fa-check" style="color:#fff"></i>
                        <span class="lable" style="color:#fff">Efectuar cambio e ingresar<span>
                    </button>
                    <button type="button" class="button button-sec" onclick="window.location.href='/login'"
                        style="width: 100%;padding: 7px 7px; justify-items: end; ">
                        <i class="svg-icon fas fa-chevron-left"></i>
                        <span class="lable">Volver al inicio<span>
                    </button>
                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="recuperar" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <form action="/usuario" method="post">
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
                                <label class="inputFieldLabel" for="raza">Ingrese un correo elecctónico asociado
                                    al
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
            var claveInput1 = document.getElementById('clave1');
            var claveInput2 = document.getElementById('clave2');

            checkbox.addEventListener('change', function() {
                if (checkbox.checked) {
                    // Si el checkbox está marcado, cambia el tipo del input a 'text'
                    claveInput1.type = 'text';
                    claveInput2.type = 'text';
                } else {
                    // Si el checkbox está desmarcado, vuelve a establecer el tipo del input a 'password'
                    claveInput1.type = 'password';
                    claveInput2.type = 'password';
                }
            });
        });
    </script>
    <!-- En tu vista Blade -->
    <script>
        $(document).ready(function() {
            // Escucha el evento de cambio en los campos
            $('input[name="clave2"]').on('input', function() {
                validarCampos();
            });

            // Escucha el evento de envío del formulario
            $('form').on('submit', function(event) {
                // Realiza la validación antes de enviar el formulario


                if (!validarCampos()) {
                    event
                        .preventDefault(); // Evita el envío del formulario si no se cumplen las validaciones
                }

            });

            // Función para validar los campos y mostrar la advertencia
            function validarCampos() {
                // Obtiene los valores de los campos
                var valorCampo1 = $('input[name="clave1"]').val();
                var valorCampo2 = $('input[name="clave2"]').val();

                // Compara los valores y muestra la advertencia si no son iguales
                if (valorCampo1 !== valorCampo2) {
                    $('#advertencia').text('Los campos deben tener el mismo valor').css('color', 'red');
                    return false; // Retorna falso si no se cumplen las validaciones
                } else {
                    $('#advertencia').text('').css('color', 'black');

                }

                // Validación de campos requeridos
                var camposRequeridos = ['clave1', 'clave2'];
                for (var i = 0; i < camposRequeridos.length; i++) {
                    var valorCampo = $('input[name="' + camposRequeridos[i] + '"]').val();
                    if (!valorCampo) {
                        $('#advertencia').text('Todos los campos son requeridos').css('color', 'red');
                        return false; // Retorna falso si no se cumplen las validaciones
                    }
                    // Validación de mínimo de 8 caracteres
                    if (valorCampo.length < 6) {
                        $('#advertencia').text('La clave debe tener al menos 6 caracteres').css('color', 'red');
                        return false; // Retorna falso si no se cumplen las validaciones
                    }
                }

                // Retorna verdadero si se cumplen todas las validaciones
                return true;
            }
        });
    </script>


</body>

</html>
