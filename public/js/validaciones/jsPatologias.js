$('#modalEliminar').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Botón que desencadenó el modal

    var id = button.data('patologia').idPatologia; // Obtiene el valor del atributo data-id
    var patologia = button.data('patologia').patologia; // Obtiene el valor del atributo data-nombre

    // Actualiza el contenido del modal con los detalles del registro
    $('#patologia').text(patologia);

    $('body').on('click', '#confirmar', function () {
        $.get('/destroyPatologia/' + id, function () {
            // location.reload();
            window.location.href = '/patologia'
        });
    });


});

$("#btnCancelar").click(function () {
    window.location.href = '/patologia'
});

$(".btnDelete").click(function (event) {
    // Evitar la propagación del evento al hacer clic en la fila
    event.stopPropagation();
});
$(".btnUpdate").click(function (event) {
    // Evitar la propagación del evento al hacer clic en la fila
    event.stopPropagation();
});

$('.patologia-row').on('click', function (event) {
    // Verifica si el clic fue en un botón dentro de la fila
    if ($(event.target).is('.btnUpdate, .btnDelete')) {
        return; // Evita abrir el modal si se hizo clic en un botón
    }

    var button = $(this); // Fila de la tabla que se hizo clic
    var id = button.data('patologia').idPatologia; // Obtiene el valor del atributo data-id
    var patologia = button.data('patologia').patologia; // Obtiene el valor del atributo data-nombre
   
    // Actualiza el contenido del modal con los detalles del registro
    $('#codigo').text(id);
    $('#patologia').text(patologia);

    // Abre el modal
    $('#modalDetalle').modal('show');
});
