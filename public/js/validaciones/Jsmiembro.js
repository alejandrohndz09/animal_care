
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

//Agregar un input telefono
$(document).ready(function () {

    document.getElementById("iconDui").style.color = '#cdcbcd';
    // Escucha el evento de cambio del checkbox
    $("#esMayorDeEdad").change(function (event) {
        event.stopPropagation();
        document.getElementById("iconDui").style.color = '#cdcbcd';

        // Obtén el campo DUI
        var duiInput = $("input[name='dui']");

        // Habilitar o deshabilitar el campo DUI en función del estado del checkbox
        if ($(this).is(":checked")) {
            duiInput.prop("disabled", false);
            duiInput.val(''); // Borra el contenido del campo DUI
            document.getElementById("iconDui").style.color = "#6067eb";
        } else {
            duiInput.prop("disabled", true);
            duiInput.val(''); // Borra el contenido del campo DUI
            document.getElementById("iconDui").style.color = '#cdcbcd';
        }
    });

    //Habilitar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-pp="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
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
        <div  class="row" id="remove${con}">
               <div class="col-xl-6">
                  <div class="inputContainer">
                       <input class="inputField form-control telefono"  id="tel`+ con + `"
                          value="+503 " name="telefono`+ con + `" type="text" oninput="validarInput(this)">
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
        </div>
        `;
            $("#telefono-container").append(newTelefonoField);
        }

    });

    $("#telefono-container").on("click", ".remove-telefono", function () {
        var telefonoId = $(this).data("telefono-id"); // Almacenar telefonoId
        var removeList = $(this).data("remove"); // Almacenar el id que se eliminara

        var telefono = $(this).data("telefono"); // Obtener el name del input dinamico agregado por el usuario para obtener el valor
        var valorGuardado = $("input[name='" + telefono + "']").val();//Guardar valor del input en especifico que se selecciono
        var telefonoBD = $(this).data("telefono-e"); // Numero de BD para mostrar en el modal si quiere eliminarlo o no

        //Verifica si el input esta vacio entonces no mostrara el modal sino solo lo eliminara
        if (valorGuardado === "+503 ") {

            // Elimina input
            $("#" + removeList).remove();
            var contador = $("#con");
            var con = parseInt(contador.val());
            con = con - 1; // decrementa el valor de 'con' en 1
            contador.val(con); // Actualiza el valor en el campo de entrada

        }//Sino entonces esta con un registro pregunta al usuario 
        else {

            //Si hay datos en telefono signica que estamos eliminando un registro de la BD y para confirmacion obtenemos el data 
            if (telefono != null) {
                // Actualiza el contenido del modal con los detalles del registro
                $('#telefono').text(valorGuardado);
            } else {
                // Actualiza el contenido del modal con los detalles del registro
                $('#telefono').text(telefonoBD);
            }


            // Abrir el modal de confirmación
            $("#modalTelefono").modal("show");


            $("#confirmarCell").on("click", function () {
                // Cerrar el modal de confirmación

                $("#modalTelefono").modal("hide");

                console.log(telefonoId);

                // Si esta vacio significa que no esta guardado el telefono en la BD
                if (telefonoId === "vacio") {
                    console.log('Aqui el if de eliminar sin AJAX');

                    // Elimina input
                    $("#" + removeList).remove();
                    var contador = $("#con");
                    var con = parseInt(contador.val());
                    con = con - 1; // decrementa el valor de 'con' en 1
                    contador.val(con); // Actualiza el valor en el campo de entrada

                } else {
                    // Realizar la eliminación del registro utilizando AJAX
                    $.ajax({
                        url: "/destroyTelefono/" + telefonoId,
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function () {
                            // Eliminar el elemento del DOM si la eliminación en el servidor fue exitosa
                            var divAEliminar = $("#" + removeList);
                            divAEliminar.remove();

                            // Restar 1 al contador
                            var contador = $("#con");
                            var con = parseInt(contador.val());
                            con = con - 1;
                            contador.val(con);

                            // Abre el modal
                            $('#modalEliminacion').modal('show');

                            // Ocultar el modal después de 4 segundos
                            setTimeout(function () {
                                $('#modalEliminacion').modal('hide');
                            }, 1050);

                            telefonoId = "";
                        },
                        error: function (xhr, status, error) {
                            console.log(error);

                        }
                    });
                }
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

    $(".btnUpdate").click(function () {
        var dui = $(this).data('dui');
        console.log(dui);
        if (dui != null) {
            $('#esMayorDeEdad').prop('checked', true);
        }
    });

//Muestra el modal con los detalles del miembro
    $('#table').on('click', '.ver-button', function () {
        var idMiembro = $(this).data('id');
        var dui = $(this).data('dui');
        var nombres = $(this).data('nombre');
        var apellidos = $(this).data('apellido');
        var correo = $(this).data('correo');

    
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
    });

});

