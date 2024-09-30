<!DOCTYPE html>
<html>

<head>
    <style>
        table.fecha {
            width: 23%;
            border-collapse: collapse;
            margin-left: 5px;
            margin-right: 5px;
            border: 1px solid 000000;
        }

        table.notas,
        table.otra {
            width: 100%;
            border-collapse: separate;
            margin-left: 4px;
            margin-right: 4px;
            border: 1px solid 000000;
            padding: 1px;
            border-radius: 5px;
        }

        td {
            padding: 5px;
            border: 1px solid black;
            border-radius: 5px;
        }

        .content {
            height: 50%;
            /* border: 1px solid black; */
            /* Solo para ilustrar los bordes */
        }

        table.fecha {
            border-collapse: separate;
            border-radius: 5px;
        }

        @page {
            size: letter;
            margin-top: 0.5cm;
            margin-left: 0.7cm;
            margin-right: 0.7cm;
            margin-bottom: 0.2cm;
        }

        body {
            height: 50vh;
            /* Altura del contenido limitada a la mitad de la hoja */
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        #watermark {
            position: fixed;
            top: 12%;
            width: 100%;
            text-align: center;
            opacity: 1;
            transform-origin: 50% 50%;
            z-index: -1000;
        }
    </style>
</head>

<body>
    <div class="content">
        <div id="watermark">
            <img src="{{ public_path('images/kyrios2.jpg') }}" width="70%">
        </div>
        <div style="text-align: right;">
            <img src="{{ public_path('images/kyrios.jpg') }}" width="70%">
        </div>

        <div style="margin-top: -70px; text-align: left;">
            <table class="fecha">
                <tr class="notas">
                    <td class="notas" align="center">
                        <b>Orden No: </b>
                        <font color="#ff0000" face="verdana" size="4">{{ $orden->codigo }}</font>
                    </td>
                </tr>
                <tr class="notas">
                    <td class="notas" align="center">
                        <b>Fecha: </b>{{ $orden->fecha }} <b>Hora: </b>{{ $orden->horainicio }}
                    </td>
                </tr>
            </table>
        </div>



        <table class="otra">
            <tr>
                <td colspan="2"><b>Cliente: </b>{{ $orden->nomcliente }}</td>
                <td><b>Celular: </b>{{ $orden->celcliente }}</td>
            </tr>
            <tr>
                <td><b>Equipo: </b>{{ $orden->equipo }}</td>
                <td><b>Marca: </b>{{ $orden->marca }}</td>
                <td><b>Modelo: </b>{{ $orden->modelo }}</td>
            </tr>
        </table>

        <table class="otra">
            <tr>
                <td><b>Serial: </b>{{ $orden->serial }}</td>
                <td><b>Cargador: </b>{{ $orden->cargador }}</td>
                <td><b>Bateria: </b>{{ $orden->bateria }}</td>
                <td><b>Otros: </b>{{ $orden->otros }}</td>
            </tr>
        </table>

        <table class="notas">
            <tr>
                <td align="center"><b>Falla Reportada</b></td>
            </tr>
            <tr>
                <td valign="top">{{ $orden->notacliente }}</td>
            </tr>
        </table>

        <table class="notas">
            <tr>
                <td align="center"><b>Observaciones</b></td>
            </tr>
            <tr>
                <td valign="top">{{ $orden->observaciones }}</td>
            </tr>
        </table>


        <table class="otra" style="width: 100%; table-layout: fixed;">
            <tr>
                <td colspan="2" style="width: 50%; padding: 10px; text-align: center; vertical-align: top;">
                    <b>Técnico</b>
                    <br>
                    @if ($user->signature)
                        <div style="text-align: center;">
                            <!-- Definimos un tamaño fijo para la firma -->
                            <img src="{{ public_path('storage/' . $user->signature) }}" alt="Firma" width="150"
                                height="60" style="display: block; margin: 0 auto;">
                        </div>
                    @else
                        <div style="display: block; margin: 0 auto;width:150px; height:60px ;"></div>
                    @endif
                    <div style="text-align: center;">
                        <div style="border-top: 1px solid black; width: 80%; margin: 5px auto;"></div>
                        {{ $orden->tecnico }}
                    </div>
                </td>
                <td colspan="2" style="width: 50%; padding: 10px; text-align: center; vertical-align: top;">
                    <b>Cliente</b>
                    <br>
                    <div style="display: block; margin: 0 auto;width:150px; height:60px ;"></div>
                    <div style="text-align: center;">
                        <div style="border-top: 1px solid black; width: 80%; margin: 5px auto;"></div>
                        {{ $orden->nomcliente }}
                    </div>
                </td>
            </tr>
        </table>


        <p>
            <font size="1"><i>
                    Ley 1480 de 2011, Cap 2 Art 18 - El prestador del servicio lo requerirá para que lo retire dentro de
                    los
                    dos (2) meses siguientes a la remisión de la comunicación.
                    Si el consumidor no lo retira, se entenderá por ley que abandona el bien y el prestador del servicio
                    deberá disponer del mismo conforme con la reglamentación
                    que expida el Gobierno Nacional para el efecto.
                </i></font>
        </p>
    </div>
</body>

</html>
