<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailController extends Controller
{
    public function enviarCorreo($tipo, $email, $nombres_apellidos, $pines, $precio, $total, $id_orden) {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'mail.pvtocewe.lucusvirtual.es';
            $mail->SMTPAuth = true;
            $mail->Username = '_mainaccount@pvtocewe.lucusvirtual.es';
            $mail->Password = 'J(1m7C1mn-0aYB';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            
            $mail->setFrom('_mainaccount@pvtocewe.lucusvirtual.es', 'Instituto Colombiano de Psicometria');
            
    
            $mail->isHTML(true);
            $subject = 'Pedido Recibido - ICP';
            $encoded_subject = mb_encode_mimeheader($subject, 'UTF-8');
            $mail->Subject = $encoded_subject;

            if($tipo == 1){
                $mail->addAddress("fabiandresquintero315@gmail.com", 'Instituto Colombiano de Psicometria');
                $mail->Body = self::mapearPlantilla();
            }else{
                $mail->addAddress($email, $nombres_apellidos);
                $mail->Body = self::mapearPlantilla2($email, $nombres_apellidos, $pines, $precio, $total, $id_orden);
            }
           
            $mail->send();
            return "Correo enviado correctamente!";
        } catch (Exception $e) {
            return "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function mapearPlantilla(){

        $url_base = url('/'); 
        $url_base = $url_base."/pedidos";

        return  "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
             <html xmlns='http://www.w3.org/1999/xhtml'>
             <head>
                 <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                 <meta name='viewport' content='width=device-width, initial-scale=1' />
                 <title>Narrative Invitation Email</title>
                 <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
                 <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
                 <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js'></script>
                 <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
                 <style type='text/css'>
 
                 /* Take care of image borders and formatting */
 
                 img {
                 max-width: 600px;
                 outline: none;
                 text-decoration: none;
                 -ms-interpolation-mode: bicubic;
                 }
 
                 a {
                 border: 0;
                 outline: none;
                 }
 
                 a img {
                 border: none;
                 }
 
                 /* General styling */
 
                 td, h1, h2, h3  {
                 font-family: Helvetica, Arial, sans-serif;
                 font-weight: 400;
                 }
 
                 td {
                 font-size: 13px;
                 line-height: 19px;
                 text-align: left;
                 }
 
                 body {
                 -webkit-font-smoothing:antialiased;
                 -webkit-text-size-adjust:none;
                 width: 100%;
                 height: 100%;
                 color: #37302d;
                 background: #ffffff;
                 }
 
                 table {
                 border-collapse: collapse !important;
                 }
 
 
                 h1, h2, h3, h4 {
                 padding: 0;
                 margin: 0;
                 color: #444444;
                 font-weight: 400;
                 line-height: 110%;
                 }
 
                 h1 {
                 font-size: 35px;
                 }
 
                 h2 {
                 font-size: 30px;
                 }
 
                 h3 {
                 font-size: 24px;
                 }
 
                 h4 {
                 font-size: 18px;
                 font-weight: normal;
                 }
 
                 .important-font {
                 color: #21BEB4;
                 font-weight: bold;
                 }
 
                 .hide {
                 display: none !important;
                 }
 
                 .force-full-width {
                 width: 100% !important;
                 }
 
                 </style>
 
                 <style type='text/css' media='screen'>
                     @media screen {
                     @import url(http://fonts.googleapis.com/css?family=Open+Sans:400);
 
                     /* Thanks Outlook 2013! */
                     td, h1, h2, h3 {
                         font-family: 'Open Sans', 'Helvetica Neue', Arial, sans-serif !important;
                     }
                     }
                 </style>
             </head>
             <body class='body' style='padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none' bgcolor='#ffffff'>
             <div style='padding: 2%; text-align: center'>
                 <img style='width: 114px' src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTMH35LoELuTjL6_P4iBqIDza9nfGfKw-tT2kGv0f1cnA&s' width = '60%' alt='Your Logo'/>
             </div>
             <div class='row' style='padding-top: 20px'>
                 <div class='col-lg-9' style= 'padding-left: 10%; padding-right: 10%;border-right: 3px solid gray;border-left: 3px solid gray;'>
                    <h3><b>Pedido recibido</b></h3>
                    <h3>Cordial saludo, Antonio </h4>
                    <br><br><br>
                    <h3 style='font-weight: bold'>Haz recibido un nuevo pedido, para ver los detalles, da click en el siguiente botón</h3>
                    <hr>
                    <br>
                    <div style='width: 100%; text-align: center'>
                        <a href='$url_base' style='font-size: 20px; width: auto; padding: 10px; border-radius: 10px; background-color: #ff6815; color: #ffff' style='font-weight: bold; margin: 4px;'>Ver pedidos</a>
                    </div>
                    <br>
                 </div>
             </div>
             </body>
         </html>";
    }

    public function mapearPlantilla2($email, $nombres_apellidos, $pines, $precio, $total, $id_orden){
        $url_base = url('/'); 
        return  "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
             <html xmlns='http://www.w3.org/1999/xhtml'>
             <head>
                 <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                 <meta name='viewport' content='width=device-width, initial-scale=1' />
                 <title>Narrative Invitation Email</title>
                 <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
                 <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
                 <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js'></script>
                 <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
                 <style type='text/css'>
 
                 /* Take care of image borders and formatting */
 
                 img {
                 max-width: 600px;
                 outline: none;
                 text-decoration: none;
                 -ms-interpolation-mode: bicubic;
                 }
 
                 a {
                 border: 0;
                 outline: none;
                 }
 
                 a img {
                 border: none;
                 }
 
                 /* General styling */
 
                 td, h1, h2, h3  {
                 font-family: Helvetica, Arial, sans-serif;
                 font-weight: 400;
                 }
 
                 td {
                 font-size: 13px;
                 line-height: 19px;
                 text-align: left;
                 }
 
                 body {
                 -webkit-font-smoothing:antialiased;
                 -webkit-text-size-adjust:none;
                 width: 100%;
                 height: 100%;
                 color: #37302d;
                 background: #ffffff;
                 }
 
                 table {
                 border-collapse: collapse !important;
                 }
 
 
                 h1, h2, h3, h4 {
                 padding: 0;
                 margin: 0;
                 color: #444444;
                 font-weight: 400;
                 line-height: 110%;
                 }
 
                 h1 {
                 font-size: 35px;
                 }
 
                 h2 {
                 font-size: 30px;
                 }
 
                 h3 {
                 font-size: 24px;
                 }
 
                 h4 {
                 font-size: 18px;
                 font-weight: normal;
                 }
 
                 .important-font {
                 color: #21BEB4;
                 font-weight: bold;
                 }
 
                 .hide {
                 display: none !important;
                 }
 
                 .force-full-width {
                 width: 100% !important;
                 }
 
                 </style>
 
                 <style type='text/css' media='screen'>
                     @media screen {
                     @import url(http://fonts.googleapis.com/css?family=Open+Sans:400);
 
                     /* Thanks Outlook 2013! */
                     td, h1, h2, h3 {
                         font-family: 'Open Sans', 'Helvetica Neue', Arial, sans-serif !important;
                     }
                     }
                 </style>
 
                 <style type='text/css' media='only screen and (max-width: 600px)'>
                 /* Mobile styles */
                 @media only screen and (max-width: 600px) {
 
                     table[class='w320'] {
                     width: 320px !important;
                     }
 
                     table[class='w300'] {
                     width: 300px !important;
                     }
 
                     table[class='w290'] {
                     width: 290px !important;
                     }
 
                     td[class='w320'] {
                     width: 320px !important;
                     }
 
                     td[class~='mobile-padding'] {
                     padding-left: 14px !important;
                     padding-right: 14px !important;
                     }
 
                     td[class*='mobile-padding-left'] {
                     padding-left: 14px !important;
                     }
 
                     td[class*='mobile-padding-right'] {
                     padding-right: 14px !important;
                     }
 
                     td[class*='mobile-padding-left-only'] {
                     padding-left: 14px !important;
                     padding-right: 0 !important;
                     }
 
                     td[class*='mobile-padding-right-only'] {
                     padding-right: 14px !important;
                     padding-left: 0 !important;
                     }
 
                     td[class*='mobile-block'] {
                     display: block !important;
                     width: 100% !important;
                     text-align: left !important;
                     padding-left: 0 !important;
                     padding-right: 0 !important;
                     padding-bottom: 15px !important;
                     }
 
                     td[class*='mobile-no-padding-bottom'] {
                     padding-bottom: 0 !important;
                     }
 
                     td[class~='mobile-center'] {
                     text-align: center !important;
                     }
 
                     table[class*='mobile-center-block'] {
                     float: none !important;
                     margin: 0 auto !important;
                     }
 
                     *[class*='mobile-hide'] {
                     display: none !important;
                     width: 0 !important;
                     height: 0 !important;
                     line-height: 0 !important;
                     font-size: 0 !important;
                     }
 
                     td[class*='mobile-border'] {
                     border: 0 !important;
                     }
                 }
                 </style>
             </head>
             <body class='body' style='padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none' bgcolor='#ffffff'>
             <div style='padding: 2%; text-align: center'>
                 <img style='width: 114px' src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTMH35LoELuTjL6_P4iBqIDza9nfGfKw-tT2kGv0f1cnA&s' width = '60%' alt='Your Logo'/>
             </div>
             <div class='row' style='padding-top: 20px'>
                 <div class='col-lg-9' style= 'padding-left: 10%; padding-right: 10%;border-right: 3px solid gray;border-left: 3px solid gray;'>
                     <h3><b>Pedido Recibido</b></h3>
                     <br>
                     <h4>Cordial saludo $nombres_apellidos:</h4>
                     <br>
                     <h4 style='text-align: justify;'>Hemos recibido tu pedido, estamos en proceso de verificación, una vez hayamos verificado tu pago, te enviaremos los datos de acceso a esta misma dirección de correo electrónico.</h4>
                     <br>
                     <h4>Para consultar el estado de tu pedido ve al siguiente <a href='$url_base'>enlace</a> da click en el botón (estado de compra) e ingresa el siguiente ID de orden: <span style='color: red'> ($id_orden)</span></h4>
                     <hr>
                     <br>
                     <h4>Resumen de su compra</h4>
                     <br>
                     <table style='width: 100% !important; border: 1px solid;'>
                     <tr style='border: 1px solid;'>
                     <td style='font-weight: bold; border: 1px solid;'>Pines Comprados</td>
                     <td style='font-weight: bold; border: 1px solid;'>Precio Pin</td>
                     <td style='font-weight: bold; border: 1px solid;'>Total</td>
                     </tr>
                     <tr style='border: 1px solid;'>
                     <td style='font-weight: bold; border: 1px solid;'>$pines</td>
                     <td style='font-weight: bold; border: 1px solid;'>$ $precio</td>
                     <td style='font-weight: bold; border: 1px solid;'>$ $total</td>
                     </tr>
                     </table>
                     <br>
                     <h4 style='text-align:justify;'>De antemano agradecemos la confianza depositada en nosotros.</h4>
                     <br>
                     <h4>Atentamente</b></h4>
                     <br>
                     <p style='margin: 4px;'>Instituto Colombiano de Psicometría.</p>
                     <p style='margin: 4px;'>Ps. Mgr. Antonio Martínez, Gerente</p>
                     <p style='margin: 4px;'>Correo: incolpsicometria@gmail.com - Celular (WhatsApp): 3012990890</p>
                 </div>
             </div>
             </body>
         </html>";
     }
}
