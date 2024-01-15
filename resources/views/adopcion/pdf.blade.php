<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>PDF</title>
</head>

<style>
    body {
        font-family: Times, "Times New Roman", serif;
        margin: 20px;
        font-size: 14px;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
    }

    .info-box {
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        margin-top: 20px;
        display: flex;
        /* flex-direction: row; */
        justify-content: space-between;
        align-items: center;
    }

    .info-label {
        font-weight: bold;
        margin-bottom: 4px;
        /* display: block; */
    }

    .info-value {
        /* display: block; */
    }

    hr {
        border: 0;
        height: 1px;
        background: #ccc;
        margin: 20px 0;
    }

    h1 {
        text-align: left;
        font-size: 24px;
        margin-bottom: 10px;
    }

    .tamano {
        width: auto;

    }

    table img {
        border-radius: 40%;
        height: 150px;
        /* Ajusta la altura según tus necesidades */
        width: 150px;
        /* Ajusta el ancho según tus necesidades */
        margin-left: 10%;
        margin-top: 5%
    }

    table {
        width: 100%;
        margin-top: 20px;
        border-spacing: 0;
        /* Elimina el espacio entre las celdas */
    }

    .header {
        position: fixed;
        top: 20px;
        right: 20px;
    }

    .estado-general {
        font-size: 18px;
        margin-top: 10px;
        display: inline-block;
        padding: 5px;
    }

    .aprobado {
        color: #4da04d;
        /* background-color: #87e787;
        border-radius: 10px;
        padding: 5px; */
    }

    .pendiente {
        color: #928b8b;
        /* background-color: #666060;
        border-radius: 10px;
        padding: 5px; */
    }

    .denegado {
        color: #bb6868;
        /* background-color: #96665d;
        border-radius: 10px;
        padding: 5px; */
    }
</style>

<body>
    @php
        $fechaActual = now();
    @endphp



    <div class="container">
        <div class="info-box">
            <div>
                <h1>Tramite de adopcion</h1>
                <hr>
            </div>
            <div class="tamano">
                <span class="info-label">Código:</span>
                <span class="info-value">{{ $adopcion->idAdopcion }}</span>
            </div>

            <div class="tamano">
                <span class="info-label">Fecha inicio:</span>
                <span class="info-value">{{ $adopcion->fechaTramiteInicio->format('d/m/Y') }}</span>
            </div>

            @if ($adopcion->fechaTramiteFin != null)
                <div class="tamano">
                    <span class="info-label">Fecha de finalización:</span>
                    <span class="info-value">{{ $adopcion->fechaTramiteFin->format('d/m/Y') }}</span>
                </div>
            @endif
        </div>
    </div>
    <div class="container">
        <div class="info-box">
            <div>
                <h1>Datos de animal</h1>
                <hr>

                <table>
                    <tr>
                        <td>
                            <span class="info-label">No. de expediente:</span>
                            <span class="info-value">{{ $adopcion->idExpediente }}</span>
                        </td>
                        <td rowspan="7">
                            <img src="{{ $adopcion->expediente->animal->imagen }}" alt="Imagen del expediente" />

                        </td>
                    <tr>
                        <td>
                            <span class="info-label">Nombre:</span>
                            <span class="info-value">{{ $adopcion->expediente->animal->nombre }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="info-label">Fecha de nacimiento estimada:</span>
                            @php use App\Http\Controllers\AnimalControlador; @endphp
                            <span
                                class="info-value">{{ AnimalControlador::calcularEdad($adopcion->expediente->animal->fechaNacimiento) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="info-label">Especie:</span>
                            <span class="info-value">{{ $adopcion->expediente->animal->raza->especie->especie }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="info-label">Raza:</span>
                            <span class="info-value">{{ $adopcion->expediente->animal->raza->raza }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="info-label">Sexo:</span>
                            <span class="info-value">{{ $adopcion->expediente->animal->sexo }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="info-label">Sexo:</span>
                            <span class="info-value">{{ $adopcion->expediente->animal->particularidad }}</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="container">
            <div class="info-box">
                <div>
                    <h1>Datos de adoptante</h1>
                    <hr>
                </div>
                <div class="tamano">
                    <span class="info-label">Nombres:</span>
                    <span
                        class="info-value">{{ $adopcion->adoptante->nombres . ' ' . $adopcion->adoptante->apellidos }}</span>
                </div>

                <div class="tamano">
                    <span class="info-label">Dui:</span>
                    <span class="info-value">{{ $adopcion->adoptante->dui }}</span>
                </div>

                <div class="tamano">
                    <span class="info-label">Telefono:</span>
                    @foreach ($adopcion->adoptante->telefono_adoptantes as $tel)
                        <span class="info-value">{{ $tel->telefono }}</span>
                    @endforeach

                </div>


            </div>
        </div>

        <div class="container">
            <div class="info-box">
                <div>
                    <h1>Datos del hogar</h1>
                    <hr>
                </div>
                <div class="tamano">
                    <span class="info-label">Direccion:</span>
                    <span class="info-value">{{ $adopcion->adoptante->hogar->direccion }}</span>
                </div>

                <div class="tamano">
                    <span class="info-label">Tamaño del hogar:</span>
                    <span class="info-value">{{ $adopcion->adoptante->hogar->tamanioHogar }}</span>
                </div>

                <div class="tamano">
                    <span class="info-label">Cantidad de los miembros que lo habitan:</span>
                    <span class="info-value">{{ $adopcion->adoptante->hogar->companiaHumana }}</span>
                </div>
                @if ($adopcion->adoptante->hogar->companiaAnimal > 0)
                    <div class="tamano">
                        <span class="info-label">Cantidad de mascotas que lo habitan:</span>
                        <span class="info-value">{{ $adopcion->adoptante->hogar->companiaAnimal }}</span>

                    </div>
                @endif

            </div>
            <br>

            <div class="tamano estado-general">
                <span class="info-label">Estado general:</span>
                @if ($adopcion->aceptacion == 1)
                    <span class="aprobado">TRAMITE APROBADO</span>
                @elseif ($adopcion->aceptacion == 0)
                    <span class="pendiente">PENDIENTE DE APROBACION</span>
                @else
                    <span class="denegado">TRAMITE DENEGADO</span>
                @endif
            </div>

        </div>
        <script type="text/php">
            if ( isset($pdf) ) {
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $size = 12;
                $fechaActual = now();
                $pdf->text(490, 805, "Fecha: " . $fechaActual->format('d-m-Y'), $font, $size);
                $pdf->text(490, 820, "Hora: " . $fechaActual->format('H:i:s'), $font, $size);
                $pdf->text(270, 820, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
            }
        </script>

    </div>

</body>

</html>
