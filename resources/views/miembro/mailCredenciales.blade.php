<!-- resources/views/correo.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correo de Bienvenida</title>
</head>
<body>
    <p>Hola {{ $usuario->miembro->nombres.' '.$usuario->miembro->apellidos }},</p>

    <p>Bienvenido. Tus credenciales de inicio de sesión en el sistema AnimalCare son:</p>

    <ul>
        <li><strong>Usuario:</strong> {{ $usuario->usuario }}</li>
        <li><strong>Clave Temporal:</strong> {{$claveTemporal}}</li>
    </ul>

    <p>Por favor, guarda esta información de forma segura.</p>

    <p>Gracias por unirte a nosotros.</p>

    <p>Saludos,</p>
    <p>Equipo de Tejutepets.</p>
</body>
</html>
