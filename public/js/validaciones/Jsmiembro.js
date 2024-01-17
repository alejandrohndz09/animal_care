
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


    //Validacion de campos vacios en el formulario
    $("#miFormulario").submit(function (event) {
        var inputs = $(this).find("input"); // Obtener todos los campos de entrada en el formulario
        var esMayorDeEdadCheckbox = $("#esMayorDeEdad"); // Obtener el checkbox "Es mayor de edad"

        // Iterar a través de los campos de entrada
        for (var i = 0; i < inputs.length; i++) {
            var input = inputs[i];
            var inputValue = input.value.trim();
            var errorSpan = $(input).siblings(".error-message");

            // Verificar si el campo actual es el campo "dui"
            if (input.id === "dui") {
                // Verificar si el checkbox "Es mayor de edad" está desmarcado y el campo "dui" está vacío
                if (esMayorDeEdadCheckbox.prop("checked") && inputValue === "") {
                    event.preventDefault(); // Detener el envío del formulario
                    errorSpan.text("Este campo no puede estar vacío.");
                } else {
                    errorSpan.text(""); // Limpiar el mensaje de error para el campo "dui"
                }
                continue;
            }

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
        // Botón que desencadenó el modal
        var id = button.data('miembro').idMiembro; // Obtiene el valor del atributo data-id
        var nombre = button.data('miembro').nombres; // Obtiene el valor del atributo data-nombre
        var apellido = button.data('miembro').apellidos; // Obtiene el valor del atributo data-apellido
        var correo = button.data('miembro').correo; // Obtiene el valor del atributo data-correo

        // Actualiza el contenido del modal con los detalles del registro
        $('#modalRecordNombre').text(nombre);
        $('#modalRecordApellido').text(apellido);
        $('#modalRecordCorreo').text(correo);

        $('body').on('click', '#confirmar', function () {
            $.get('miembro/DarBaja/' + id, function () {
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


    $('.miembro-row').on('click', function (event) {
        // Verifica si el clic fue en un botón dentro de la fila
        if ($(event.target).is('.btnUpdate, .btnDelete')) {
            return; // No muestres el modal si se hizo clic en un botón
        } else {
            window.location.href ='/miembro/'+$(this).data('miembro').idMiembro;
        }       
    });
});


document.querySelector('.floating-button').addEventListener('click', function () {
    $('#ayudaExpediente').modal('show');
    });