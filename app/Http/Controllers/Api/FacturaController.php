<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FacturaController extends Controller
{
    public function getAllDataInvoice(Request $request)

    {
        $id_account = $request->only('id_account');

        $dataAccount = DB::table('account')
        ->join('sales', 'sales.id', '=', 'account.id_sale')
        ->where('account.id', '=', $id_account)
        ->select('account.id', 'sales.id as id_sale', 'account.name_user', 'sales.folio', 'sales.total', 'sales.date_sale')
        ->get()
        ->first();


        $dataSalesDetail = DB::table('sales')
        ->join('sales_detail','sales_detail.id_sales', '=', 'sales.id' )
        ->where('sales.id', '=', $dataAccount->id_sale)
        ->select('sales_detail.amount', 'sales_detail.label_commercial_product')
        ->get();

        if ($dataAccount) {
            return response()->json([
                'message' => 'Si hay datos',
                'DataAccount' => $dataAccount,
                'DataSalesDetail' => $dataSalesDetail
            ], Response::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'No hay datos',
            ], 401);
        }

    }
}
