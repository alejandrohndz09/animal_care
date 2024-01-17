
$(document).ready(function () {
    //Habilitar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-pp="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    //Si presiona eliminar abrira el modal con los datos que se daran de baja
    $('#modalDetalle').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que desencadenó el modal
        var id = button.data('id'); // Obtiene el valor del atributo data-id
        var nombre = button.data('nombre'); // Obtiene el valor del atributo data-nombre
        var apellido = button.data('apellido'); // Obtiene el valor del atributo data-apellido
        var direccion = button.data('direccion'); // Obtiene el valor del atributo data-correo

        // Actualiza el contenido del modal con los detalles del registro
        $('#modalRecordId').text(id);
        $('#modalRecordNombre').text(nombre);
        $('#modalRecordApellido').text(apellido);
        $('#modalRecorddireccion').text(direccion);

        $('body').on('click', '#confirmar', function () {
            $.get('/destroyAlbergue/' + id, function () {
                // location.reload();
                window.location.href = '/albergue'
            });
        });

    });

    


    $("#btnCancelar").click(function () {
        window.location.href = '/albergue'
    });

    $(".btnDelete").click(function (event) {
        // Evitar la propagación del evento al hacer clic en la fila
        event.stopPropagation();
    });
    $(".btnUpdate").click(function (event) {
        // Evitar la propagación del evento al hacer clic en la fila
        event.stopPropagation();
    });

    // Escuchar el click en una fila
    $('#tableBody').on('click', '.registro-row', function (event) {
        // //     // Verifica si el clic se realizó en un botón de editar o eliminar

        if ($(event.target).is('#btnUpdate') || $(event.target).is('a#btnDelete')) {
           
            return; // No muestres el modal si se hizo clic en un botón
        } else {
            var id = $(this).find('[data-id]').data('id');
            window.location.href = '/albergue/' + id;
        }
    });


      //Si presiona El dar de baja abrira el modal con los datos que se daran de baja
      $('#modaldeBaja').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que desencadenó el modal
       
        var idExpediente = button.data('expediente').idExpediente; // Obtiene el valor del atributo data-id
        var idAlvergue = button.data('expediente').idAlvergue;
        var Animal = button.data('expediente').animal.nombre; // Obtiene el valor del atribut
        // Actualiza el contenido del modal con los detalles del registro
        $('#modalRecordi').text(idExpediente);
        $('#modalRecordAni').text(Animal);
    
      
    
        $('body').on('click', '#confirmarOperacion', function () {
            $.get('/desalbergar/'+ idExpediente + '/'+ idAlvergue, function () {
                 location.reload();
      //          window.location.href = '/expediente'
            });
        });
    
    });
});