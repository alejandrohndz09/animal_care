$(document).ready(function () {
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
});