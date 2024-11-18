<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TerminarPagoController;

use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/metodos-pago', [TerminarPagoController::class, 'listarMetodosPago'])->name('listarMetodosPago');
Route::get('/estado-pago', [TerminarPagoController::class, 'estadoPago'])->name('estadoPago');

Route::get('/formulario-pago', function () {
    // Definir valores
    $cantidad_pines = 20;
    $valor_pin = 100;
    $total = $cantidad_pines * $valor_pin;
    $desc_servicio = "Venta de pines - clima";

    // Pasar valores a la vista
    return view('formularioPagoTarjeta', compact('cantidad_pines', 'valor_pin', 'total', 'desc_servicio'));
})->name('formularioPagoTarjeta');

Route::post('/procesar-pago', [TerminarPagoController::class, 'TerminarPago'])->name('TerminarPago');
Route::post('/procesar-pago-tarjeta', [TerminarPagoController::class, 'TerminarPagoTarjeta'])->name('TerminarPagoTarjeta');


Route::get('/pagina-error', function () {
    return view('errorPage');
})->name('error.page');

Route::get('/', function () {
         
    $paquetes = DB::connection("mysql")->table("paquetes")
    ->get();
    
    return view('paquetes', compact('paquetes'));
})->name('paquetes');