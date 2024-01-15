<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: justify;
            /* Añade esta línea para justificar el texto */
        }

        h1 {
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-spacing: 0;
            /* Elimina el espacio entre las celdas */
        }

        table img {
            border-radius: 50%;
            height: 250px;
            /* Ajusta la altura según tus necesidades */
            width: 250px;
            /* Ajusta el ancho según tus necesidades */
            margin-left: 5%;
            margin-top: -10%
        }

        td {
            padding: 3px;
            /* Ajusta el espaciado dentro de las celdas */
        }

        .info-label {
            color: #555;
            font-weight: bold;

        }

        .info-value {
            color: #777;
        }
    </style>

</head>

<body>
    @php
        $fechaActual = now();
    @endphp
    <p class="info-label">Fecha de generación del PDF: {{ $fechaActual->format('Y-m-d H:i:s') }}</p>
    <h3>Expediente No.{{ $animal->expedientes->get(0)->idExpediente }}</h3>

    <table>
        <tr>
            <td>

                <span class="info-label">Nombre:</span>
                <span class="info-value">{{ $animal->nombre }}</span>
            </td>
            <td rowspan="7">
                <img src="{{ $animal->imagen }}" alt="Imagen del expediente" />

            </td>
        <tr>
            <td>
                @php use App\Http\Controllers\AnimalControlador; @endphp
                <span class="info-label">Edad Estimada:</span>
                <span class="info-value">
                    {{ AnimalControlador::calcularEdad(explode(' ', $animal->fechaNacimiento)[0]) }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="info-label">Especie:</span>
                <span class="info-value">{{ $animal->raza->especie->especie }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="info-label">Raza:</span>
                <span class="info-value">{{ $animal->raza->raza }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="info-label">Sexo:</span>
                <span class="info-value">{{ $animal->sexo }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="info-label">Particularidad:</span>
                <span class="info-value">{{ $animal->particularidad }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="info-label">Estado:</span>
                <span class="info-value">{{ $animal->expedientes->get(0)->estadoGeneral }}</span>
            </td>
        </tr>

    </table>


    <div id="contenedor">
        <div>
            <h3>Historial de vacunas</h3>
            @php
                $historialesAgrupadosVacunas = [];
            @endphp

            @foreach ($animal->expedientes->get(0)->historialVacunas as $historial)
                @php
                    $nombreVacuna = $historial->vacuna->vacuna;
                    if (!isset($historialesAgrupadosVacunas[$nombreVacuna])) {
                        $historialesAgrupadosVacunas[$nombreVacuna] = [];
                    }
                    $historialesAgrupadosVacunas[$nombreVacuna][] = $historial->fechaAplicacion;
                @endphp
            @endforeach


            @foreach ($historialesAgrupadosVacunas as $nombreVacuna => $fechas)
                <div>
                    <div >
                        <img src="img/vaccine.svg" alt="Vaccine Icon" height="25" width="25"
                            style="margin-right: 3px" />
                        <span class="vaccine-title">{{ $nombreVacuna }}</span>
                    </div>
                    <ul>
                        @foreach ($fechas as $fecha)
                            <li>Dosis aplicada el
                                {{ $fecha ? date('d/m/Y', strtotime($fecha)) : 'Fecha no disponible' }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

        </div>


        <div>
            <h3>Historial de patologías</h3>
            @php
                $historialesAgrupadosPatologias = [];
            @endphp

            @foreach ($animal->expedientes->get(0)->historialPatologia as $historial)
                @php
                    $nombrePatologia = $historial->patologium->patologia;
                    if (!isset($historialesAgrupadosPatologias[$nombrePatologia])) {
                        $historialesAgrupadosPatologias[$nombrePatologia] = [];
                    }
                    $historialesAgrupadosPatologias[$nombrePatologia][] = $historial;
                @endphp
            @endforeach


            @foreach ($historialesAgrupadosPatologias as $nombrePatologia => $historiales)
                <div>
                    <img src="img/suero.svg" alt="Suero Icon" height="25" width="25" style="margin-right: 3px" />
                    <span class="vaccine-title">{{ $nombrePatologia }}</span>
                </div>
                <ul>
                    @php
                        usort($historiales, function ($a, $b) {
                            return strtotime($b->fechaDiagnostico) - strtotime($a->fechaDiagnostico);
                        });
                        $ultimoHistorial = reset($historiales);
                    @endphp
                    <ul>
                        <li>
                            Diagnosticado el
                            <span>{{ date('d/m/Y', strtotime($ultimoHistorial->fechaDiagnostico)) }}</span>
                        </li>
                        <li>
                            Estado:
                            <span style="font-size: 15px;"
                                class="@if ($ultimoHistorial->estado == 'De alta') badge rounded-pill alert-success @elseif($ultimoHistorial->estado == 'En tratamiento') badge rounded-pill alert-warning @elseif($ultimoHistorial->estado == 'En espera de tratamiento') badge rounded-pill alert-danger @endif">
                                {{ $ultimoHistorial->estado }}
                            </span>
                        </li>
                    </ul>
                </ul>
            @endforeach
        </div>
    </div>

    <script type="text/php">
        if ( isset($pdf) ) {
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $size = 12;
            $pdf->text(270, 20, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
            $fechaActual = now();
            $pdf->text(490, 805, "Fecha: " . $fechaActual->format('d-m-Y'), $font, $size);
            $pdf->text(490, 820, "Hora: " . $fechaActual->format('H:i:s'), $font, $size);
        }
    </script>

</body>

</html>
