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

    });


    // Controlador de clic para abrir el modal
    $('#contenedorVacuna').on('click', '.historialv-row', function () {

        var button = $(this); // Fila de la tabla que se hizo clic
        var datos = button.data('vacuna'); // Obtiene el valor del atributo data-vacuna

        $('#name').text(datos[0].vacuna.vacuna);
        document.getElementById('Vacuna').value = datos[0].idVacuna;

        // Genera la tabla de detalles en el modal
        var tableBody = $('#detalleVacunaTableBody');

        // Clona el array de datos
        var datosClonados = datos.slice(0);

        // Ordena el array en orden descendente por fecha de diagnóstico
        datosClonados.sort(function (a, b) {
            var fechaA = new Date(a.fechaAplicacion);
            var fechaB = new Date(b.fechaAplicacion);
            return fechaB - fechaA; // Orden descendente
        });

        // Limpia el cuerpo de la tabla
        tableBody.empty();


        // Itera sobre el array ordenado y crea las filas de la tabla con las clases de estado
        for (var index = 0; index < datosClonados.length; index++) {
            var dato = datosClonados[index];

            var fila = document.createElement('tr');
            fila.innerHTML = `
        <td>${index + 1}</td>
        <td >${dato.dosis}</td>
        <td>${new Date(dato.fechaAplicacion).toLocaleDateString()}</td>
        <td> 
            <button type="button" class="button button-red delete-button" style="width: 40%;" id="HistVacuna" value="${dato.idHistVacuna}" data-bs-pp="tooltip" data-bs-placement="top" title="Eliminar">
                <i class="svg-icon fas fa-trash"></i>
            </button>
        </td>
    `;

            // Luego, agrega la fila a la tabla
            var tablaBody = document.getElementById("detalleVacunaTableBody");
            tablaBody.appendChild(fila);
        }

        $('#detalleVacunaModal').off('click', '.delete-button').on('click', '.delete-button', function () {

            var idHistVacuna = $(this).attr("value");

            $.ajax({
                type: 'DELETE',
                url: '/destroyHistorialVacunas/' + idHistVacuna,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                    $('#detalleVacunaTableBody').find('button[value="' + idHistVacuna + '"]').closest('tr').remove();

                    // Verifica si la tabla está vacía después de la eliminación
                    if ($('#detalleVacunaTableBody tr').length === 0) {
                        // Cierra el modal si no hay elementos en la tabla
                        $('#detalleVacunaModal').modal('hide');
                    }
                    $.ajax({
                        url: '/cargarHistoriales/' + $('#idExpediente').val(),
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

                },
                error: function (xhr) {
                    // Maneja errores, si es necesario
                    console.log(xhr);
                }
            });
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

    $('#btnGuardarActualizacionV').click(function () {

        // Borra todas las advertencias de errores existentes
        $('#fechaA-error').html('');
        $('#number-error').html('');

        // Serializa los datos del formulario
        var formData = $('#formularioActualizacionV').serialize();

        // Realiza la solicitud AJAX para validar los campos
        $.ajax({
            type: 'POST',
            url: '/historialVacunas/actualizacionVacunas',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                // cerrar el modal
                $('#newActualizacionVacuna').modal('hide');

                document.getElementById('formularioActualizacionV').reset();

                $.ajax({
                    url: '/getTablaVacunas/' + $('#idExpediente').val() + '/' + $('#Vacuna').val(),
                    method: 'GET',
                    success: function (data) {

                        var tableBody = $('#detalleVacunaTableBody');
                        // Clona el array de datos
                        var datosClonados = data.slice(0);

                        // Ordena el array en orden descendente por fecha de diagnóstico
                        datosClonados.sort(function (a, b) {
                            var fechaA = new Date(a.fechaAplicacion);
                            var fechaB = new Date(b.fechaAplicacion);
                            return fechaB - fechaA; // Orden descendente
                        });

                        // Limpia el cuerpo de la tabla
                        tableBody.empty();


                        // Itera sobre el array ordenado y crea las filas de la tabla con las clases de estado
                        for (var index = 0; index < datosClonados.length; index++) {
                            var dato = datosClonados[index];

                            var fila = document.createElement('tr');
                            fila.innerHTML = `
                                <td>${index + 1}</td>
                                <td >${dato.dosis}</td>
                                <td>${dateFormat(dato.fechaAplicacion)}</td>
                                <td> 
                                    <button type="button" class="button button-red delete-button" style="width: 40%;" id="HistVacuna" value="${dato.idHistVacuna}" data-bs-pp="tooltip" data-bs-placement="top" title="Eliminar">
                                        <i class="svg-icon fas fa-trash"></i>
                                    </button>
                                </td>
                             `;

                            // Luego, agrega la fila a la tabla
                            var tablaBody = document.getElementById("detalleVacunaTableBody");
                            tablaBody.appendChild(fila);
                        }

                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });

                $.ajax({
                    url: '/cargarHistoriales/' + $('#idExpediente').val(),
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

                // Abre el modal
                $('#detalleVacunaModal').modal('show');

            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Maneja errores de validación
                    var errors = xhr.responseJSON.errors;

                    // Itera a través de los campos del formulario
                    $('#formularioActualizacionV input, #formularioActualizacionV select').each(function () {
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

    $('#btnCancelarActualizacionV').click(function () {

        $('#fechaA-error').html('');
        $('#number-error').html('');

        // Abre el modal
        $('#detalleVacunaModal').modal('show');

    });

    $('#actualizacionVacuna').click(function () {

        // Borra todas las advertencias de errores cuando se presiona "Cancelar"
        $('#fechaA-error').html('');
        $('#number-error').html('');

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
