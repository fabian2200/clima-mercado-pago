<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TerminarPagoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/metodos-pago', [TerminarPagoController::class, 'listarMetodosPago'])->name('listarMetodosPago');
Route::get('/estado-pago', [TerminarPagoController::class, 'estadoPago'])->name('estadoPago');

Route::get('/', function () {
         
    $apiUrl = "https://pruebaclima.climalaborald10.com/api/listar-paquetes";

    $response = Http::get($apiUrl);

    if ($response->successful()) {
        $paquetes = collect($response->json())->map(function ($paquete) {
            return (object) $paquete; 
        });
    } else {
        $paquetes = collect([]);
    }
        
    return view('paquetes', compact('paquetes'));
})->name('paquetes');

Route::get('/formulario-pago', function (Request $request) {
    $id_paquete = $request->input('id_paquete'); 

    $apiUrl = "http://pruebaclima.climalaborald10.com/api/buscar-paquete?id_paquete=" . $id_paquete;
    $response = Http::get($apiUrl);

    if ($response->successful()) {
        $paquete = $response->object();
    }else{
        $paquete = null;
    }

    if($paquete){
        $cantidad_pines = $paquete->numero_pines; 
        $valor_pin = $paquete->precio_pin;  
        $descuento = $paquete->descuento; 
        $total = $paquete->total; 
        $desc_servicio = $request->input('desc_servicio', 'Venta de pines'); 
        $nombre = $paquete->nombre;
    }else{
        $cantidad_pines = 0; 
        $valor_pin = 0; 
        $descuento =0; 
        $total = 0;
        $desc_servicio = "Venta de pines"; 
        $nombre = "paquete no encontrado";
    }
    return view('formularioPagoTarjeta', compact('cantidad_pines', 'valor_pin', 'total', 'desc_servicio', 'descuento', 'nombre', 'id_paquete'));
})->name('formularioPagoTarjeta');

Route::post('/procesar-pago', [TerminarPagoController::class, 'TerminarPago'])->name('TerminarPago');
Route::post('/procesar-pago-tarjeta', [TerminarPagoController::class, 'TerminarPagoTarjeta'])->name('TerminarPagoTarjeta');


Route::get('/pagina-error', function () {
    return view('errorPage');
})->name('error.page');


Route::get('/pedidos', function () {
    return view('pedidos');
})->name('paquetes');

Route::get('/listar-pedidos', [TerminarPagoController::class, 'listarPedidos'])->name('listarPedidos');
Route::post('/login-ajax', [UsuarioController::class, 'loginAjax'])->name('loginAjax');
Route::post('/enviar-credenciales', [UsuarioController::class, 'enviarCredenciales'])->name('enviarCredenciales');