<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error en el Pago</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="#"
            style="display: flex; justify-content: center; align-items: center; font-style: italic; font-size: 12px">
            <img width="50" src="/logo-icp.png" alt="">
            <p style="margin: 0px">Instituto Colombiano <br> de Psicometría</p>
        </a>
    </nav>
    <div class="container mt-5">
        <div class="alert alert-danger text-center" role="alert">
            <h1>Error en el Pago</h1>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Detalles del Error</h5>
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Mensaje:</strong> {{ session('errorMessage') }}
                    </li>
                    <li class="list-group-item">
                        <strong>Código de Estado:</strong> {{ session('statusCode') }}
                    </li>
                </ul>
                <a href="/formulario-pago" class="btn btn-primary mt-3">Regresar al Inicio</a>
            </div>
        </div>
    </div>
    <br>
    <!-- Bootstrap JS (opcional para funcionalidad) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <footer class="text-center text-white"
        style="background-color: #343a40; position: absolute; bottom: 0px; width: 100%">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            <a class="text-white" href="https://mdbootstrap.com/">Instituto Colombiano de Psicometría ICP - Todos los
                derechos reservados</a>
            © 2024 Copyright:
        </div>
        <!-- Copyright -->
    </footer>
</body>

</html>