$(document).ready(function () {

    $("#btnCancelar").click(function () {
        window.location.href = '/inventario/categorias/'
    });

    //Si presiona eliminar abrira el modal con los datos que se daran de baja
    $('#exampleModalToggle').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que desencadenó el modal

        var id = button.data('categoria').idCategoria; // Obtiene el valor del atributo data-id
        var nombre = button.data('categoria').categoria; // Obtiene el valor del atributo data-nombre

        // Actualiza el contenido del modal con los detalles del registro
        $('#modalRecordCodigo').text(id);
        $('#modalRecordNombre').text(nombre);


        $('body').on('click', '#confirmar', function () {
            window.location.href = '/inventario/categorias/destroy/' + id
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

$('.categoria-row').on('click', function (event) {
    // Verifica si el clic fue en un botón dentro de la fila
    if ($(event.target).is('.btnUpdate, .btnDelete')) {
        return; // Evita abrir el modal si se hizo clic en un botón
    }

    var button = $(this); // Fila de la tabla que se hizo clic
    var id = button.data('categoria').idCategoria; // Obtiene el valor del atributo data-id
    var nombre = button.data('categoria').categoria; // Obtiene el valor del atributo data-nombre
    //var especie = button.data('categoria').especie.especie; // Obtiene el valor del atributo data-apellido

    // Actualiza el contenido del modal con los detalles del registro
    $('#Codigo').text(id);
    $('#Raza').text(nombre);


    // Abre el modal
    $('#modalDetalle').modal('show');
});



