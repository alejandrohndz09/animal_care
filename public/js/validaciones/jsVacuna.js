$('#modalEliminacion').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Botón que desencadenó el modal

     var id = button.data('vacuna').idVacuna; // Obtiene el valor del atributo data-id
     var vacuna = button.data('vacuna').vacuna; // Obtiene el valor del atributo data-nombre
      console.log(id);
      // Actualiza el contenido del modal con los detalles del registro
      $('#vacuna').text(vacuna);

      $('body').on('click', '#confirmar', function () {
        $.get('vacuna/destroy/'+ id, function () {
            // location.reload();
            window.location.href = '/vacuna'
        });
    });
    
    });

    
$("#btnCancelar").click(function () {
    window.location.href = '/vacuna'
});

$(".btnDelete").click(function (event) {
    // Evitar la propagación del evento al hacer clic en la fila
    event.stopPropagation();
});
$(".btnUpdate").click(function (event) {
    // Evitar la propagación del evento al hacer clic en la fila
    event.stopPropagation();
});

$('.vacuna-row').on('click', function (event) {
    // Verifica si el clic fue en un botón dentro de la fila
    if ($(event.target).is('.btnUpdate, .btnDelete')) {
        return; // Evita abrir el modal si se hizo clic en un botón
    }

    var button = $(this); // Fila de la tabla que se hizo clic
    var id = button.data('vacuna').idVacuna; // Obtiene el valor del atributo data-id
    var vacuna = button.data('vacuna').vacuna; // Obtiene el valor del atributo data-nombre
  
    // Actualiza el contenido del modal con los detalles del registro
    $('#codigo').text(id);
    $('#v').text(vacuna);

    // Abre el modal
    $('#ModalDetalle').modal('show');
});

document.querySelector('.floating-button').addEventListener('click', function () {
    $('#ayudaV').modal('show');
    });