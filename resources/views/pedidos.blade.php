<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <style>
        body {
            font-family: 'Nunito', sans-serif !important;
        }

        td, th, table {
            border: 1px solid grey;
            text-align: left;
            padding: 5px
        }

        table {
            width: 100%;
        }

        thead {
            background-color: #0056b3;
            color: white;
        }

        .badge {
            color: white;
        }

        .bg-warning {
            color: black;
        }
    </style>
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
        <div class="alert alert-warning text-center" role="alert">
            <h1>Lista de pedidos</h1>
        </div>
    </div>
    <br><br>
    <div class="container">
        <table id="data-table">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Info Pedido</th>
                    <th>Cliente</th>
                    <th>ID Orden</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody id="data-table tbody">
            </tbody>
        </table>
    </div>
    <br><br><br><br><br>
    

    <!-- Modal de inicio de sesión -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="loginModalLabel">Inicio de Sesión</h5>
        </div>
        <div class="modal-body">
            <form id="loginForm">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div id="errorMessage" class="text-danger d-none">Usuario o contraseña incorrectos.</div>
            <br>
            <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
            </form>
        </div>
        </div>
    </div>
    </div>
    <br>
    
    <!-- Bootstrap JS (opcional para funcionalidad) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <footer class="text-center text-white"
        style="background-color: #343a40; position: fixed; bottom: 0px; width: 100%">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            <a class="text-white" href="https://mdbootstrap.com/">Instituto Colombiano de Psicometría ICP - Todos los
                derechos reservados</a>
            © 2024 Copyright:
        </div>
        <!-- Copyright -->
    </footer>
    <script>
        $(document).ready(function() {
            $('#loginModal').modal('show');

            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); 
                const username = $('#username').val();
                const password = $('#password').val();

                $.ajax({
                    url: '/login-ajax', 
                    type: 'POST',
                    data: {
                    _token: '{{ csrf_token() }}',
                    username: username,
                    password: password
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#loginModal').modal('hide');
                            listarPedidos();
                        } else {
                            $('#errorMessage').removeClass('d-none');
                        }
                    },error: function() {
                        alert('Ocurrió un error, por favor intenta nuevamente.');
                    }
                });
            });
        });

        function listarPedidos(){
            $.ajax({
                url: '/listar-pedidos', 
                type: 'GET',
                success: function(response) {
                    var pedidos = [];
                    const tbody = document.querySelector("#data-table tbody");
                    pedidos = response;

                    let rows = "";
                    if ($.fn.DataTable.isDataTable('#data-table')) {
                        $('#data-table').DataTable().destroy();
                    }
                    tbody.innerHTML = "";
                    
                    pedidos.forEach(item => {
                        let statusBadge = "";
                        switch (item.info.status) {
                            case "pending":
                            case "in_process":
                                statusBadge = `<span class="badge bg-warning">${item.info.status}</span>`;
                                break;
                            case "rejected":
                                statusBadge = `<span class="badge bg-danger">${item.info.status}</span>`;
                                break;
                            case "approved":
                                statusBadge = `<span class="badge bg-success">${item.info.status}</span>`;
                                break;
                            default:
                                statusBadge = `<span class="badge bg-secondary">${item.info.status}</span>`;
                        }
                        rows += `<tr>
                                <td>${statusBadge}</td>
                                <td>
                                    <ul>
                                        <li>#Pines: ${item.pines_comprados}</li>
                                        <li>Vlr. Unitario: ${item.pines_comprados}</li>
                                        <li>Total: $ ${item.precio_pin}</li>
                                        <li>Fecha: ${item.total}</li>
                                    </ul>
                                </td>
                               <td>
                                    <ul>
                                        <li>Nombre: ${item.nombres} ${item.apellidos}</li>
                                        <li>ID: ${item.cedula}</li>
                                        <li>Email: ${item.correo}</li>
                                    </ul>
                                </td>
                                <td>${item.id_orden}</td>
                                <td>
                                    ${item.info.status === "approved" ? `
                                        <button class="btn btn-success" onclick="enviarCredenciales('${item.nombres}', '${item.apellidos}', '${item.cedula}', '${item.correo}', '${item.pines_comprados}', '${item.precio_pin}', '${item.total}', '${item.fecha}', '${item.id_orden}')">
                                            Enviar Credenciales
                                        </button>` : ""
                                    }
                                </td>
                            </tr>`;
                    });
                    
                    tbody.innerHTML = rows;

                    $('#data-table').DataTable({
                        responsive: true,
                        autoWidth: false,
                        language: {
                            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                        }
                    });
                },error: function() {
                    alert('Ocurrió un error, por favor intenta nuevamente.');
                }
            });
        }
    </script>
    <script>

        function enviarCredenciales(nombres, apellidos, cedula, correo, pines_comprados, precio_pin, total, fecha, id_orden){
            Swal.fire({
                title: 'Enviando correo con credenciales',
                html: 'Por favor espera, puede tardar varios segundos...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                    url: '/enviar-credenciales', 
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        nombres: nombres,
                        apellidos: apellidos,
                        cedula: cedula,
                        correo: correo,
                        pines_comprados: pines_comprados,
                        precio_pin: precio_pin,
                        fecha: fecha,
                        total: total,
                        id_orden: id_orden
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            listarPedidos();
                        }else{
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: response.message,
                                text: response.response,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },error: function() {
                        alert('Ocurrió un error, por favor intenta nuevamente.');
                    }
                });
        }
    </script>
</body>
</html>