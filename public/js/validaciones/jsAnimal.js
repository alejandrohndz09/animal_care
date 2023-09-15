$(document).ready(function () {
    subidaImagen();
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
        location.reload();
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Obtén referencias a los elementos HTML que necesitas
    imagenVistaPrevia();
});

function imagenVistaPrevia() {
    const fileInput = document.getElementById('foto');
    const imagePreview = document.getElementById('image-preview');
    

    // Escucha el evento change en el input de tipo "file"
    fileInput.addEventListener('change', function () {
        // Verifica si se ha seleccionado un archivo
        if (fileInput.files.length > 0) {
            const selectedFile = fileInput.files[0];

            // Crea una URL del objeto Blob para la vista previa de la imagen
            const imageURL = URL.createObjectURL(selectedFile);

            // Establece la URL como fondo del label
            imagePreview.style.backgroundImage = `url('` + imageURL + `')`;
            
        }
    });
}

function subidaImagen() {
    
    const fileInput = document.getElementById('foto');
    const imagePreview = document.getElementById('image-preview');
    
        if (fileInput.files.length > 0) {
          const selectedFile = fileInput.files[0];
          const reader = new FileReader();
      
          reader.onload = function (e) {
            // Crear un Blob a partir de la imagen
            const blob = new Blob([e.target.result], { type: selectedFile.type });
      
            // Mostrar la vista previa de la imagen si lo deseas
            imagePreview.style.backgroundImage = `url('` + URL.createObjectURL(blob); + `')`;
          };
      
          // Leer el contenido del archivo como una URL de datos
          reader.readAsArrayBuffer(selectedFile);
        }
      
}