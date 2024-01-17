$('#tableBody').on('click', '.movimientosR-row', function () {

    var button = $(this); // Fila de la tabla que se hizo clic
    var descripcion = button.data('movimiento').descripcion;
    var fechaMovimiento = button.data('movimiento').fechaMovimento;
    var tipoMovimiento = button.data('movimiento').tipoMovimiento;
    var miembro = button.data('miembro');
    var valor = button.data('movimiento').valor;
    var donante = button.data('donante').nombres + ' ' + button.data('donante').apellidos;

    // Utiliza moment.js para formatear la fecha
    var fechaFormateada = moment(fechaMovimiento).format('DD-MM-YYYY');

    // Actualiza el contenido del modal con los detalles del registro
    $('#FechaMovimiento').text(fechaFormateada);
    $('#Descripcion').text(descripcion);
    $('#tipoMovimiento').text(tipoMovimiento);
    $('#Donante').text(donante);
    $('#miembro').text(miembro);
    $('#valor').text(valor);

    // Abre el modal
    $('#MovimientoRecurso').modal('show');
});
