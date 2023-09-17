
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

} function validarDui(input) {
    let duiValue = input.value;
    const formatoDUI = /^\d{8}-\d$/;

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

//Agregar un input telefono
$(document).ready(function () {
    //Habilitar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-pp="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
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
        <div  class="row" id="remove">
               <div class="col-xl-6">
                  <div class="inputContainer">
                       <input class="inputField form-control telefono"  id="tel`+ con + `"
                          value="+503 " name="telefono`+ con + `" type="text" oninput="validarInput(this)">
                           <small  style="color:red" class="error-message" id="error-` + con + `"></small>
                  </div>
                </div>
             <div class="col-xl-6">
                  <button type="button" class="button button-sec remove-telefono"
                  data-bs-toggle="modal" >
                   <i class="svg-icon fas fa-minus"></i>
                  </button>
            </div>
        </div>
        `;
            $("#telefono-container").append(newTelefonoField);
        }

    });


    //Remover telefono
    $("#telefono-container").on("click", ".remove-telefono", function () {
        var telefonoId = $(this).data("telefono-id");
        var contador = parseInt($("#con").val());

        // Obtén el elemento por su ID para eliminarlo de la BD
        var elemento = document.getElementById('DeleteCell');

        //Verifica si el elememto es nulo entonces significa que el telefono no esta guardado en la BD
        if (elemento != null) {
            // El elemento existe en el DOM
            var valor = elemento.value;
            //Elimina registro
            if (valor) {
                $.ajax({

                    url: "/destroyTelefono/" + telefonoId,
                    method: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        console.log('Condición cumplida: ');
                        // Eliminar el div del DOM si la eliminación en el servidor fue exitosa
                        var divAEliminar = document.getElementById('remove');
                        console.log(divAEliminar);
                        divAEliminar.remove();
                        var contador = $("#con");
                        var con = parseInt(contador.val());
                        con = con - 1;
                        contador.val(con);

                        // Abre el modal
                        $('#modalEliminacion').modal('show');

                        // Ocultar el modal después de 4 segundos
                        setTimeout(function () {
                            $('#modalEliminacion').modal('hide');
                        }, 2000);

                    },
                    error: function (xhr, status, error) {
                        //console.error(error);
                        console.log(error);
                        alert("Ocurrió un error al eliminar el teléfono." + xhr.responseText);
                    }
                });

            }
        } else {
            $('#ModalTelefono').on('show.bs.modal', function () {

                $('body').on('click', '#confirmar', function () {
                    // Obtener el valor ingresado en el input
                    var dato = document.getElementById('miInput').value;

                    // Si no se cumple la condición, eliminar el campo de teléfono sin mensaje de la BD de eliminacion de registros
                    $(this).closest("#remove").remove();
                    var contador = $("#con");
                    var con = parseInt(contador.val());

                    con = con - 1; // decrementa el valor de 'con' en 1
                    contador.val(con); // Actualiza el valor en el campo de entrada
                });
            });
        }


    });

    //Validacion de campos vacios en el formulario
    $("#miFormulario").submit(function (event) {
        var inputs = $(this).find("input"); // Obtener todos los campos de entrada en el formulario

        // Iterar a través de los campos de entrada
        for (var i = 0; i < inputs.length; i++) {
            var inputValue = inputs[i].value.trim();
            var errorSpan = $(inputs[i]).siblings(".error-message");

            if (inputValue === "") {
                event.preventDefault(); // Detener el envío del formulario
                errorSpan.text("Este campo no puede estar vacío.");
            } else {
                errorSpan.text(""); // Limpiar el mensaje de error si el campo no está vacío
            }
        }
    });

    //Si presiona eliminar abrira el modal con los datos que se daran de baja
    $('#exampleModalToggle').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que desencadenó el modal
        var id = button.data('id'); // Obtiene el valor del atributo data-id
        var nombre = button.data('nombre'); // Obtiene el valor del atributo data-nombre
        var apellido = button.data('apellido'); // Obtiene el valor del atributo data-apellido
        var correo = button.data('correo'); // Obtiene el valor del atributo data-correo

        // Actualiza el contenido del modal con los detalles del registro
        $('#modalRecordNombre').text(nombre);
        $('#modalRecordApellido').text(apellido);
        $('#modalRecordCorreo').text(correo);

        $('body').on('click', '#confirmar', function () {
            $.get('/destroy/' + id, function () {
                // location.reload();
                window.location.href = '/miembro'
            });
        });

    });

    $("#btnCancelar").click(function () {
        window.location.href = '/miembro'
    });

    $(".btnDelete").click(function (event) {
        // Evitar la propagación del evento al hacer clic en la fila
        event.stopPropagation();
    });
    $(".btnUpdate").click(function (event) {
        // Evitar la propagación del evento al hacer clic en la fila
        event.stopPropagation();
    });


    // Escuchar el click en una fila
    $('.miembro-row').on('click', function (event) {
        // Verifica si el clic se realizó en un botón de editar o eliminar

        if ($(event.target).is('a#btnUpdate') || $(event.target).is('a#btnDelete')) {
            console.log('Presiono aqui en los botones');
            return; // No muestres el modal si se hizo clic en un botón
        } else {

            var idMiembro = $(this).find('[data-id]').data('id');
            var dui = $(this).find('[data-dui]').data('dui');
            var nombres = $(this).find('[data-nombre]').data('nombre');
            var apellidos = $(this).find('[data-apellido]').data('apellido');
            var correo = $(this).find('[data-correo]').data('correo');

            $.ajax({
                url: 'miembro/telefonos/' + idMiembro, // La URL de la ruta definida en Laravel
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
            $('#modalIdMiembro').text(idMiembro);
            $('#modalDui').text(dui);
            $('#modalNombres').text(nombres);
            $('#modalApellidos').text(apellidos);
            $('#modalCorreo').text(correo);

            // Abre el modal
            $('#ModalToggle').modal('show');
        }
    });


});
