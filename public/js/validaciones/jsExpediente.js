$(document).ready(function () {

    $("#btnCancelar").click(function () {
        window.location.href = '/expediente'
    });

     //Si presiona eliminar abrira el modal con los datos que se daran de baja
     $('#exampleModalToggle').on('show.bs.modal', function (event) {
         var button = $(event.relatedTarget); // Botón que desencadenó el modal
        
         var id = button.data('expediente').idExpediente; // Obtiene el valor del atributo data-id
         var Animal = button.data('expediente').Animal.nombre; // Obtiene el valor del atributo data-apellido
         var alvergue = button.data('expediente').alvergue.idlvergue; // Obtiene el valor del atributo data-nombre
         var fechaIngreso = button.data('expediente').fechaIngreso; // Obtiene el valor del atributo data-apellido
         var estadoGeneral = button.data('expediente').estadoGeneral; // Obtiene el valor del atributo data-apellido
         var estado = button.data('expediente').estado; // Obtiene el valor del atributo data-apellido
        
         // Actualiza el contenido del modal con los detalles del registro
         $('#modalRecordCodigo').text(id);
         $('#modalRecordAnimal').text(Animal);
         $('#modalRecordAlvergue').text(alvergue);
         $('#modalRecordCFechaIngreso').text(fechaIngreso);
         $('#modalRecordEstadoGeneral').text(estadoGeneral);
         $('#modalRecordEstado').text(estado);

       
 
         $('body').on('click', '#confirmar', function () {
             $.get('/expediente/destroy/'+ id, function () {
                 // location.reload();
                 window.location.href = '/expediente'
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
        var id = button.data('expediente').idExpediente; // Obtiene el valor del atributo data-id
        var animal = button.data('expediente').idAnimal;
        var alvergue = button.data('expediente').idAlvergue; // Obtiene el valor del atributo data-nombre
        //var especie = button.data('raza').especie.especie; // Obtiene el valor del atributo data-apellido
        $('#codigo').text(id);
    $('#animal').text(animal);
    $('#alvergue').text(alvergue);

    // Abre el modal
    $('#modalDetalle').modal('show');
    });


    //Si presiona El daar de baja abrira el modal con los datos que se daran de baja
    $('#modaldeBaja').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que desencadenó el modal
       
        var id = button.data('expediente').idExpediente; // Obtiene el valor del atributo data-id
        var Animal = button.data('expediente').Animal.nombre; // Obtiene el valor del atributo data-apellido
       // var alvergue = button.data('expediente').alvergue.idlvergue; // Obtiene el valor del atributo data-nombre
        //var fechaIngreso = button.data('expediente').fechaIngreso; // Obtiene el valor del atributo data-apellido
        //var estadoGeneral = button.data('expediente').estadoGeneral; // Obtiene el valor del atributo data-apellido
       //var estado = button.data('expediente').estado; // Obtiene el valor del atributo data-apellido
       
        // Actualiza el contenido del modal con los detalles del registro
        $('#modalRecordCodigo').text(id);
        $('#modalRecordAnimal').text(Animal);
       // $('#modalRecordAlvergue').text(alvergue);
       // $('#modalRecordCFechaIngreso').text(fechaIngreso);
       // $('#modalRecordEstadoGeneral').text(estadoGeneral);
      //  $('#modalRecordEstado').text(estado);

      

        $('body').on('click', '#confirmar', function () {
            $.get('/expediente/destroy/'+ id, function () {
                // location.reload();
                window.location.href = '/expediente'
            });
        });

   });
});