function validarInput(input) {
    let telefonoValue = input.value;
    const formatoTelefono = /^\+\d{3} \d{4}-\d{4}$/;

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
    $("#add-telefono").click(function () {
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

            var contador = $("#contador");
            var con = parseInt(contador.val(), 10);

            con++;
            contador.val(con);

            // Si pasa ambas validaciones, puedes agregar el nuevo campo de teléfono
            var newTelefonoField = `
            <div id="remove">
               <div class="col-xl-6">
                  <div class="inputContainer">
                       <input class="inputField form-control telefono"  
                          value="+503 " name="telefono`+ con + `" type="text" oninput="validarInput(this)"
                           onkeydown="return restrictToNumbersAndHyphen(event)">
                           <small  style="color:red" class="error-message"></small>
                  </div>
                </div>
             <div class="col-xl-3">
                  <button type="button" class="btn btn-danger remove-telefono">
                   <i class="svg-icon fas fa-circle-xmark"></i>
                  </button>

            </div>
        `;
            $("#telefono-container").append(newTelefonoField);
        }
        // Remover campos agregados dinámicamente
        $("#telefono-container").on("click", ".remove-telefono", function () {
            $(this).closest("#remove").remove();
            con--; // decrementa el valor en 1
            contador.val(con); // Actualiza el valor en el campo de entrada
        });

    });

    $(document).ready(function () {
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
    });

});

$(document).ready(function () {
    $('#exampleModalToggle').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que desencadenó el modal
        var id = button.data('id'); // Obtiene el valor del atributo data-id
        var nombre = button.data('nombre'); // Obtiene el valor del atributo data-nombre
        var apellido = button.data('apellido'); // Obtiene el valor del atributo data-apellido
        var correo = button.data('correo'); // Obtiene el valor del atributo data-correo

        // Actualiza el contenido del modal con los detalles del registro
        $('#modalRecordId').text(id);
        $('#modalRecordNombre').text(nombre);
        $('#modalRecordApellido').text(apellido);
        $('#modalRecordCorreo').text(correo);

        $('body').on('click', '#confirmar', function () {
            $.get('/destroy/' + id, function () {
                location.reload();
            });
        });

    });
});

/*$('body').on('click', '#btnmodificar', function () {
    var customer_id = $(this).data('id');
    let obj = null;

    $.get('edit/' + customer_id, function (data) {
        obj = data;


        $("#form-edit input[name='nombress']").val(obj.nombres);
        $("#form-edit input[name='apellidos']").val(obj.apellidos);
        $("#form-edit input[name='correo']").val(obj.apellido);

        // $("#form-edit input[name='apellidos']").val(obj.apellido);
    });

});*/