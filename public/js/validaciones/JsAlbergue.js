
$(document).ready(function () {

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
                    console.log(xhr.responseText);
                    alert("Error al eliminar el albergue: " + xhr.responseText);
                }
            });
        });

    });

    $("#btnCancelar").click(function () {
        window.location.href = '/albergue'
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
    $('.registro-row').on('click', function (event) {
        // Verifica si el clic se realizó en un botón de editar o eliminar

        if ($(event.target).is('a#btnUpdate') || $(event.target).is('a#btnDelete')) {
            console.log('Presiono aqui en los botones');
            return; // No muestres el modal si se hizo clic en un botón
        } else {
            var id = $(this).find('[data-id]').data('id');
            window.location.href = '/albergue/' + id;
        }
    });

});

$(document).ready(function () {
    //Habilitar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-pp="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});