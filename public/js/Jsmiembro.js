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
        var telefonoValue = telefonoInput.val(); // Obtener el valor y eliminar espacios en blanco

        // Validar si el campo está vacío antes de agregar un nuevo campo
        if (telefonoValue === "+503 ") {
            alert("El campo de teléfono no puede estar vacío.");
            return; // Detener la función si el campo está vacío
        } else {
            var newTelefonoField = `
                <div id="flavio">
                   <div class="col-xl-6">
                      <div class="inputContainer">
                           <input class="inputField form-control telefono" type="tel" maxlength="18"
                              value="+503 " name="telefonos[]" oninput="formatPhoneNumber(this)"
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
    });

    // Remover campos agregados dinámicamente
    $("#telefono-container").on("click", ".remove-telefono", function () {
        $(this).closest("#flavio").remove();
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
