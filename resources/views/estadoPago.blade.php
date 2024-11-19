<!DOCTYPE html>
<html lang="en">
<head>
    <title>Estado Transacción</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: 'Nunito', sans-serif !important;
        }

        .principal{
            height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .mensaje-aprobacion {
            padding: 10px;
            padding-left: 30px;
            padding-right: 30px;
            border-radius: 10px;
            text-align: center
        }

        .mensaje-aprobado {
            background-color: green !important;
            color: white !important;
        }

        .mensaje-pendiente {
            background-color: orange !important;
            color: white !important;
        }

        .mensaje-rechazado {
            background-color: red !important;
            color: white !important;
        }
       
        .header-detalle {
            border-radius: 6px 6px 0px 0px;
            padding: 8px;
        }

        .header-success {
            background-color: #00800054;
            color: #042b04;
        }

        .header-pending {
            background-color: #fdbb2d8a;
            color: #ff4d22;
        }

        .header-rejected {
            background-color: #ff5d5d8a;
            color: #f30000;
        }

        .detalle-div {
            border-radius: 10px;
            border: 1px solid grey;
        }

        table {
            width: 100%;
        }

        td {
            border: 1px solid grey !important;
            text-align: left !important;
            padding: 3px;
            padding-left: 8px;
            font-size: 13px;
        }

        td strong {
            font-size: 13px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="#" style="display: flex; justify-content: center; align-items: center; font-style: italic; font-size: 12px">
            <img width="50" src="/logo-icp.png" alt="">
            <p style="margin: 0px">Instituto Colombiano <br> de Psicometría</p>
        </a>
    </nav>
    <div class="principal">
        <div style="width: 600px">
           <div class="mensaje-aprobacion {{$claseMensaje}}">
                <i class="fa {{$claseIcono}}" aria-hidden="true"></i><span id="mensaje-aprobacion"> {{$mensajeAprobacion}}</span>
            </div>
            <br>
            <div style="text-align: center">
                <p>{!! $mensajeSecundario !!}</p>
            </div>
            <br>
            <div class="detalle-div">
                <div class="header-detalle {{$headerDetalle}}">
                    <p style="margin: 0px">Detalles de la transacción</p>
                </div>
                <div style="padding: 30px; text-align: center">
                    <table>
                        <tr>
                            <td style="width: 30%"><strong>Estado</strong></td>
                            <td>{!! $estado !!}</td>
                        </tr>
                        <tr>
                            <td style="width: 30%"><strong>Ticket ID</strong></td>
                            <td>{{$tid}}</td>
                        </tr>
                        <tr>
                            <td style="width: 30%"><strong>Orden ID</strong></td>
                            <td>{{$oid}}</td>
                        </tr>
                        <tr>
                            <td style="width: 30%"><strong>Tipo de transacción</strong></td>
                            <td>{{$banco}}</td>
                        </tr>
                        <tr>
                            <td style="width: 30%"><strong>Fecha de Transacción</strong></td>
                            <td>{{$fecha}}</td>
                        </tr>
                        <tr>
                            <td style="width: 30%"><strong>Monto de Transacción</strong></td>
                            <td>$ {{number_format($monto)}}</td>
                        </tr>
                        <tr>
                            <td style="width: 30%"><strong>Descripción</strong></td>
                            <td>{{$descripcion}}</td>
                        </tr>
                    </table>
                    <br>
                    <a href="/" class="btn btn-success"><i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar al comercio </a>
                </div>
            </div> 
        </div>
    </div>
    <footer class="text-center text-white" style="background-color: #343a40;">
    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        <a class="text-white" href="https://mdbootstrap.com/">Instituto Colombiano de Psicometría ICP - Todos los derechos reservados</a>
        © 2024 Copyright:
    </div>
    <!-- Copyright -->
    </footer>
</body>
</html>