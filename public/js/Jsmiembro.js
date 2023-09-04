function formatPhoneNumber(input) {
    var value = input.value; // Obtener el valor actual

    // Si no comienza con el código de país, agrégalo
    if (!value.startsWith("+503 ")) {
        value = "+503 " + value;
    }

    // Insertar el guion después del código de país si no existe
    if (value.length >= 10 && value.charAt(9) !== '-') {
        value = value.substring(0, 9) + '-' + value.substring(9);
    }

    input.value = value; // Actualizar el valor del campo
}

$(document).ready(function () {
    $("#add-telefono").click(function () {
        var telefonoInput = $(".telefono:last"); // Obtener el último campo de teléfono agregado
        var telefonoValue = telefonoInput.val() // Obtener el valor del último campo y quitar espacios en blanco


        // Validar si el campo está vacío
        if (telefonoValue == "+503 ") {
            alert("El campo de teléfono no puede estar vacío.");
            return; // Detener la función si el campo está vacío
        }
        // Validar si el campo no tiene al menos 10 caracteres
        else if (telefonoValue.length < 13) {
            alert("El número de teléfono ingresado no es valido.");
            return; // Detener la función si el campo no es válido
        }
        else {

            var contador = $("#contador");
            var con = parseInt(contador.val(), 10); // El segundo argumento (10) es la base numérica, que es 10 para números decimales.

            con++; // Incrementa el valor en 1
            contador.val(con); // Actualiza el valor en el campo de entrada

            // Si pasa ambas validaciones, puedes agregar el nuevo campo de teléfono
            var newTelefonoField = `
            <div id="remove">
               <div class="col-xl-6">
                  <div class="inputContainer">
                       <input class="inputField form-control telefono" type="tel" 
                          value="+503 " name="telefono`+ con + `" oninput="formatPhoneNumber(this)"
                           onkeydown="return restrictToNumbersAndHyphen(event)">
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


    // Restringir caracteres solo para campos de teléfono
    $(".telefono").on("keydown", function (event) {
        return restrictToNumbersAndHyphen(event);
    });

    $("form").submit(function (event) {
        var inputs = $(this).find("input"); // Obtener todos los campos de entrada en el formulario

        // Iterar a través de los campos de entrada
        for (var i = 0; i < inputs.length; i++) {
            var inputValue = inputs[i].value.trim();
            if (inputValue === "") {
                event.preventDefault(); // Detener el envío del formulario
                alert("Ninguno de los campos puede estar vacío.");
                return;
            }
        }
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