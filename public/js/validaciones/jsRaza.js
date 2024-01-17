$(document).ready(function () {

    $("#btnCancelar").click(function () {
        window.location.href = '/raza'
    });

    //Si presiona eliminar abrira el modal con los datos que se daran de baja
    $('#exampleModalToggle').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que desencadenó el modal

        var id = button.data('raza').idRaza; // Obtiene el valor del atributo data-id
        var nombre = button.data('raza').raza; // Obtiene el valor del atributo data-nombre
        var especie = button.data('raza').especie.especie; // Obtiene el valor del atributo data-apellido

        // Actualiza el contenido del modal con los detalles del registro
        $('#modalRecordCodigo').text(id);
        $('#modalRecordNombre').text(nombre);
        $('#modalRecordEspecie').text(especie);


        $('body').on('click', '#confirmar', function () {
            $.get('/raza/destroy/' + id, function () {
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

$('.raza-row').on('click', function (event) {
    // Verifica si el clic fue en un botón dentro de la fila
    if ($(event.target).is('.btnUpdate, .btnDelete')) {
        return; // Evita abrir el modal si se hizo clic en un botón
    }

    var button = $(this); // Fila de la tabla que se hizo clic
    var id = button.data('raza').idRaza; // Obtiene el valor del atributo data-id
    var nombre = button.data('raza').raza; // Obtiene el valor del atributo data-nombre
    var especie = button.data('especie'); // Obtiene el valor del atributo data-apellido
   
    // Actualiza el contenido del modal con los detalles del registro
    $('#Codigo').text(id);
    $('#Raza').text(nombre);
    $('#Especie').text(especie);

    // Abre el modal
    $('#modalDetalle').modal('show');
});

// Agregar un evento de clic al botón flotante de ayuda para abrir el modal
document.querySelector('.floating-button').addEventListener('click', function () {
   $('#ayudaRaza').modal('show');
  });



