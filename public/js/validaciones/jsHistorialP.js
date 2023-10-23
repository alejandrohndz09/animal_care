$(document).ready(function () {

    // Evento para cargar el select
    $('#mostrarPatologia').on('click', function () {
        $('#idPatologia-error').html('');
        $('#detalles-error').html('');
        $('#fechaDiagnostico-error').html('');
        $('#estado-error').html('');

        // Hacer una solicitud AJAX para obtener los registros de la BD
        console.log($('#idAnimal').val());
        $.ajax({
            url: '/obtener-registros-guardados/' + $('#idAnimal').val(),
            type: 'GET',
            dataType: 'json',
            success: function (dataGuardados) {
                // Luego, hacer una solicitud AJAX para obtener todos los registros disponibles
                $.ajax({
                    url: '/obtener-patologias', // Cambia esto a la URL correcta
                    type: 'GET',
                    dataType: 'json',
                    success: function (dataDisponibles) {
                        // Filtrar los registros disponibles excluyendo los ya guardados
                        var registrosFiltrados = dataDisponibles.filter(function (disponible) {
                            // Verificar si el registro está en los datos guardados
                            var estaEnBD = dataGuardados.some(function (guardado) {
                                return guardado.idPatologia === disponible.idPatologia;
                            });

                            // Si no está en la BD de datos guardados, mantenerlo en la lista
                            return !estaEnBD;
                        });

                        // Limpiar el select actual
                        $('#idPatologia').empty();

                        // Agregar una opción predeterminada (por ejemplo, "Seleccione...")
                        $('#idPatologia').append($('<option>', {
                            value: '',
                            text: 'Seleccione...'
                        }));

                        // Recorrer los registros filtrados y agregar cada opción al select
                        $.each(registrosFiltrados, function (index, item) {
                            $('#idPatologia').append($('<option>', {
                                value: item.idPatologia,
                                text: item.patologia
                            }));
                        });
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    });


    $('#btnCancelarPatologia').click(function () {

        // Borra todas las advertencias de errores cuando se presiona "Cancelar"
        $('#idPatologia-error').html('');
        $('#detalles-error').html('');
        $('#fechaDiagnostico-error').html('');
        $('#estado-error').html('');

        if (document.getElementById("operacionPatologia").value == "modificar") {
            $('#detalleVacunaModalPatologia').modal('show');
        }

    });

    $('#btnGuardarP').click(function () {
        // Borra todas las advertencias de errores existentes
        $('#idPatologia-error').html('');
        $('#detalles-error').html('');
        $('#fechaDiagnostico-error').html('');
        $('#estado-error').html('');

        // Realiza la solicitud POST para enviar el formulario
        $.ajax({
            type: 'POST',
            url: '/historialPatologias/store',
            data: $('#formularioP').serialize(),
            success: function (data) {
                // Si la validación se completó con éxito
                $('#newHistorialPatologia').modal('hide');
                window.location.reload();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Maneja errores de validación
                    var errors = xhr.responseJSON.errors;

                    // Muestra los errores en el modal
                    $('#idPatologia-error').html(errors.idPatologia ? errors.idPatologia[0] : '');
                    $('#detalles-error').html(errors.detalles ? errors.detalles[0] : '');
                    $('#fechaDiagnostico-error').html(errors.fechaDiagnostico ? errors.fechaDiagnostico[0] : '');
                    $('#estado-error').html(errors.estado ? errors.estado[0] : '');
                } else if (xhr.status === 500) {
                    // Maneja otros errores, si es necesario
                    console.log('Error interno del servidor:', xhr.responseText);
                }
            }
        });
    });


    // Controlador de clic para abrir el modal
    $('#contenedorPatologia').on('click', '.historialp-row', function () {

        var button = $(this); // Fila de la tabla que se hizo clic
        var datos = button.data('patologia'); // Obtiene el valor del atributo data-vacuna

        console.log(datos)


        // Genera los detalles en el modal
        $('#patologia').text(datos[0].patologium.patologia);
        // Genera la tabla de detalles en el modal
        var tableBody = $('#detallepatologiaTableBody');

        // Clona el array de datos
        var datosClonados = datos.slice(0);

        // Ordena el array en orden descendente por fecha de diagnóstico
        datosClonados.sort(function (a, b) {
            var fechaA = new Date(a.fechaDiagnostico);
            var fechaB = new Date(b.fechaDiagnostico);
            return fechaB - fechaA; // Orden descendente
        });

        // Limpia el cuerpo de la tabla
        tableBody.empty();

        // Itera sobre el array ordenado y crea las filas de la tabla con las clases de estado
        for (var index = 0; index < datosClonados.length; index++) {
            var dato = datosClonados[index];

            var estadoClase = ''; // Clase de estado por defecto

            if (dato.estado === 'De alta') {
                estadoClase = 'badge rounded-pill alert-success';
            } else if (dato.estado === 'En tratamiento') {
                estadoClase = 'badge rounded-pill alert-warning"';
            } else if (dato.estado === 'En espera de tratamiento') {
                estadoClase = 'badge rounded-pill alert-danger';
            }

            var fila = document.createElement('tr');
            fila.innerHTML = `
                <td style="width: 5%;">${index + 1}</td>
                <td>${new Date(dato.fechaDiagnostico).toLocaleDateString()}</td>
                <td style="width: 25%;" class="text-wrap">${dato.datalles}</td>
                <td style="width: 20%;">
                    <span style="font-size: 15px;" class="${estadoClase}">${dato.estado}</span>
                </td>
                <td style="width: 10%;"> 
                    <button type="button" class="button button-red delete-button" style="width: 30px" id="HistVacuna" value="${dato.idHistPatologia}" data-bs-pp="tooltip" data-bs-placement="top" title="Eliminar">
                        <i class="svg-icon fas fa-trash"></i>
                    </button>
                </td>
            `;

            // Luego, agrega la fila a la tabla
            var tablaBody = document.getElementById("detallepatologiaTableBody");
            tablaBody.appendChild(fila);

        }



        // var idExpediente = datos[0].idExpediente;
        // var idVacuna = datos[0].idVacuna;

        // $('#name').text(datos[0].vacuna.vacuna);

        // // Itera sobre los datos en historiales
        // $.each(datos, function (index, historial) {

        //     // Agrega una fila a la tabla
        //     var row = $('<tr>');
        //     row.append(`<td>${index + 1} </td>`);
        //     row.append('<td>' + historial.dosis + '</td>');
        //     row.append('<td>' + dateFormat(historial.fechaAplicacion) + '</td>');


        //     // Agrega un div que envuelve a los botones y aplica estilos
        //     var buttonDiv = $('<div style="display: flex; align-items: flex-end; gap: 5px; justify-content: center;">');
        //     var editButton = $('<button type="button" class="button button-blue"' +
        //         'data-bs-pp="tooltip" data-bs-placement="top" style="width: 45%;" title="Editar"> <i class="svg-icon fas fa-pencil"></i></button>');
        //     var deleteButton = $('<button type="button" class="button button-red delete-button" id="HistVacuna" style="width: 45%" value = "' + historial.idHistVacuna + '"' +
        //         'data-bs-pp="tooltip" data-bs-placement="top" title="Eliminar"> <i class="svg-icon fas fa-trash"></i></button>');



        //     editButton.on('click', function () {
        //         $.ajax({
        //             type: 'GET',
        //             url: '/historialVacunas/' + historial.idHistVacuna + '/edit',
        //             success: function (data) {

        //                 // Limpiar el select actual
        //                 $('#vacuna').empty();

        //                 // Datos del registro a modificar
        //                 var fechaAplicacion = data.fechaAplicacion;
        //                 var dosis = data.dosis;

        //                 // Solicitud AJAX para obtener todas las opciones para el select
        //                 $.ajax({
        //                     type: 'GET',
        //                     url: '/obtener-vacunas', // Debes definir la ruta correspondiente
        //                     success: function (opciones) {
        //                         // Limpiar el select actual
        //                         $('#vacuna').empty();

        //                         // Agregar una opción predeterminada (por ejemplo, "Seleccione...")
        //                         $('#vacuna').append($('<option>', {
        //                             value: '',
        //                             text: 'Seleccione...'
        //                         }));

        //                         // Agregar opciones al select
        //                         $.each(opciones, function (index, opcion) {
        //                             $('#vacuna').append($('<option>', {
        //                                 value: opcion.idVacuna,
        //                                 text: opcion.vacuna
        //                             }));
        //                         });


        //                         // Establecer el valor seleccionado en el select
        //                         $('#vacuna').val(data.idVacuna);

        //                         // Llenar otros campos
        //                         $('#fechaAplicacion').val(fechaAplicacion);
        //                         $('#dosis').val(dosis);

        //                         // Abrir el modal de edición
        //                         $('#detalleVacunaModal').modal('hide');

        //                         document.getElementById('Texto').textContent = 'Editar Registro';

        //                         document.getElementById('btn').textContent = 'Modificar';

        //                         document.getElementById("operacion").value = "modificar";

        //                         document.getElementById("idHistVacuna").value = data.idHistVacuna;

        //                         // Borra todas las advertencias de errores cuando se presiona "Cancelar"
        //                         $('#formulario #vacuna-error').html('');
        //                         $('#formulario #dosis-error').html('');
        //                         $('#formulario #fechaAplicacion-error').html('');


        //                         // Abrir el modal de edición
        //                         $('#newHistorial').modal('show');

        //                     }
        //                 });
        //             },
        //             error: function (xhr) {
        //                 // Maneja errores, si es necesario
        //                 console.log(xhr);
        //             }
        //         });
        //     });

        //    deleteButton.on('click', function () {

        //         var idHistVacuna = $(this).attr('value');

        //         console.log(idHistVacuna);

        //         $.ajax({
        //             type: 'DELETE',
        //             url: '/destroyHistorialVacunas/' + idHistVacuna,
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //         })
        //             .done(function () {
        //                 // Eliminación exitosa
        //                 // Ahora, solicita todos los registros relacionados con idVacuna
        //                 $.ajax({
        //                     type: 'GET',
        //                     url: '/cargarListaDatos/' + idVacuna
        //                 })
        //                     .done(function (data) {

        //                         tableBody.empty();
        //                         $.each(data, function (index, newData) {

        //                             // Agrega una fila a la tabla
        //                             var row = $('<tr>');
        //                             row.append(`<td>${index + 1} </td>`);
        //                             row.append('<td>' + newData.dosis + '</td>');
        //                             row.append('<td>' + dateFormat(newData.fechaAplicacion) + '</td>');
        //                             row.append('<td></td>');

        //                             // Agrega un div que envuelve a los botones y aplica estilos
        //                             var buttonDiv = $('<div style="display: flex; align-items: flex-end; gap: 5px; justify-content: center;">');
        //                             var editButton = $('<button type="button" class="button button-blue"' +
        //                                 'data-bs-pp="tooltip" data-bs-placement="top" style="width: 45%;" title="Editar"> <i class="svg-icon fas fa-pencil"></i></button>');
        //                             var deleteButton = $('<button type="button" class="button button-red  delete-button" style="width: 45%" value="' + newData.idHistVacuna + '"' +
        //                                 'data-bs-pp="tooltip" data-bs-placement="top" title="Dar de baja"> <i class="svg-icon fas fa-trash"></i></button>');


        //                             // Agrega los botones al div
        //                             buttonDiv.append(editButton);
        //                             buttonDiv.append(deleteButton);

        //                             var buttonCell = $('<td>');
        //                             buttonCell.append(buttonDiv);

        //                             row.append(buttonCell);

        //                             tableBody.append(row);

        //                             $.ajax({
        //                                 url: '/cargarHistoriales/' + idExpediente,
        //                                 method: "GET",
        //                                 success: function (data) {
        //                                     var tablaVacuna = $('#contenedorVacuna');
        //                                     tablaVacuna.empty(); // Limpia cualquier contenido anterior

        //                                     // Función para agrupar los datos por el nombre de la vacuna
        //                                     function groupByVacuna(data) {
        //                                         if (data == null) {
        //                                             var tableBody = $('#detalleVacunaTableBody');
        //                                             tableBody.empty(); // Limpia cualquier contenido anterior
        //                                             $('#detalleVacunaModal').modal('hide');
        //                                         }
        //                                         var groupedData = {};
        //                                         data.forEach(function (historial, index) {
        //                                             var nombreVacuna = historial.vacuna;
        //                                             if (!groupedData[nombreVacuna]) {
        //                                                 groupedData[nombreVacuna] = [];
        //                                             }
        //                                             groupedData[nombreVacuna].push(historial);
        //                                         });
        //                                         return groupedData;
        //                                     }

        //                                     var groupedData = groupByVacuna(data);

        //                                     // Recorre los datos agrupados y crea elementos HTML para mostrarlos
        //                                     const contenedorPrincipal = document.createElement('div');

        //                                     for (var nombreVacuna in groupedData) {
        //                                         const container = document.createElement('div');
        //                                         container.classList.add('vaccine-container');
        //                                         container.classList.add('historialv-row');

        //                                         // Crear un array para almacenar los datos
        //                                         const datosVacunaArray = [];

        //                                         // Obtener los datos de fechaAplicacion y dosis para este nombre de vacuna
        //                                         groupedData[nombreVacuna].forEach(function (historial, index) {

        //                                             const datosHistorial = {
        //                                                 vacuna: nombreVacuna,
        //                                                 idVacuna: historial.idVacuna, // Puedes establecer el valor correcto
        //                                                 idExpediente: historial.idExpediente, // Puedes establecer el valor correcto
        //                                                 fechaAplicacion: historial.fechaAplicacion,
        //                                                 dosis: historial.dosis,
        //                                                 idHistVacuna: historial.idHistVacuna,
        //                                             };
        //                                             // Agregar el objeto de datos al array
        //                                             datosVacunaArray.push(datosHistorial);

        //                                         });

        //                                         // Convertir el objeto de datos a una cadena JSON
        //                                         const datosJSON = JSON.stringify(datosVacunaArray);

        //                                         // Asignar los datos al atributo data-nombre-vacuna del container
        //                                         container.setAttribute('data-vacuna', datosJSON);



        //                                         const content = document.createElement('div');
        //                                         content.classList.add('vaccine-content');
        //                                         content.style.margin = '0';
        //                                         content.style.display = 'flex';
        //                                         content.style.alignItems = 'center';

        //                                         content.innerHTML = '<i class="inputFieldIcon fas fa-syringe" style="margin-right: 3px; color: #6067eb;vertical-align: middle;"></i> <span class="vaccine-title">' + nombreVacuna + '</span>';
        //                                         container.appendChild(content);

        //                                         const ul = document.createElement('ul');
        //                                         groupedData[nombreVacuna].forEach(function (historial, index) {
        //                                             const fechaAplicacion = historial.fechaAplicacion;


        //                                             const li = document.createElement('li');
        //                                             li.innerHTML = `Dosis #${index + 1} aplicada el ${dateFormat(fechaAplicacion)}`;
        //                                             ul.appendChild(li);
        //                                         });


        //                                         container.appendChild(ul);
        //                                         contenedorPrincipal.appendChild(container);
        //                                     }

        //                                     const lineBreak = document.createElement('br');
        //                                     contenedorPrincipal.appendChild(lineBreak);
        //                                     tablaVacuna.append(contenedorPrincipal);


        //                                 },
        //                                 error: function (xhr, status, error) {
        //                                     console.log(error);

        //                                 }
        //                             });
        //                         });
        //                     })
        //                     .fail(function (xhr) {
        //                         console.log(xhr);
        //                         // Maneja errores si es necesario
        //                     });
        //             })
        //             .fail(function (xhr) {
        //                 console.log(xhr);
        //                 // Maneja errores si es necesario
        //             });


        //     });
        //     // Agrega los botones al div
        //     buttonDiv.append(editButton);
        //     buttonDiv.append(deleteButton);

        //     var buttonCell = $('<td>');
        //     buttonCell.append(buttonDiv);

        //     row.append(buttonCell);

        //     tableBody.append(row);

        // });

        // // Abre el modal
        $('#ModalDetallePatologia').modal('show');
    });

});