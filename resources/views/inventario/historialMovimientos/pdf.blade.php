<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
    
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

        .info-label {
            font-weight: bold;
            margin-bottom: 4px;
        }

        .info-value {
            display: block;
            margin-bottom: 16px;
        }

        hr {
            border: 0;
            height: 1px;
            background: #ccc;
            margin: 20px 0;
        }

        h3 {
            margin-top: 20px;
            text-align: center;
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border-top: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .picture {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
    


<body>
    {{-- <div class="container">
        <h1>Listadp del Albergue</h1>
        <hr>
        <h3>Animales albergados</h3>
        <table>
            <thead>
                <tr class="head">
                    <th style="width: 15%"></th>
                    <th>Cod. Expediente</th>
                    <th>Nombre</th>
                    <th>Especie</th>
                    <th>Raza</th>
                    <th class="edad-cell">Edad</th>
                </tr>
            </thead>
            <tbody id="tableBody">

                @php use App\Http\Controllers\AnimalControlador; @endphp
                @foreach ($albergue->expedientes as $a)
                    <tr>
                        <td style="width: 15%">
                            @if (!is_null($a->animal) && !empty($a->animal->imagen))
                                <img src="{{ $a->animal->imagen }}" alt="user" class="picture" />
                            @else
                                <img src="https://static.vecteezy.com/system/resources/previews/017/783/245/original/pet-shop-silhouette-logo-template-free-vector.jpg"
                                    alt="user" class="picture" />
                            @endif
                        </td>
                        <td>{{ $a->idExpediente }}</td>
                        <td>{{ $a->animal->nombre }}</td>
                        <td>{{ $a->animal->raza->especie->especie }}</td>
                        <td>{{ $a->animal->raza->raza }}</td>
                        <td>{{ AnimalControlador::calcularEdad(explode(' ', $a->fechaNacimiento)[0]) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}
    <script type="text/php">
        if ( isset($pdf) ) {
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $size = 12;
            $pdf->text(270, 820, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
            $fechaActual = now();
            $pdf->text(490, 805, "Fecha: " . $fechaActual->format('d-m-Y'), $font, $size);
            $pdf->text(490, 820, "Hora: " . $fechaActual->format('H:i:s'), $font, $size);
        }
    </script>

</body>

</html>
