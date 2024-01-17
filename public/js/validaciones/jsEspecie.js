$('#modalEliminar').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Botón que desencadenó el modal

     var id = button.data('especie').idEspecie; // Obtiene el valor del atributo data-id
     var especie = button.data('especie').especie; // Obtiene el valor del atributo data-nombre

      // Actualiza el contenido del modal con los detalles del registro
      $('#especie').text(especie);

      $('body').on('click', '#confirmar', function () {
        $.get('/especie/destroy/'+ id, function () {
            // location.reload();
            window.location.href = '/especie'
        });
    });
    
    });
    
$("#btnCancelar").click(function () {
    window.location.href = '/especie'
});

$(".btnDelete").click(function (event) {
    // Evitar la propagación del evento al hacer clic en la fila
    event.stopPropagation();
});
$(".btnUpdate").click(function (event) {
    // Evitar la propagación del evento al hacer clic en la fila
    event.stopPropagation();
});
$('.especie-row').on('click', function (event) {
    // Verifica si el clic fue en un botón dentro de la fila
    if ($(event.target).is('.btnUpdate, .btnDelete')) {
        return; // Evita abrir el modal si se hizo clic en un botón
    }

    var button = $(this); // Fila de la tabla que se hizo clic
    var id = button.data('especie').idEspecie; // Obtiene el valor del atributo data-id
    var especie = button.data('especie').especie; // Obtiene el valor del atributo data-especie

    // Actualiza el contenido del modal con los detalles del registro
    $('#modalCodigo').text(id);
    $('#modalEspecie').text(especie);

    // Abre el modal
    $('#ModalDetalle').modal('show');
});
 // Agregar un evento de clic al botón flotante de ayuda para abrir el modal
 document.querySelector('.floating-button').addEventListener('click', function () {
    $('#ayudaEspecie').modal('show');
    });
