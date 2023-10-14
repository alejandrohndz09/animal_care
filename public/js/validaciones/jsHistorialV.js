$(document).ready(function () {
    $('#formulario #vacuna-error').html('');
    $('#formulario #dosis-error').html('');
    $('#formulario #fechaAplicacion-error').html('');

    $('#btnGuardar').click(function () {
        // Borra todas las advertencias de errores existentes
        $('#formulario #vacuna-error').html('');
        $('#formulario #dosis-error').html('');
        $('#formulario #fechaAplicacion-error').html('');

        // Serializa los datos del formulario
        var formData = $('#formulario').serialize();

        // Obtén el token CSRF
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Realiza la solicitud AJAX para validar los campos
        $.ajax({
            type: 'POST',
            url: '/historialVacunas/store',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken // Agrega el token CSRF al encabezado
            },
            success: function (data) {
                $('#newHistorial').modal('hide');

                // Si la validación se completó con éxito
                if (data.success) {
                    // Puedes redirigir o hacer lo que necesites aquí
                    window.location.href = '/expediente';
                    location.reload();
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Maneja errores de validación
                    var errors = xhr.responseJSON.errors;

                    // Itera a través de los campos del formulario
                    $('#formulario input, #formulario select').each(function () {
                        var campo = $(this).attr('name');
                        if (errors[campo]) {
                            // Muestra el error debajo del campo correspondiente
                            $('#' + campo + '-error').html(errors[campo]);
                        }
                    });
                } else {
                    // Maneja otros errores, si es necesario
                    console.log(xhr);
                }
            }
        });
    });

    // Evento de clic para el botón "Cancelar"
    $('#mostrar').click(function () {
        // Borra todas las advertencias de errores cuando se presiona "Cancelar"
        $('#formulario #vacuna-error').html('');
        $('#formulario #dosis-error').html('');
        $('#formulario #fechaAplicacion-error').html('');
    });


    $('.historialv-row').on('click', function (event) {
        // Verifica si el clic fue en un botón dentro de la fila
        if ($(event.target).is('.btnUpdate, .btnDelete')) {
            return; // Evita abrir el modal si se hizo clic en un botón
        }

        var button = $(this); // Fila de la tabla que se hizo clic
        // var id = button.data('historialesAgrupados').idHistVacuna; // Obtiene el valor del atributo data-id
         console.log(button.data('vacuna'));

        // Actualiza el contenido del modal con los detalles del registro
        // $('#codigo').text(id);
        // $('#patologia').text(patologia);

        // // Abre el modal
        // $('#modalDetalle').modal('show');
    });

});
