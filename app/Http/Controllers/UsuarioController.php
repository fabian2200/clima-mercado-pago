<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\TerminarPagoController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function loginAjax(Request $request){
        $staticUsername = 'admin';
        $staticPassword = 'password123';

        if ($request->username === $staticUsername && $request->password === $staticPassword) {
            $pedidos = new TerminarPagoController();
            $pedidos_lista = $pedidos->listarPedidos();
            return response()->json(['success' => true, 'pedidos' => $pedidos_lista]);
        }

        return response()->json(['success' => false]);
    }

    public function enviarCredenciales(Request $request){
        $data = [
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'cedula' => $request->cedula,
            'correo' => $request->correo,
            'pines_comprados' => $request->pines_comprados,
            'precio_pin' => $request->precio_pin,
            'fecha' => $request->fecha,
            'total' => $request->total,
        ];
    
        $apiUrl = 'https://clima.institutocolombianodepsicometria.com/api/enviar-credenciales'; 
    
        $response = Http::post($apiUrl, $data);
    
        if ($response[1] == 0) {
            $id_orden = $request->id_orden;
            DB::table('pedidos')
            ->where("id_orden" , $id_orden)
            ->update([
                'estado' => 1
            ]);
            return response()->json(['success' => true, 'message' => 'Datos enviados correctamente', 'response' => $response->json()], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Error al enviar datos', 'response' => $response[0]], 200);
        }
    }
}
