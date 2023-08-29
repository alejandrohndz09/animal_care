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
        var newTelefonoField = `
        <div id="flavio">
           <div class="col-xl-6">
              <div class="inputContainer">
                   <input class="inputField form-control telefono" type="tel" maxlength="18"
                      value="+503 " name="telefonos[]" oninput="formatPhoneNumber(this)"
                       onkeydown="return restrictToNumbersAndHyphen(event)">
              </div>
            </div>
         <div class="col-xl-6">
              <button type="button" class="btn btn-danger remove-telefono">
               <i class="svg-icon fas fa-circle-xmark"></i>
              </button>
        </div>
     </div>
     </div>
                `;
        $("#telefono-container").append(newTelefonoField);
    });

    // Remover campos agregados dinámicamente
    $("#telefono-container").on("click", ".remove-telefono", function () {
        $(this).closest("#flavio").remove();
    });
});

function restrictToNumbersAndHyphen(event) {
    var charCode = event.which ? event.which : event.keyCode;

    // Permitir números, el guion y las teclas de borrar
    if (charCode !== 45 && (charCode < 48 || charCode > 57) && charCode !== 8 && charCode !== 46) {
        event.preventDefault();
        return false;
    }

    return true;
}
