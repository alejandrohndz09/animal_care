$(document).ready(function () {
    //Habilitar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-pp="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    // Captura el valor anterior de "raza" (puedes obtenerlo de old('raza') o de otra fuente)
    var recursoId = $('#recurso').val();
    $.ajax({
        url: '/obtener-razas/' + recursoId,
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


    // Captura el cambio en el campo de recurso
    $('#recurso').change(function () {
        var recursoId = $(this).val();
        var valorInput = $('input[name="valor"]');
        if (recursoId != "") {
            $.ajax({
                url: '/obtener-unidad/' + recursoId,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    var extra = ` dado en (${data.simbolo})`;
                    // Limpia y llena el campo de valor con las nuevas opciones
                    $('#valorlabel').empty();
                    $('#valorlabel').text('Valor' + extra + '*');
                    $('#valorlabel').css('color', '#000000');
                    valorInput.prop('disabled', false);
                    $('#icValor').css('color', '#6067eb');
                }
            });
        } else {
            $('#valorlabel').empty();
            $('#valorlabel').text('Valor*');
            $('#valorlabel').css('color', '#878787');
            valorInput.prop('disabled', true);
            $('#icValor').css('color', '#878787');
        }
    });

    // Captura el cambio en el campo de tipoMovimiento
    $('#tipoMovimiento').change(function () {
        var valor = $(this).val();
        console.log(valor);
        var divContenedor = $('#donante-container');
        if (valor == "Ingreso") {
            var espacio = `
            <div class="col-xl-5">
            <div class="inputContainer">
                <label class="inputFieldLabel">¿Es de una donación?*</label>
                <i class="inputFieldIcon fas fa-question"></i>
                <div style="padding: 3px 15px">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                            name="isDonado" id="inlineRadio1" value="Sí">
                        <label class="form-check-label" for="Sí">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                            name="isDonado" id="inlineRadio2" value="No" checked>
                        <label class="form-check-label" for="No">No</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7">
            <div class="d-flex  align-items-center">
                <button type="button" class="button button-pri" id="btnDonante"
                    data-bs-toggle="modal" data-bs-target="#buscarDonante"
                    style="width: 100%;padding: 7px 7px; justify-items: end;visibility: hidden;">
                    <i class="svg-icon fas fa-search"></i>
                    <span class="lable">Seleccionar donante</span>
                </button>

                <input placeholder="Seleccione" type="hidden" value=""
                    class="inputField" name="nombreDonante">
            </div>
        </div>`;
            $('#donante-container')[0].innerHTML = espacio;
        } else {
            $('#donante-container')[0].innerHTML = '';
        }
    });
    $("#btnCancelar").click(function () {
        window.location.href = '/inventario/movimientos/'
    });

    //Si presiona eliminar abrira el modal con los datos que se daran de baja
    $('#exampleModalToggle').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que desencadenó el modal
        // Botón que desencadenó el modal
        var id = button.data('movimiento').idAnimal; // Obtiene el valor del atributo data-id
        var nombre = button.data('movimiento').nombre; // Obtiene el valor del atributo data-nombre
        var recurso = button.data('movimiento').raza.recurso.recurso; // Obtiene el valor del atributo data-apellido
        var raza = button.data('movimiento').raza.raza; // Obtiene el valor del atributo data-correo
        var imagen = button.data('movimiento').imagen;
        // Actualiza el contenido del modal con los detalles del registro
        $('#modalRecordCodigo').text(id);
        $('#modalRecordNombre').text(nombre);
        $('#modalRecordEspecie').text(recurso);
        $('#modalRecordRaza').text(raza);
        if (imagen != null) {
            document.getElementById("imagenModal").src = imagen;
        } else {
            document.getElementById("imagenModal").src = 'https://static.vecteezy.com/system/resources/previews/017/783/245/original/pet-shop-silhouette-logo-template-free-vector.jpg';
        }

        $('body').on('click', '#confirmar', function () {
            window.location.href = '/movimiento/destroy/' + id;
            // $.get('/movimiento/destroy/' + id, function () {
            //     // location.reload();
            //     window.location.href = '/movimiento'
            // });
        });

    });
});

// $(".btnDelete").click(function (event) {
//     // Evitar la propagación del evento al hacer clic en la fila
//     event.stopPropagation();
// });
// $(".btnUpdate").click(function (event) {
//     // Evitar la propagación del evento al hacer clic en la fila
//     event.stopPropagation();
// });

// $('#tableBody').on('click', '.movimiento-row', function (event) {

//     // Verifica si el clic se realizó en un botón de editar o eliminar
//     if ($(event.target).is('a#btnUpdate') || $(event.target).is('.btnDelete')) {

//         return; // No muestres el modal si se hizo clic en un botón
//     } else {
//         var button = $(this); // Fila de la tabla que se hizo clic
//         var id = button.data('movimiento').idAnimal; // Obtiene el valor del atributo data-id
//         window.location.href = '/expediente/' + id;
//     }
// });

// Agrega un evento de cambio al radio button
$(document).on('change', 'input[name="isDonado"]', function () {
    var btnDonante = $('#btnDonante')[0];
    if ($(this).val() === 'No') {
        // Si el valor es 'No', deshabilita el input y cambia el color del componente
        btnDonante.style.visibility = 'hidden';
    } else if ($(this).val() === 'Sí') {
        // Si el valor es 'Sí', habilita el input y cambia el color del componente
        btnDonante.style.visibility = 'visible';
    }
});

$('.seleccion').on('click', function () {
    var nombres = $(this).data('nombre');
    var apellidos = $(this).data('apellido');
    var idDonante = $(this).data('id');

    console.log(nombres);

    $('#idDonante').val(idDonante); // Guardar el ID en un campo oculto dentro del modal
    $('#DonanteName').text(nombres + ' ' + apellidos); // Cambiar el texto del span
});

$('.seleccion').on('click', function () {
  
    var idDonante = $(this).data('id');

    $('#donanteE').val(idDonante); // Guardar el ID en un campo oculto dentro del modal
});


$(".btnDelete").click(function (event) {
    // Evitar la propagación del evento al hacer clic en la fila
    event.stopPropagation();
});
$(".btnUpdate").click(function (event) {
    // Evitar la propagación del evento al hacer clic en la fila
    event.stopPropagation();
});

$('.movimiento-row').on('click', function (event) {
    // Verifica si el clic fue en un botón dentro de la fila
    if ($(event.target).is('.btnUpdate, .btnDelete')) {
        return; // Evita abrir el modal si se hizo clic en un botón
    }

    var button = $(this); // Fila de la tabla que se hizo clic
    var movimientoData = button.data('movimiento');
    var id = movimientoData.idMovimiento;
    var fecha = movimientoData.fechaMovimento.split(' ')[0]; // Obtiene la primera parte de la cadena
    var tipoMovimiento = movimientoData.tipoMovimiento;
    var valor = movimientoData.valor;
    var recurso = button.data('recurso');
    var donante = button.data('donante').nombres + ' ' + button.data('donante').apellidos;
    var miembro = button.data('miembro');

    // Utiliza moment.js para formatear la fecha
    var fechaFormateada = moment(fecha).format('DD-MM-YYYY');

    // Actualiza el contenido del modal con los detalles del registro
    $('#CodigoMovimiento').text(id);
    $('#fechaMovimiento').text(fechaFormateada);
    $('#TipoMovimiento').text(tipoMovimiento);
    $('#ValorMovimiento').text(valor);
    $('#RecursoMovimiento').text(recurso);
    $('#DonanteMovimiento').text(donante);
    $('#MiembroMovimiento').text(miembro);

    // Abre el modal
    $('#modalDetalleMovimiento').modal('show');
});
document.querySelector('.floating-button').addEventListener('click', function () {
    $('#ayudaMovimiento').modal('show');
    });