<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Student;
use App\Models\Notification;
use App\Models\Rsc_file;
use App\Models\cat_catalog;
use Str;

class PaymentsController extends Controller
{
    public function Payments(Request $request)
    {
            
            $id_account = $request->only('id_account');

            $payment = DB::table('account')
            ->join('account_calendar_detail', 'account_calendar_detail.id_account', '=', 'account.id')
            ->join('payment_detail', 'payment_detail.id_account_calendar_detail', '=', 'account_calendar_detail.id')
            ->join('payment', 'payment.id', '=', 'payment_detail.id_payment')
            ->where('account.id', '=', $id_account)
            ->select('account_calendar_detail.*', 'payment.payment_type_name')
            ->get();
    
            
        if ($payment) {
            return response()->json([
            
                'message' => "Datos Correctos",
                'data' => $payment
             ], Response::HTTP_OK);

               }else{

            return response()->json([
                    'message' => "No hay Datos",
                ], 401);
        }
    }

    public function saveImgPayment(Request $request)
    {
         try {
            $base64Img = $request['base64Img'];
            $id_user = $request['id_user'];
            
             // extract image data from base64 data string
             $pattern = '/data:image\/(.+);base64,(.*)/';
             preg_match($pattern, $base64Img, $matches);
             // image file extension
             $imageExtension = $matches[1];
             // base64-encoded image data
             $encodedImageData = $matches[2];
             // decode base64-encoded image data
             $decodedImageData = base64_decode($encodedImageData);
             // save image data as file
             $name  = uniqid();
             $img = file_put_contents("paymentFoto/{$name}.{$imageExtension}", $decodedImageData);
             $pathSave = "paymentFoto/{$name}.{$imageExtension}";
            
            Rsc_file::create([
                'id_user' => $id_user,
                'content_type'=> $imageExtension,
                'default_file' => 1,
                'extention' => $imageExtension,
                'is_blob' => 0,
                'path_file' => $pathSave,
                'is_downloadable' => 1,
                'is_image' => 1,
                'is_private' => 0,
                'is_active'=> 1,
            ]);

            
            $subcatalogs = cat_catalog::where('code', 'SYS_PAYMENT_TICKET')
            ->where('is_active', 1)
            ->get()
            ->first();

            Notification::create([
                'id_user' => $id_user,
                'label' => 'Documento para aplicar un pago',
                'description'  => 'Imagen para aplicaar un pago a alumno',
                'cat_type_notification_id' => $subcatalogs->id,
                'cat_type_notification_code'=> $subcatalogs->code,
                'cat_type_notification_label'=> $subcatalogs->label,
                'is_view' => 0,
                'is_private' => 0,
                'is_active' => 1,
             ]);

             return response()->json([
                'message' => "Guardo la imagen"
             ], Response::HTTP_OK);
         } catch (\Throwable $th) {
            return response()->json([
                'message' => "Ocurrio un error",
                'Error' => $th
            ], 401);
         }
    }
}
