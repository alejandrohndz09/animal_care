$(document).ready(function () {
    //Habilitar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-pp="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    // Captura el valor anterior de "unidad" (puedes obtenerlo de old('unidad') o de otra fuente)
    var categoriaId = $('#categoria').val();
    $.ajax({
        url: '/obtener-unidades/' + categoriaId,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // Limpia y llena el campo de unidad con las nuevas opciones
            $('#unidad').empty();
            $('#unidad').append($('<option>', {
                value: '',
                text: 'Selecciona una unidad'
            }));
            $.each(data, function (key, value) {
                var option = $('<option>', {
                    value: value.idUnidadMedida,
                    text: value.unidadMedida
                });

                // Verifica si la opción coincide con la que estaba seleccionada anteriormente
                if (value.idUnidadMedida == $('#unidad').data('selected')) {
                    option.attr('selected', 'selected');
                }

                $('#unidad').append(option);
            });
        }
    });


    // Captura el cambio en el campo de categoria
    $('#categoria').change(function () {
        var categoriaId = $(this).val();

        // Realiza una solicitud AJAX para obtener las unidads relacionadas
        $.ajax({
            url: '/obtener-unidades/' + categoriaId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Limpia y llena el campo de unidad con las nuevas opciones
                $('#unidad').empty();
                $('#unidad').append($('<option>', {
                    value: '',
                    text: 'Seleccione una unidad'
                }));
                $.each(data, function (key, value) {
                    $('#unidad').append($('<option>', {
                        value: value.idUnidadMedida,
                        text: value.unidadMedida
                    }));
                });
            }
        });
    });
    $("#btnCancelar").click(function () {
        window.location.href = '/inventario/recursos'
    });

    //Si presiona eliminar abrira el modal con los datos que se daran de baja
    $('#exampleModalToggle').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que desencadenó el modal
        // Botón que desencadenó el modal
        var idN = button.data('recurso').idRecurso; // Obtiene el valor del atributo data-id
        var nombre = button.data('recurso').recurso; // Obtiene el valor del atributo data-nombre
        var categoria = button.data('recurso').categoria.categoria;
        // // Actualiza el contenido del modal con los detalles del registro
        $('#Codigo').text(idN);
        $('#Nombre').text(nombre);
        $('#Categoria').text(categoria);



        $('body').on('click', '#confirmar', function () {
            window.location.href = '/inventario/recursos/destroy/' + idN
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

// Escuchar el click en una fila

$('#tableBody').on('click', '.recurso-row', function (event) {
    console.log('si entra al evento')

    // Verifica si el clic se realizó en un botón de editar o eliminar
    if ($(event.target).is('.btnUpdate, .btnDelete')) {
        return; // Evita abrir el modal si se hizo clic en un botón
    } else {
        var RecursoData = $(this).data('recurso');
        var idRecurso = RecursoData.idRecurso;
        window.location.href = '/inventario/recursos/' + idRecurso;
    }
});


// Agregar un evento de clic al botón flotante de ayuda para abrir el modal
document.querySelector('.floating-button').addEventListener('click', function () {
   $('#ayudaRecursos').modal('show');
   });
