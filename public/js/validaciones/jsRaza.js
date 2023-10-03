$(document).ready(function () {

    $("#btnCancelar").click(function () {
        window.location.href = '/raza'
    });

     //Si presiona eliminar abrira el modal con los datos que se daran de baja
     $('#exampleModalToggle').on('show.bs.modal', function (event) {
         var button = $(event.relatedTarget); // Botón que desencadenó el modal
         // Botón que desencadenó el modal
         var id = button.data('raza').idRaza; // Obtiene el valor del atributo data-id
         var nombre = button.data('raza').raza; // Obtiene el valor del atributo data-nombre
         var especie = button.data('raza').especie.especie; // Obtiene el valor del atributo data-apellido
        
         // Actualiza el contenido del modal con los detalles del registro
         $('#modalRecordCodigo').text(id);
         $('#modalRecordNombre').text(nombre);
         $('#modalRecordEspecie').text(especie);
       
 
         $('body').on('click', '#confirmar', function () {
             $.get('/raza/destroy/'+ id, function () {
                 // location.reload();
                 window.location.href = '/raza'
             });
         });

    });
});


