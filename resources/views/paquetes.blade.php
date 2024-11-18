<!DOCTYPE html>
<html lang="en">

<head>
    <title>ICP - Paquetes</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <link rel="stylesheet" href="{{ asset('css/estilo_page_card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/planes.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    body {
        font-family: 'Nunito', sans-serif !important;
    }

    .navbar-dark .navbar-nav .nav-link:hover {
        color: rgba(0, 0, 0, .75);
    }

    .principal {
        width: 100%;
        height: 75vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    div:where(.swal2-container) .swal2-input {
        padding: .5em !important;
        height: auto !important;
        font-size: 20px !important;
    }

    .badge-desc {
        background-color: #db7005;
        color: white;
        padding: 5px;
        font-size: 15px;
        width: fit-content;
        border-radius: 12px;
    }

    footer {
        padding: 1.5% 10% 1% 10%;
        margin: 0 auto;
        position: absolute;
        width: 100%;
        bottom: 0;
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
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02"
            aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" style="justify-content: end;">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <button onclick="buscarPedido()" style="margin-left: 10px"
                        class="nav-link btn btn-outline-light my-2 my-sm-0" href="#"> <i class="fa fa-shopping-cart"
                            aria-hidden="true"></i> Estado Compra</button>
                </li>
            </ul>
        </div>
    </nav>
    <div class="principal">
        <div class="row" style="width: 100%">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <div class="row" style="margin-left: -2px; margin-right: 0px">
                    @foreach ($paquetes as $paquete)
                        <div class="col-lg-4">
                            <div class="package package_free">
                                <h2 style="text-transform: capitalize;">{{$paquete->nombre}}</h2>
                                <ul>
                                    <li>{{$paquete->numero_pines}} Pines</li>
                                    <li><strong>Precio x PIN: </strong>${{number_format($paquete->precio_pin)}}</li>
                                    @if($paquete->descuento > 0)
                                        <li>
                                            <div class="badge-desc">{{$paquete->descuento}}% de Descuento</div> 
                                        </li>
                                    @endif
                                </ul>
                                <div class="price">$<div class="big">{{number_format($paquete->total)}}</div></div>
                                <button>Comprar Paquete <i class="fa fa-shopping-cart" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    @endforeach 
                </div>
            </div>
            <div class="col-lg-1"></div>
        </div>
    </div>
    <footer class="text-center text-white" style="background-color: #343a40;">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            <a class="text-white" href="https://mdbootstrap.com/">Instituto Colombiano de Psicometría ICP - Todos los
                derechos reservados</a>
            © 2024 Copyright:
        </div>
        <!-- Copyright -->
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    function buscarPedido() {
        Swal.fire({
            title: 'Consultar Estado del Pedido',
            input: 'text',
            inputLabel: 'Ingrese el ID del pedido:',
            inputPlaceholder: 'ID del pedido',
            showCancelButton: true,
            confirmButtonText: 'Buscar',
            cancelButtonText: 'Cancelar',
            inputValidator: (value) => {
                if (!value) {
                    return 'Debe ingresar un ID!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const baseurl = `${window.location.origin}`;
                const payment_id = result.value;
                const redirectUrl = `${baseurl}/estado-pago?payment_id=${payment_id}`;
                window.location.href = redirectUrl;
            }
        });
    }
    </script>
</body>

</html>