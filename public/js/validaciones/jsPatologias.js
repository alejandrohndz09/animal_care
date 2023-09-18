$('#exampleModalToggle').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Botón que desencadenó el modal
    // Botón que desencadenó el modal
    var id = button.data('id'); // Obtiene el valor del atributo data-id
    var patologia = button.data('patologia'); // Obtiene el valor del atributo data-nombre
    console.log(id);
    // Actualiza el contenido del modal con los detalles del registro
    $('#modalRecordCodigo').text(id);
    $('#modalRecordePatologia').text(patologia);

    $('body').on('click', '#confirmar', function () {
        $.get('destroyPatologia/' + id, function () {
            // location.reload();
            window.location.href = '/patologia'
        });
    });


});

$("#btnCancelar").click(function () {
    window.location.href = '/patologia'
});