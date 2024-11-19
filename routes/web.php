<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TerminarPagoController;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/metodos-pago', [TerminarPagoController::class, 'listarMetodosPago'])->name('listarMetodosPago');
Route::get('/estado-pago', [TerminarPagoController::class, 'estadoPago'])->name('estadoPago');

Route::get('/formulario-pago', function (Request $request) {
    $id_paquete = $request->input('id_paquete'); 

    $paquete = DB::connection("mysql")->table("paquetes")
    ->where("id", $id_paquete)
    ->first();

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
    return view('formularioPagoTarjeta', compact('cantidad_pines', 'valor_pin', 'total', 'desc_servicio', 'descuento', 'nombre'));
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