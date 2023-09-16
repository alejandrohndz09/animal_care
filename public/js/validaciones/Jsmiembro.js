
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
                       <input class="inputField form-control telefono"  
                          value="+503 " name="telefono`+ con + `" type="text" oninput="validarInput(this)">
                           <small  style="color:red" class="error-message"></small>
                  </div>
                </div>
             <div class="col-xl-6">
                  <button type="button" class="btn btn-danger remove-telefono"
                  data-bs-toggle="modal" >
                   <i class="svg-icon fas fa-circle-xmark"></i>
                  </button>
            </div>
        </div>
        `;
            $("#telefono-container").append(newTelefonoField);
        }

    });

    $("#telefono-container").on("click", ".remove-telefono", function () {
        var telefonoId = $(this).data("telefono-id");

        var elemento = document.getElementById('telefono-container');
        var objeto = JSON.parse(elemento.getAttribute('data-objeto'));

        if (objeto) {
            $.ajax({
                url: "/destroyTelefono/" + telefonoId,
                method: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    // Eliminar el elemento del DOM si la eliminación en la base de datos fue exitosa
                    $(this).closest("#remove").remove();
                    var contador = $("#con");
                    var con = parseInt(contador.val());
                    con = con - 1;
                    contador.val(con);
                    alert(response.message);
                },
                error: function (xhr, status, error) {
                    //console.error(error);
                    console.log(error);
                    alert("Ocurrió un error al eliminar el teléfono." + xhr.responseText);
                }
            });

        }

        // Si no se cumple la condición, eliminar el campo de teléfono
        $(this).closest("#remove").remove();
        var contador = $("#con");
        var con = parseInt(contador.val());

        con = con - 1; // decrementa el valor de 'con' en 1
        contador.val(con); // Actualiza el valor en el campo de entrada

    });

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
