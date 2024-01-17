<!-- resources/views/correo_recuperacion_clave.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Clave</title>
</head>
<body>
    <p>Hola {{ $usuario->usuario }},</p>

    <p>Recibes este correo porque hemos recibido una solicitud para recuperar la clave de acceso de tu cuenta.</p>

    <p>Utiliza el siguiente código de seguridad para continuar con el proceso de recuperación:</p>

    <p><strong>Código de Seguridad:</strong> {{ $tokenTemporal }}</p>

    <p>Ingresa este código en la página de recuperación de clave para completar el proceso:</p>

    <a href="{{ $urlRecuperacion }}">Recuperar Clave</a>

    <p>Por favor, no compartas este código con nadie.</p>

    <p>Si no solicitaste la recuperación de la clave, puedes ignorar este correo electrónico.</p>

    <p>Gracias por usar nuestro servicio.</p>

    <p>Saludos,</p>
    <p>Equipo de Tejutepets.</p>
</body>
</html>
