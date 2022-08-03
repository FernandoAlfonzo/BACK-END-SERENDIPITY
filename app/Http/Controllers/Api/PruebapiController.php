<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class PruebapiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function pruebas()
    
    {
            $payment = DB::table('payment')
            ->join('payment_detail', 'payment.id', '=', 'payment_detail.id_payment')
            ->join('account_calendar_detail', 'account_calendar_detail.id', '=', 'payment_detail.id_account_calendar_detail')
            ->join('account', 'account_calendar_detail.id_account', '=', 'account.id')
            ->join('sales', 'sales.id', '=', 'account.id_sale')
            ->where('payment.status', '=', 'Identificado')
            ->where('payment.is_active', '=', 1)
            ->where('payment_detail.is_active', '=', 1)
            ->where('account_calendar_detail.is_active', '=', 1)
            ->where('account.is_active', '=', 1)
            ->where('sales.is_active', '=', 1)
            // ->select('payment.*', 'account_calendar_detail.*', 'account.*')
            ->get();
            
        if ($payment) {
            return response()->json([
            
                'message' => "test correcto",
                'data' => $payment
             ], Response::HTTP_OK);

               }else{

            return response()->json([

                    'message' => "test erroneo",
                ], 401);
        }
    }
}