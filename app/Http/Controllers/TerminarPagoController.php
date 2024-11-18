<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\PaymentMethod\PaymentMethodClient;
use MercadoPago\Exceptions\MPApiException;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Str;

class TerminarPagoController extends Controller
{
    public function __construct(Type $var = null) {
        MercadoPagoConfig::setAccessToken($_ENV['MP_ACCESS_TOKEN']);
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
    }

    function listarMetodosPago(){
        $client = new PaymentMethodClient();
        $payment_methods = $client->list();
        $payment_methods = json_decode(json_encode($payment_methods), true);
        return response()->json($payment_methods["data"]);
    }

    public function TerminarPago(Request $request){
        $client = new PaymentClient();
        $request_options = new RequestOptions();
        $idempotencyKey = Str::random(25);
        $request_options->setCustomHeaders(["X-Idempotency-Key: $idempotencyKey"]);
    
        $client = new PaymentClient();
        
        $createRequest = [
            "transaction_amount" => 1000,//(double) $request->input('transactionAmount'),
            "description" =>  $request->input('description'),
            "payment_method_id" => "pse",
            "callback_url" => $_ENV['CALLBACK_URL'],
            "notification_url" => $_ENV['CALLBACK_URL'],
            "additional_info" => [
                "ip_address" => $request->ip(),
            ],
            "transaction_details" => [
                "financial_institution" => $request->input('financialInstitution'),
            ],
            "payer" => [
                "email" => $request->input('email'),
                "entity_type" => "individual",
                "first_name" => $request->input('firstName'),
                "last_name" => $request->input('lastName'),
                "identification" => [
                    "type" => $request->input('identificationType'),
                    "number" => $request->input('identificationNumber'),
                ],
                "address" => [
                    "zip_code" => $request->input('zipCode'),
                    "street_name" => $request->input('streetName'),
                    "street_number" => $request->input('streetNumber'),
                    "neighborhood" => $request->input('neighborhood'),
                    "city" => $request->input('city'),
                    "federal_unit" => $request->input('federalUnit'),
                ],
                "phone" => [
                    "area_code" => $request->input('phoneAreaCode'),
                    "number" => $request->input('phoneNumber'),
                ],
            ],
        ];

        try {
            $payment = $client->create($createRequest, $request_options);
            return redirect($payment->transaction_details->external_resource_url);
        } catch (MPApiException $e) {
            $errorMessage = $e->getMessage();
            $statusCode = $e->getStatusCode();
            $apiResponse = $e->getApiResponse();
        
            return redirect()->route('error.page')->with([
                'errorMessage' => $errorMessage,
                'statusCode' => $statusCode,
                'apiResponse' => $apiResponse,
            ]);
        }
    }

    public function TerminarPagoTarjeta(Request $request){
        $data = $request->all();

        if (
            !isset(
                $data['transactionAmount'], $data['token'], $data['description'], $data['installments'],
                $data['paymentMethodId'], $data['payer']['email'], 
                $data['payer']['identification']['type'], $data['payer']['identification']['number']
            )
        ) {
            return response()->json(['error' => 'Faltan datos requeridos en la solicitud.'], 400);
        }

        $client = new PaymentClient();
        $request_options = new RequestOptions();
        $idempotencyKey = Str::random(32);
        $request_options->setCustomHeaders(["X-Idempotency-Key: $idempotencyKey"]);

        $payment = $client->create([
            'transaction_amount' => (float) $data['transactionAmount'],
            'token' => $data['token'],
            'description' => $data['description'],
            'installments' => (int) $data['installments'],
            'payment_method_id' => $data['paymentMethodId'],
            'issuer_id' => $data['issuerId'] ?? null,
            'payer' => [
                'email' => $data['payer']['email'],
                'identification' => [
                    'type' => $data['payer']['identification']['type'],
                    'number' => $data['payer']['identification']['number'],
                ],
            ],
        ], $request_options);

        return response()->json($payment);
    }

    public function estadoPago(Request $request){
        $client = new PaymentClient();
        $id = $request->query('payment_id');
        $payment = $client->get($id);
        
        $payment = json_decode(json_encode($payment), true);

        $client2 = new PaymentMethodClient();
        $payment_methods = $client2->list();
        $payment_methods = json_decode(json_encode($payment_methods), true);

        $payment_methods = $payment_methods["data"];

        $payment_method = null;

        foreach ($payment_methods as $method) {
            if ($method['id'] == $payment["payment_method_id"]) {
                $payment_method = $method;
            }
        }

        if($payment["payment_type_id"] == "prepaid_card"){
            $banco = "tarjeta de crédito / débito ".$payment_method["name"];
            $tid = $payment["collector_id"];
        }else{
            $banco = $payment_method["name"];
            $tid = $payment["transaction_details"]["transaction_id"];
        }
        
        $oid = $payment["id"];
        $fecha = $payment["date_created"];
        $monto = $payment["transaction_amount"];
        $descripcion = $payment["description"];

        switch ($payment["status"]) {
            case 'approved':
                $estado = "<strong style='color: green; margin: 0px;'>Aprobada!</strong>";
                $claseIcono = "fa-check-circle";
                $claseMensaje = "mensaje-aprobado";
                $mensajeAprobacion = "Su orden fue finalizada con éxito y se encuentra aproada";
                $mensajeSecundario = "Su orden sera aprobada una vez realizado el pago, si ya hizo el pago en minutos recibirá un mail con la aprobación y los detalles de su orden";
                $headerDetalle = "header-success";
                break;
            case 'pending':
                $estado = "<strong style='color: #ff5500; margin: 0px;'>Pendiente!</strong>";
                $claseIcono = "fa-check-circle";
                $claseMensaje = "mensaje-pendiente";
                $mensajeAprobacion = "Su orden fue finalizada con éxito y se encuentra en proceso";
                $mensajeSecundario = "Su orden sera aprobada una vez realizado el pago, si ya hizo el pago en minutos recibirá un mail con la aprobación y los detalles de su orden";
                $headerDetalle = "header-pending";
                break;
            case 'in_process':
                $estado = "<strong style='color: #ff5500; margin: 0px;'>Pendiente de pago!</strong>";
                $claseIcono = "fa-check-circle";
                $claseMensaje = "mensaje-pendiente";
                $mensajeAprobacion = "Su orden fue finalizada con éxito y se encuentra en proceso";
                $mensajeSecundario = "Su orden sera aprobada una vez realizado el pago, si ya hizo el pago en minutos recibirá un mail con la aprobación y los detalles de su orden";
                $headerDetalle = "header-pending";
                break;
            case 'rejected':
                $estado = "<strong style='color: #ff0000; margin: 0px;'>Pago rechazado!</strong>";
                $claseIcono = "fa-check-circle";
                $claseMensaje = "mensaje-rechazado";
                $mensajeAprobacion = "Su orden no ha sido aprobada, inténtelo nuevamente";
                $mensajeSecundario = "Te invitamos a intentarlo nuevamente, para mas información, por favor comuníquese con nuestros canales de atención al cliente. <br> Teléfono(s): +57 301 2990890";
                $headerDetalle = "header-rejected";
                break;
            default:
                # code...
                break;
        }

        return view('estadoPago', compact(
            'estado',
            'claseIcono',
            'mensajeAprobacion',
            'claseMensaje',
            'mensajeSecundario',
            'headerDetalle',
            'banco',
            'tid',
            'oid',
            'fecha',
            'monto',
            'descripcion'
        ));
    }
}
