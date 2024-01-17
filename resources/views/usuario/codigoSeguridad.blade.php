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
                        Validación de código de seguridad.
                    </h5>
                    <p style="color: #867596; font-size: 14px; margin-bottom: 0">
                        Se ha enviado un código de seguridad a la dirección {{ $usuario->miembro->correo }}.
                    </p>
                </div>

                <form method="post" action="{{ url('/recuperarClave') }}">
                    @csrf
                    <input type="hidden" class="inputField" name="usuario" id="usuario"
                        value="{{ $usuario->idUsuario }}">

                    <div class="inputContainer ">
                        <input type="text" class="inputField" id="codigo"name="codigo"
                            placeholder="Ingrese código de seguridad">
                        <label class="inputFieldLabel" for="codigo">Código:</label>
                        <i class="inputFieldIcon fas fa-key"></i>
                        @error('codigo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label id="advertencia"></label>
                    </div>


                    <button type="submit" class="button mb-2"
                        style="width: 100%;padding: 7px 7px; justify-items: end; background: #606eed;">
                        <i class="svg-icon fas fa-check" style="color:#fff"></i>
                        <span class="lable" style="color:#fff">Verificar<span>
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

    <!-- En tu vista Blade -->
    <script>
        $(document).ready(function() {
            $('input[name="codigo"]').on('input', function() {
                validarCampos();
            });
            // Escucha el evento de envío del formulario
            $('form').on('submit', function(event) {
                // Realiza la validación antes de enviar el formulario


                if (!validarCampos()) {
                    event
                        .preventDefault(); // Evita el envío del formulario si no se cumplen las validaciones
                } else {
                    event.preventDefault(); // Evita que el formulario se envíe automáticamente
                    
                    // Realiza la solicitud AJAX
                    $.ajax({
                        type: 'get',
                        url: '/verificarToken/' + $('input[name="codigo"]').val()+'/'+ $('input[name="usuario"]').val(),
                        success: function(response) {
                            console.log(response);
                            // Verifica la respuesta del servidor
                            if (response.valido === 1) {
                                // Si es válido, envía el formulario
                                $('form')[0].submit();
                            } else {
                                // Si no es válido, muestra un mensaje o realiza otras acciones
                                $('#advertencia').text('El código ingresado no es válido.').css(
                                    'color', 'red');
                            }
                        },
                        error: function(error) {
                            // Maneja los errores de la solicitud AJAX
                            $('#advertencia').text('Ha ocurrido un error.' + error).css('color',
                                'red');
                        }
                    });
                }


            });


            // Función para validar los campos y mostrar la advertencia
            function validarCampos() {
                // Validación de campos requeridos
                var camposRequeridos = ['codigo'];
                for (var i = 0; i < camposRequeridos.length; i++) {
                    var valorCampo = $('input[name="' + camposRequeridos[i] + '"]').val();
                    if (!valorCampo) {
                        $('#advertencia').text('Por favor, ingrese el código de seguridad.').css('color', 'red');
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
