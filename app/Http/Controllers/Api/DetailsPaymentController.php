<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Student;

class DetailsPaymentController extends Controller
{
    public function PaymentsDetails(Request $request)
    {
        $id_user = $request->only('id_user');

        $account = DB::table('account')
        ->join('sales','sales.id', '=', 'account.id_sale')
        ->where('account.id_user', '=', $id_user)
        ->select('account.*', 'sales.folio', 'sales.date_sale')
        ->get();

        if ($account) {
            return response()->json([
            
                'message' => "Datos Correctos",
                'data' => $account
             ], Response::HTTP_OK);

               }else{

            return response()->json([

                    'message' => "No hay Datos",
                ], 401);
        }
    }
}
