$(document).ready(function () {

    $("#btnCancelar").click(function () {
        window.location.href = '/expediente'
    });

    //Si presiona eliminar abrira el modal con los datos que se daran de baja
    $('#modalEliminar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que desencadenó el modal

        var id = button.data('file').idExpediente; // Obtiene el valor del atributo data-id
        var nombre = button.data('file').animal.nombre; // Obtiene el valor del atributo data-nombre
        var raza = button.data('file').animal.raza.raza; // Obtiene el valor del atributo data-apellido
        var especie = button.data('file').animal.raza.especie.especie; // Obtiene el valor del atributo data-apellido

        // Actualiza el contenido del modal con los detalles del registro
        $('#codigo').text(id);
        $('#nombre').text(nombre);
        $('#raza').text(raza);
        $('#especie').text(especie);

        $('body').on('click', '#confirmar', function () {
            $.get('/expediente/destroy/' + id, function () {
                // location.reload();
                window.location.href = '/raza'
            });
        });

    });
});

$(".btnDelete").click(function (event) {
    // Evitar la propagación del evento al hacer clic en la fila
    event.stopPropagation();
});
$(".btnUpdate").click(function (event) {
    // Evitar la propagación del evento al hacer clic en la fila
    event.stopPropagation();
});

$('.expediente-row').on('click', function (event) {
    // Verifica si el clic fue en un botón dentro de la fila
    if ($(event.target).is('.btnUpdate, .btnDelete')) {
        return; // Evita abrir el modal si se hizo clic en un botón
    }

    var button = $(this); // Fila de la tabla que se hizo clic
    var id = button.data('raza').idRaza; // Obtiene el valor del atributo data-id
    var nombre = button.data('raza').raza; // Obtiene el valor del atributo data-nombre
    //var especie = button.data('raza').especie.especie; // Obtiene el valor del atributo data-apellido

    // Actualiza el contenido del modal con los detalles del registro
    $('#codigo').text(id);
    $('#Raza').text(nombre);
    $('#Especie').text(especie);

    // Abre el modal
    $('#modalDetalle').modal('show');
});



