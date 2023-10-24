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
        if (datos[0].patologium) {
            $('#patologia').text(datos[0].patologium.patologia);
            document.getElementById('Patologium').value = datos[0].idPatologia;
        } else {
            $('#patologia').text(datos[0].patologia);
            document.getElementById('Patologium').value = datos[0].idPatologia;
        }

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
                    <button type="button" class="button button-red delete-button" style="width: 30px" id="HistPatologia" value="${dato.idHistPatologia}" data-bs-pp="tooltip" data-bs-placement="top" title="Eliminar">
                        <i class="svg-icon fas fa-trash"></i>
                    </button>
                </td>
            `;

            // Luego, agrega la fila a la tabla
            var tablaBody = document.getElementById("detallepatologiaTableBody");
            tablaBody.appendChild(fila);


            // Agrega un manejador de eventos para los botones de eliminación dentro del modal
            $('#ModalDetallePatologia').on('click', '.delete-button', function () {
                var idToDelete = $(this).attr("value"); // Obtiene el valor del atributo "value" del botón

                console.log(idToDelete);
                // Realiza una solicitud Ajax para eliminar el registro con el ID "idToDelete"
                $.ajax({
                    type: 'DELETE',
                    url: '/historialPatologiaEliminar/' + idToDelete,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // 
                    },
                    success: function (response) {
                        $('#detallepatologiaTableBody').find('button[value="' + idToDelete + '"]').closest('tr').remove();

                        $.ajax({
                            url: '/cargarHistorialesPatologia/' + $('#idExpediente').val(),
                            method: "GET",
                            success: function (data) {

                                var tablaVacuna = $('#contenedorPatologia');

                                tablaVacuna.empty(); // Limpia cualquier contenido anterior
                                console.log(data);
                                // Función para agrupar los datos por el nombre de la patología
                                function groupByPatologia(data) {
                                    if (data == null) {
                                        var tableBody = $('#ModalDetallePatologia');
                                        tableBody.empty(); // Limpia cualquier contenido anterior
                                        $('#ModalDetallePatologia').modal('hide');
                                    }
                                    console.log(data);

                                    const groupedData = {};
                                    data.forEach(function (historial) {
                                        const nombrePatologia = historial.patologia;
                                        if (!groupedData[nombrePatologia]) {
                                            groupedData[nombrePatologia] = [];
                                        }
                                        groupedData[nombrePatologia].push(historial);
                                    });
                                    return groupedData;
                                }

                                // Agrupa los datos por patología
                                const historialesAgrupados = groupByPatologia(data);

                                // Selecciona el contenedor HTML
                                const contenedorPatologia = $('#contenedorPatologia');

                                // Crea un div contenedor para todo el contenido
                                const contenidoCompleto = $('<div>');

                                // Recorre los datos agrupados y crea elementos HTML para mostrarlos
                                for (const nombrePatologia in historialesAgrupados) {
                                    const historiales = historialesAgrupados[nombrePatologia];

                                    // Crea un nuevo div para cada patología
                                    const divContainer = $('<div>');
                                    divContainer.addClass('vaccine-container historialp-row');


                                    // Crear un array para almacenar los datos
                                    const datosVacunaArray = [];

                                    // Obtener los datos de fechaAplicacion y dosis para este nombre de vacuna
                                    historialesAgrupados[nombrePatologia].forEach(function (historial, index) {

                                        const datosHistorial = {
                                            patologia: nombrePatologia,
                                            idPatologia: historial.idPatologia, // Puedes establecer el valor correcto
                                            idExpediente: historial.idExpediente, // Puedes establecer el valor correcto
                                            fechaDiagnostico: historial.fechaDiagnostico,
                                            datalles: historial.datalles,
                                            idHistPatologia: historial.idHistPatologia,
                                            estado: historial.estado,
                                        };
                                        // Agregar el objeto de datos al array
                                        datosVacunaArray.push(datosHistorial);

                                    });

                                    // Convertir el objeto de datos a una cadena JSON
                                    const datosJSON = JSON.stringify(datosVacunaArray);

                                    // Asignar los datos al atributo data-nombre-vacuna del container
                                    divContainer.attr('data-patologia', datosJSON);

                                    // Crea un nuevo div para el contenido
                                    const divContent = $('<div>');
                                    divContent.addClass('vaccine-content');
                                    divContent.css('margin', '0');
                                    divContent.css('display', 'flex');
                                    divContent.css('align-items', 'center');

                                    // Crea una imagen y la configura
                                    const img = $('<img>');
                                    img.attr('src', '/img/suero.svg');
                                    img.attr('alt', 'triangle with all three sides equal');
                                    img.attr('height', 25);
                                    img.attr('width', 25);
                                    img.css('margin-right', '3px');

                                    // Crea un span para el título de la patología
                                    const spanTitle = $('<span>');
                                    spanTitle.addClass('vaccine-title');
                                    spanTitle.text(nombrePatologia);

                                    divContent.append(img);
                                    divContent.append(spanTitle);

                                    const ul = $('<ul>');

                                    // Ordena los historiales por fecha de diagnóstico de forma descendente
                                    historiales.sort((a, b) => new Date(b.fechaDiagnostico) - new Date(a.fechaDiagnostico));

                                    // Toma el último historial (el más reciente) para mostrarlo
                                    const ultimoHistorial = historiales[0];

                                    // Crea elementos de lista y los configura
                                    const liDiagnostico = $('<li>');
                                    liDiagnostico.html('Diagnosticado el <span>' + formatDate(ultimoHistorial.fechaDiagnostico) + '</span>');

                                    const liEstado = $('<li>');
                                    liEstado.html('Estado: <span style="font-size: 15px;" class="badge rounded-pill alert-' + getEstadoClass(ultimoHistorial.estado) + '">' + ultimoHistorial.estado + '</span>');

                                    ul.append(liDiagnostico);
                                    ul.append(liEstado);

                                    divContainer.append(divContent);
                                    divContainer.append(ul);

                                    contenidoCompleto.append(divContainer);
                                }
                                contenidoCompleto.append('<br>');
                                // Agrega el contenido completo a contenedorPatologia
                                contenedorPatologia.append(contenidoCompleto);

                                // Agrega un <br> al final de contenedorPatologia
                                contenedorPatologia.append('<br>');

                                // Función para formatear una fecha
                                function formatDate(date) {
                                    return new Date(date).toLocaleDateString();
                                }

                                // Función para obtener la clase de estado
                                function getEstadoClass(estado) {
                                    if (estado === 'De alta') {
                                        return 'success';
                                    } else if (estado === 'En tratamiento') {
                                        return 'warning';
                                    } else if (estado === 'En espera de tratamiento') {
                                        return 'danger';
                                    }
                                }

                            },
                            error: function (xhr, status, error) {
                                console.log(error);
                            }
                        });

                    },
                    error: function () {
                        // Maneja errores en la solicitud Ajax si es necesario
                    }
                });
            });

        }
        // Abre el modal
        $('#ModalDetallePatologia').modal('show');
    });

    $('#btnCancelarActualizacion').click(function () {

        $('#datalles-error').html('');
        $('#fecha-error').html('');
        $('#state-error').html('');

        // Abre el modal
        $('#ModalDetallePatologia').modal('show');

    });

    $('#btnGuardarActualizacion').click(function () {
        // Borra todas las advertencias de errores existentes
        $('#datalles-error').html('');
        $('#fecha-error').html('');
        $('#state-error').html('');

        // Realiza la solicitud POST para enviar el formulario
        $.ajax({
            type: 'POST',
            url: '/historialPatologias/actualizacion',
            data: $('#formularioActualizacion').serialize(),
            success: function (data) {
                // cerrar el modal
                $('#newActualiacionPatologia').modal('hide');
                // Abre el modal
                $('#ModalDetallePatologia').modal('show');

                document.getElementById('formularioActualizacion').reset();

                $.ajax({
                    url: '/historialPatologias/mostrar/' + $('#idExpediente').val(),
                    method: 'GET',
                    success: function (data) {
                        var tableBody = $('#detallepatologiaTableBody');
                        var datosClonados = data.slice(0);

                        datosClonados.sort(function (a, b) {
                            var fechaA = new Date(a.fechaDiagnostico);
                            var fechaB = new Date(b.fechaDiagnostico);
                            return fechaB - fechaA;
                        });

                        tableBody.empty();

                        for (var index = 0; index < datosClonados.length; index++) {
                            var dato = datosClonados[index];

                            var estadoClase = '';

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
                                    <button type="button" class="button button-red delete-button" style="width: 30px" id="HistPatologia" value="${dato.idHistPatologia}" data-bs-pp="tooltip" data-bs-placement="top" title="Eliminar">
                                        <i class="svg-icon fas fa-trash"></i>
                                    </button>
                                </td>
                            `;

                            var tablaBody = document.getElementById("detallepatologiaTableBody");
                            tablaBody.appendChild(fila);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });

            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Maneja errores de validación
                    var errors = xhr.responseJSON.errors;

                    // Muestra los errores en el modal
                    $('#datalles-error').html(errors.datalles ? errors.datalles[0] : '');
                    $('#fecha-error').html(errors.fecha ? errors.fecha[0] : '');
                    $('#state-error').html(errors.state ? errors.state[0] : '');
                } else if (xhr.status === 500) {
                    // Maneja otros errores, si es necesario
                    console.log('Error interno del servidor:', xhr.responseText);
                }
            }
        });
    });

});