$(document).ready(function () {
    $('#btnGuardar').click(function () {

        // Borra todas las advertencias de errores existentes
        $('#formulario #vacuna-error').html('');
        $('#formulario #dosis-error').html('');
        $('#formulario #fechaAplicacion-error').html('');

        // Serializa los datos del formulario
        var formData = $('#formulario').serialize();

        // Realiza la solicitud AJAX para validar los campos
        $.ajax({
            type: 'POST',
            url: '/historialVacunas/store',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#newHistorial').modal('hide');
                window.location.reload();
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



    // Evento de clic para el botón "Agregar"
    $('#mostrar').click(function () {
        // Borra todas las advertencias de errores cuando se presiona "Cancelar"

        $('#formulario #vacuna-error').html('');
        $('#formulario #dosis-error').html('');
        $('#formulario #fechaAplicacion-error').html('');

        var campo1 = document.getElementById('fechaAplicacion');
        var campo2 = document.getElementById('dosis');

        // Limpia los valores de los campos de entrada
        campo1.value = '';
        campo2.value = '';

        document.getElementById('Texto').textContent = 'Nuevo Registro';
        document.getElementById('btn').textContent = 'Guardar';
        document.getElementById("operacion").value = "Agregar";

    });

    $('#btnCancelar').click(function () {

        // Borra todas las advertencias de errores cuando se presiona "Cancelar"
        $('#formulario #vacuna-error').html('');
        $('#formulario #dosis-error').html('');
        $('#formulario #fechaAplicacion-error').html('');

        if (document.getElementById("operacion").value == "modificar") {
            $('#detalleVacunaModal').modal('show');
        }

    });


    // Controlador de clic para abrir el modal
    $('#contenedorVacuna').on('click', '.historialv-row', function () {

        var button = $(this); // Fila de la tabla que se hizo clic
        var datos = button.data('vacuna'); // Obtiene el valor del atributo data-vacuna

        // Genera la tabla de detalles en el modal
        var tableBody = $('#detalleVacunaTableBody');
        tableBody.empty(); // Limpia cualquier contenido anterior

        var idExpediente = datos[0].idExpediente;
        var idVacuna = datos[0].idVacuna;

        $('#name').text(datos[0].vacuna.vacuna);

        // Itera sobre los datos en historiales
        $.each(datos, function (index, historial) {

            // Agrega una fila a la tabla
            var row = $('<tr>');
            row.append(`<td>${index + 1} </td>`);
            row.append('<td>' + historial.dosis + '</td>');
            row.append('<td>' + dateFormat(historial.fechaAplicacion) + '</td>');


            // Agrega un div que envuelve a los botones y aplica estilos
            var buttonDiv = $('<div style="display: flex; align-items: flex-end; gap: 5px; justify-content: center;">');
            var editButton = $('<button type="button" class="button button-blue"' +
                'data-bs-pp="tooltip" data-bs-placement="top" style="width: 45%;" title="Editar"> <i class="svg-icon fas fa-pencil"></i></button>');
            var deleteButton = $('<button type="button" class="button button-red delete-button" id="HistVacuna" style="width: 45%" value = "' + historial.idHistVacuna + '"' +
                'data-bs-pp="tooltip" data-bs-placement="top" title="Eliminar"> <i class="svg-icon fas fa-trash"></i></button>');



            editButton.on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/historialVacunas/' + historial.idHistVacuna + '/edit',
                    success: function (data) {

                        // Limpiar el select actual
                        $('#vacuna').empty();

                        // Datos del registro a modificar
                        var fechaAplicacion = data.fechaAplicacion;
                        var dosis = data.dosis;

                        // Solicitud AJAX para obtener todas las opciones para el select
                        $.ajax({
                            type: 'GET',
                            url: '/obtener-vacunas', // Debes definir la ruta correspondiente
                            success: function (opciones) {
                                // Limpiar el select actual
                                $('#vacuna').empty();

                                // Agregar una opción predeterminada (por ejemplo, "Seleccione...")
                                $('#vacuna').append($('<option>', {
                                    value: '',
                                    text: 'Seleccione...'
                                }));

                                // Agregar opciones al select
                                $.each(opciones, function (index, opcion) {
                                    $('#vacuna').append($('<option>', {
                                        value: opcion.idVacuna,
                                        text: opcion.vacuna
                                    }));
                                });


                                // Establecer el valor seleccionado en el select
                                $('#vacuna').val(data.idVacuna);

                                // Llenar otros campos
                                $('#fechaAplicacion').val(fechaAplicacion);
                                $('#dosis').val(dosis);

                                // Abrir el modal de edición
                                $('#detalleVacunaModal').modal('hide');

                                document.getElementById('Texto').textContent = 'Editar Registro';

                                document.getElementById('btn').textContent = 'Modificar';

                                document.getElementById("operacion").value = "modificar";

                                document.getElementById("idHistVacuna").value = data.idHistVacuna;

                                // Borra todas las advertencias de errores cuando se presiona "Cancelar"
                                $('#formulario #vacuna-error').html('');
                                $('#formulario #dosis-error').html('');
                                $('#formulario #fechaAplicacion-error').html('');


                                // Abrir el modal de edición
                                $('#newHistorial').modal('show');

                            }
                        });
                    },
                    error: function (xhr) {
                        // Maneja errores, si es necesario
                        console.log(xhr);
                    }
                });
            });

            deleteButton.on('click', function () {

                var idHistVacuna = $(this).attr('value');

                $.ajax({
                    type: 'DELETE',
                    url: '/destroyHistorialVacunas/' + idHistVacuna,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                })
                    .done(function () {
                        // Eliminación exitosa
                        // Ahora, solicita todos los registros relacionados con idVacuna
                        $.ajax({
                            type: 'GET',
                            url: '/cargarListaDatos/' + idVacuna
                        })
                            .done(function (data) {

                                tableBody.empty();
                                $.each(data, function (index, newData) {

                                    // Agrega una fila a la tabla
                                    var row = $('<tr>');
                                    row.append(`<td>${index + 1} </td>`);
                                    row.append('<td>' + newData.dosis + '</td>');
                                    row.append('<td>' + dateFormat(newData.fechaAplicacion) + '</td>');
                                    row.append('<td></td>');

                                    // Agrega un div que envuelve a los botones y aplica estilos
                                    var buttonDiv = $('<div style="display: flex; align-items: flex-end; gap: 5px; justify-content: center;">');
                                    var editButton = $('<button type="button" class="button button-blue"' +
                                        'data-bs-pp="tooltip" data-bs-placement="top" style="width: 45%;" title="Editar"> <i class="svg-icon fas fa-pencil"></i></button>');
                                    var deleteButton = $('<button type="button" class="button button-red  delete-button" style="width: 45%" value="' + newData.idHistVacuna + '"' +
                                        'data-bs-pp="tooltip" data-bs-placement="top" title="Dar de baja"> <i class="svg-icon fas fa-trash"></i></button>');


                                    // Agrega los botones al div
                                    buttonDiv.append(editButton);
                                    buttonDiv.append(deleteButton);

                                    var buttonCell = $('<td>');
                                    buttonCell.append(buttonDiv);

                                    row.append(buttonCell);

                                    tableBody.append(row);

                                    $.ajax({
                                        url: '/cargarHistoriales/' + idExpediente,
                                        method: "GET",
                                        success: function (data) {
                                            var tablaVacuna = $('#contenedorVacuna');
                                            tablaVacuna.empty(); // Limpia cualquier contenido anterior

                                            // Función para agrupar los datos por el nombre de la vacuna
                                            function groupByVacuna(data) {
                                                if (data === null) {
                                                    var tableBody = $('#detalleVacunaTableBody');
                                                    tableBody.empty(); // Limpia cualquier contenido anterior
                                                    $('#detalleVacunaModal').modal('hide');
                                                }
                                                var groupedData = {};
                                                data.forEach(function (historial, index) {
                                                    var nombreVacuna = historial.vacuna;
                                                    if (!groupedData[nombreVacuna]) {
                                                        groupedData[nombreVacuna] = [];
                                                    }
                                                    groupedData[nombreVacuna].push(historial);
                                                });
                                                return groupedData;
                                            }

                                            var groupedData = groupByVacuna(data);

                                            // Recorre los datos agrupados y crea elementos HTML para mostrarlos
                                            const contenedorPrincipal = document.createElement('div');

                                            for (var nombreVacuna in groupedData) {
                                                const container = document.createElement('div');
                                                container.classList.add('vaccine-container');
                                                container.classList.add('historialv-row');

                                                // Crear un array para almacenar los datos
                                                const datosVacunaArray = [];

                                                // Obtener los datos de fechaAplicacion y dosis para este nombre de vacuna
                                                groupedData[nombreVacuna].forEach(function (historial, index) {

                                                    const datosHistorial = {
                                                        vacuna: nombreVacuna,
                                                        idVacuna: historial.idVacuna, // Puedes establecer el valor correcto
                                                        idExpediente: historial.idExpediente, // Puedes establecer el valor correcto
                                                        fechaAplicacion: historial.fechaAplicacion,
                                                        dosis: historial.dosis,
                                                        idHistVacuna: historial.idHistVacuna,
                                                    };
                                                    // Agregar el objeto de datos al array
                                                    datosVacunaArray.push(datosHistorial);

                                                });

                                                // Convertir el objeto de datos a una cadena JSON
                                                const datosJSON = JSON.stringify(datosVacunaArray);

                                                // Asignar los datos al atributo data-nombre-vacuna del container
                                                container.setAttribute('data-vacuna', datosJSON);



                                                const content = document.createElement('div');
                                                content.classList.add('vaccine-content');
                                                content.style.margin = '0';
                                                content.style.display = 'flex';
                                                content.style.alignItems = 'center';

                                                content.innerHTML = '<i class="inputFieldIcon fas fa-syringe" style="margin-right: 3px; color: #6067eb;vertical-align: middle;"></i> <span class="vaccine-title">' + nombreVacuna + '</span>';
                                                container.appendChild(content);

                                                const ul = document.createElement('ul');
                                                groupedData[nombreVacuna].forEach(function (historial, index) {
                                                    const fechaAplicacion = historial.fechaAplicacion;


                                                    const li = document.createElement('li');
                                                    li.innerHTML = `Dosis #${index + 1} aplicada el ${dateFormat(fechaAplicacion)}`;
                                                    ul.appendChild(li);
                                                });


                                                container.appendChild(ul);
                                                contenedorPrincipal.appendChild(container);
                                            }

                                            const lineBreak = document.createElement('br');
                                            contenedorPrincipal.appendChild(lineBreak);
                                            tablaVacuna.append(contenedorPrincipal);


                                        },
                                        error: function (xhr, status, error) {
                                            console.log(error);

                                        }
                                    });
                                });
                            })
                            .fail(function (xhr) {
                                console.log(xhr);
                                // Maneja errores si es necesario
                            });
                    })
                    .fail(function (xhr) {
                        console.log(xhr);
                        // Maneja errores si es necesario
                    });


            });
            // Agrega los botones al div
            buttonDiv.append(editButton);
            buttonDiv.append(deleteButton);

            var buttonCell = $('<td>');
            buttonCell.append(buttonDiv);

            row.append(buttonCell);

            tableBody.append(row);

        });

        // Abre el modal
        $('#detalleVacunaModal').modal('show');
    });

    // Evento para cargar el select
    $('#mostrar').on('click', function () {
        // Cargar las nuevas opciones del select antes de mostrar el modal

        $.ajax({
            url: '/obtener-vacunas', // Reemplaza con la URL real para obtener los datos
            type: 'GET',
            dataType: 'json', // Suponiendo que los datos se devuelven en formato JSON
            success: function (data) {
                // Limpiar el select actual
                $('#vacuna').empty();

                // Agregar una opción predeterminada (por ejemplo, "Seleccione...")
                $('#vacuna').append($('<option>', {
                    value: '',
                    text: 'Seleccione...'
                }));

                // Recorrer los datos y agregar cada opción al select
                $.each(data, function (index, item) {
                    $('#vacuna').append($('<option>', {
                        value: item.idVacuna,
                        text: item.vacuna
                    }));
                });
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    });

});


function dateFormat(fecha) {
    var fechaObjeto = new Date(fecha); // Agrega 'Z' para indicar que la fecha está en UTC
    var anio = fechaObjeto.getUTCFullYear();
    var mes = (fechaObjeto.getUTCMonth() + 1).toString().padStart(2, '0');
    var dia = fechaObjeto.getUTCDate().toString().padStart(2, '0');
    var fechaFormateada = dia + '/' + mes + '/' + anio; // Cambia el formato según tus necesidades
    return fechaFormateada;
}
