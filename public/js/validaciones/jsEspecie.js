$('#exampleModalToggle').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Botón que desencadenó el modal
     // Botón que desencadenó el modal
     var id = button.data('id'); // Obtiene el valor del atributo data-id
     var especie = button.data('especie'); // Obtiene el valor del atributo data-nombre
      console.log(id);
      // Actualiza el contenido del modal con los detalles del registro
      $('#modalRecordCodigo').text(id);
      $('#modalRecordeEspecie').text(especie);

      $('body').on('click', '#confirmar', function () {
        $.get('especie/destroy/'+ id, function () {
            // location.reload();
            window.location.href = '/especie'
        });
    });
    
    });

    
$("#btnCancelar").click(function () {
    window.location.href = '/especie'
});