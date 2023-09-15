$('#exampleModalToggle').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Botón que desencadenó el modal
    var id = button.data('id'); // Obtiene el valor del atributo data-id
    var nombre = button.data('nombre'); // Obtiene el valor del atributo data-nombre
    var apellido = button.data('apellido'); // Obtiene el valor del atributo data-apellido
    var direccion = button.data('direccion'); // Obtiene el valor del atributo data-correo

    // Actualiza el contenido del modal con los detalles del registro
    $('#modalRecordId').text(id);
    $('#modalRecordNombre').text(nombre);
    $('#modalRecordApellido').text(apellido);
    $('#modalRecorddireccion').text(direccion);

    $('body').on('click', '#confirmar', function () {
        $.ajax({
            url: "/destroyAlbergue/" + id,
            method: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                // Eliminar el elemento del DOM si la eliminación en la base de datos fue exitosa
                location.reload();
                alert(response.message);
            },
            error: function (xhr, status, error) {
                //console.error(error);
                console.log( xhr.responseText);
                alert("Error al eliminar el albergue: " + xhr.responseText);
            }
        });
    });

});