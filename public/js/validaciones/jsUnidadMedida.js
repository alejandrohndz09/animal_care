$(document).ready(function () {

    $("#btnCancelar").click(function () {
        window.location.href = '/inventario/unidadMedidas/'
    });

     //Si presiona eliminar abrira el modal con los datos que se daran de baja
     $('#exampleModalToggle').on('show.bs.modal', function (event) {
         var button = $(event.relatedTarget); // Botón que desencadenó el modal
        
         var id = button.data('unidadmedida').idUnidadMedida; // Obtiene el valor del atributo data-id
         var nombre = button.data('unidadmedida').unidadMedida; // Obtiene el valor del atributo data-nombre
         var simbolo = button.data('unidadmedida').simbolo;
         // Actualiza el contenido del modal con los detalles del registro
         $('#modalRecordCodigo').text(id);
         $('#modalRecordNombre').text(`${nombre} (${simbolo})`);
       
 
         $('body').on('click', '#confirmar', function () {
             window.location.href = '/inventario/unidadMedidas/destroy/' + id;
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

$('.unidadMedida-row').on('click', function (event) {
    // Verifica si el clic fue en un botón dentro de la fila
    if ($(event.target).is('.btnUpdate, .btnDelete')) {
        return; // Evita abrir el modal si se hizo clic en un botón
    }

    var button = $(this); // Fila de la tabla que se hizo clic
    var id = button.data('unidadmedida').idUnidadMedida; // Obtiene el valor del atributo data-id
    var nombre = button.data('unidadmedida').unidadMedida; // Obtiene el valor del atributo data-nombre
    var simbolo = button.data('unidadmedida').simbolo;
    // Actualiza el contenido del modal con los detalles del registro
    $('#Codigo').text(id);
    $('#Raza').text(`${nombre} (${simbolo})`);
    

    // Abre el modal
    $('#modalDetalle').modal('show');
});



