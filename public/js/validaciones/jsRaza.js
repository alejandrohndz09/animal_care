$(document).ready(function () {
   // Captura el valor anterior de "raza" (puedes obtenerlo de old('raza') o de otra fuente)
    var especieId = $('#especie').val();
    $.ajax({
        url: '/obtener-razas/' + especieId,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // Limpia y llena el campo de raza con las nuevas opciones
            $('#raza').empty();
            $('#raza').append($('<option>', {
                value: '',
                text: 'Selecciona una raza'
            }));
            $.each(data, function (key, value) {
                var option = $('<option>', {
                    value: value.idRaza,
                    text: value.raza
                });

                // Verifica si la opción coincide con la que estaba seleccionada anteriormente
                if (value.idRaza == $('#raza').data('selected')) {
                    option.attr('selected', 'selected');
                }

                $('#raza').append(option);
            });
        }
    });


    // Captura el cambio en el campo de especie
    $('#especie').change(function () {
        var especieId = $(this).val();

        // Realiza una solicitud AJAX para obtener las razas relacionadas
        $.ajax({
            url: '/obtener-razas/' + especieId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Limpia y llena el campo de raza con las nuevas opciones
                $('#raza').empty();
                $('#raza').append($('<option>', {
                    value: '',
                    text: 'Selecciona una raza'
                }));
                $.each(data, function (key, value) {
                    $('#raza').append($('<option>', {
                        value: value.idRaza,
                        text: value.raza
                    }));
                });
            }
        });
    });
    $("#btnCancelar").click(function () {
        window.location.href = '/raza'
    });

     //Si presiona eliminar abrira el modal con los datos que se daran de baja
     $('#exampleModalToggle').on('show.bs.modal', function (event) {
         var button = $(event.relatedTarget); // Botón que desencadenó el modal
         // Botón que desencadenó el modal
         var id = button.data('raza').idAnimal; // Obtiene el valor del atributo data-id
         var nombre = button.data('raza').nombre; // Obtiene el valor del atributo data-nombre
         var especie = button.data('raza').raza.especie.especie; // Obtiene el valor del atributo data-apellido
         var raza = button.data('raza').raza.raza; // Obtiene el valor del atributo data-correo
         var imagen  = button.data('raza').imagen;
         // Actualiza el contenido del modal con los detalles del registro
         $('#modalRecordCodigo').text(id);
         $('#modalRecordNombre').text(nombre);
         $('#modalRecordEspecie').text(especie);
         $('#modalRecordRaza').text(raza);
         if (imagen != null) {
             document.getElementById("imagenModal").src = imagen;
         } else {
            document.getElementById("imagenModal").src = 'https://static.vecteezy.com/system/resources/previews/017/783/245/original/pet-shop-silhouette-logo-template-free-vector.jpg';
         }
 
         $('body').on('click', '#confirmar', function () {
             $.get('{{url(raza/'+ id+'/destroy)}}', function () {
                 // location.reload();
                 window.location.href = '/raza'
             });
         });

    });
});


