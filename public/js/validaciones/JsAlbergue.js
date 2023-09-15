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
