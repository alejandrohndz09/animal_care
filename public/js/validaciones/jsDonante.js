function validarDui(input) {
    let duiValue = input.value;

    // Eliminar caracteres no válidos
    duiValue = duiValue.replace(/[^\d-]/g, '');

    // Eliminar guiones adicionales al final del valor
    duiValue = duiValue.replace(/-+$/, '');

    // Limitar la longitud máxima a 10 caracteres (8 dígitos + 1 guion + 1 verificador)
    if (duiValue.length > 10) {
        duiValue = duiValue.slice(0, 10);
    }

    // Insertar el guion después del octavo dígito
    if (duiValue.length == 8) {
        duiValue = duiValue.slice(0, 8) + '-' + duiValue.slice(8);
    }

    // Asignar el valor al campo de entrada
    input.value = duiValue;
}

function validarTexto(input) {
    let duiValue = input.value;

    // Eliminar caracteres no válidos (dejar solo letras y espacios)
    duiValue = duiValue.replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/g, '');

    // Asignar el valor al campo de entrada
    input.value = duiValue;
}

function validarInput(input) {
    let telefonoValue = input.value;

    // Eliminar caracteres no válidos
    telefonoValue = telefonoValue.replace(/[^+\d\s-]/g, '');

    // Eliminar guiones existentes
    telefonoValue = telefonoValue.replace(/-/g, '');

    // Limitar la longitud máxima a 14 caracteres
    if (telefonoValue.length > 13) {
        telefonoValue = telefonoValue.slice(0, 13);
    }

    // Agregar un guion después del cuarto dígito
    if (telefonoValue.length >= 9) {
        telefonoValue = telefonoValue.slice(0, 9) + '-' + telefonoValue.slice(9);
    }

    // Asignar el valor al campo de entrada
    input.value = telefonoValue;
}

$(document).ready(function () {

    //Habilitar tooltips
    tooltips();

    $("#add-telefono").click(function () {
        var contador = $("#con");
        var con = parseInt(contador.val());

        var telefonoInput = $(".telefono:last");
        var telefonoValue = telefonoInput.val().trim();
        var errorSpan = telefonoInput.siblings(".error-message");

        // Validar si el campo está vacío
        if (telefonoValue === "+503") {
            errorSpan.text("El campo no puede estar vacío.");
            return; // Detener la función si el campo está vacío
        } else if (telefonoValue.length < 13) {
            errorSpan.text("El número de teléfono no es válido.");
            return; // Detener la función si el campo no es válido
        } else {
            errorSpan.text(""); // Limpiar el mensaje de error si no hay errores

            con++;
            contador.val(con);

            // Si pasa ambas validaciones, puedes agregar el nuevo campo de teléfono
            var newTelefonoField = `
            <div class="row" id="remove${con}">
               <div class="col-xl-6">
                  <div class="inputContainer">
                       <input class="inputField form-control telefono"  id="tel`+ con + `"
                          value="+503 " name="telefonosAd[]" type="text" oninput="validarInput(this)">
                           <small  style="color:red" class="error-message" id="error-` + con + `"></small>
                  </div>
                </div>
                <div class="col-xl-6">
                    <button type="button" class="button button-sec remove-telefono"
                    data-telefono="telefono${con}"
                    data-remove="remove${con}"
                    data-telefono-id="vacio" data-bs-pp="tooltip"
                    data-bs-placement="top" title="Eliminar telefono">
                    <i class="svg-icon fas fa-minus"></i>
                    </button>
                </div>
            </div>`;
            $("#telefono-container").append(newTelefonoField);
            // Cierra el tooltip si está abierto
            $(this).tooltip('hide');
            tooltips();
        }

    });

    $("#telefono-container").on("click", ".remove-telefono", function () {
        $(this).closest('.row').remove();
        $(this).remove();
        var contador = $("#con");
        var con = parseInt(contador.val());
        con = con - 1; // decrementa el valor de 'con' en 1
        contador.val(con); // Actualiza el valor en el campo de entrada
        // Cierra el tooltip si está abierto
        $(this).tooltip('hide');
    });


    //Si presiona eliminar abrira el modal con los datos que se daran de baja
    $('#exampleModalToggle').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que desencadenó el modal
        // Botón que desencadenó el modal
        var id = button.data('donante').idDonante; // Obtiene el valor del atributo data-id
        var nombre = button.data('donante').nombres; // Obtiene el valor del atributo data-nombre
        var apellido = button.data('donante').apellidos; // Obtiene el valor del atributo data-apellido
        var dui = button.data('donante').dui; // Obtiene el valor del atributo data-correo
        console.log(id);
        // Actualiza el contenido del modal con los detalles del registro
        $('#modalRecordNombre').text(nombre);
        $('#modalRecordApellido').text(apellido);
        $('#modalRecordCorreo').text(dui);

        $('body').on('click', '#confirmar', function () {


            //Dar de baja cuando este lo de estado
            $.get('/darBaja/' + id, function () {
                // location.reload();
                window.location.href = '/inventario/donantes'
            });

        });
    });

    //Si presiona eliminar abrira el modal con los datos que se daran de baja
    $('#modalDonante').on('show.bs.modal', function (event) {
        // Ocultar el modal con el id 'tabla'
        $('#tabla').modal('hide');
        var button = $(event.relatedTarget); // Botón que desencadenó el modal
        // Botón que desencadenó el modal
        var button = $(event.relatedTarget);
        var idDonante = button.data('donante').idDonante;
        var nombres = button.data('donante').nombres;
        var apellidos = button.data('donante').apellidos;
        var dui = button.data('donante').dui;
        console.log("ID Donante:", idDonante);
        console.log("Nombres:", nombres);
        console.log("Apellidos:", apellidos);
        console.log("DUI:", dui);

        // Actualiza el contenido del modal con los detalles del registro
        $('#modalNombre').text(nombres);
        $('#modalApellido').text(apellidos);
        $('#modalCorreo').text(dui);

        $('body').on('click', '#Eliminar', function () {
            $.get('/destroyDonante/' + idDonante, function () {
                // location.reload();
                window.location.href = '/inventario/donantes'
            });
        });
    });


    $(".btnDelete").click(function (event) {
        // Evitar la propagación del evento al hacer clic en la fila
        event.stopPropagation();
    });
    $(".btnUpdate").click(function (event) {
        // Evitar la propagación del evento al hacer clic en la fila
        event.stopPropagation();
    });


    $('.donante-row').on('click', function (event) {
        // Verifica si el clic fue en un botón dentro de la fila
        if ($(event.target).is('.btnUpdate, .btnDelete')) {
            return; // Evita abrir el modal si se hizo clic en un botón
        }

        var DonanteData = $(this).data('donante');
        var idDonante = DonanteData.idDonante;
        var dui = DonanteData.dui;
        var nombres = DonanteData.nombres;
        var apellidos = DonanteData.apellidos;


        $.ajax({
            url: '/inventario/donantes/donantes/telefonos/' + idDonante, // La URL de la ruta definida en Laravel
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var isFirst = true; // Variable para rastrear si es el primer registro
                $('#telefonos').empty();
                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                        var text = data[key]; // Obtén el valor actual

                        // Aplica el estilo CSS solo al primer registro
                        if (isFirst) {
                            $('#telefonos').append('<br>' + text);
                            isFirst = false; // Cambia el valor de isFirst para que los siguientes registros no apliquen el estilo
                        } else {
                            // Inserta los registros restantes sin el estilo
                            $('#telefonos').append('<br>' + text);
                        }
                    }
                }
            },
            error: function (error) {
                console.error('Error en la solicitud:', error);
            }
        });

        // Llena el modal con los datos correspondientes
        $('#Dui').text(dui);
        $('#Nombres').text(nombres);
        $('#Apellidos').text(apellidos);

        // Abre el modal
        $('#ModalToggle').modal('show');
    });
});

function tooltips() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-pp="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
}
