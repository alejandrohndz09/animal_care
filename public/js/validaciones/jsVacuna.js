$('#exampleModalToggle').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Botón que desencadenó el modal
     // Botón que desencadenó el modal
     var id = button.data('id'); // Obtiene el valor del atributo data-id
     var vacuna = button.data('vacuna'); // Obtiene el valor del atributo data-nombre
      console.log(id);
      // Actualiza el contenido del modal con los detalles del registro
      $('#modalRecordCodigo').text(id);
      $('#modalRecordeVacuna').text(vacuna);

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