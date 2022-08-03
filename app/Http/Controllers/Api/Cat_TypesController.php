<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\cat_catalog;
use App\Models\cat_type;
use Illuminate\Support\Facades\DB;


class Cat_TypesController extends Controller
{
    public function getCat_typeByCode(Request $request)
    {   
       if ($request['code']) {
            $catalogs = cat_type::where('code', $request['code'])
            ->where('is_active', 1)
            ->get()
            ->first();
            
            if ($catalogs->count()>0) {
                return response()->json([
                    'message' => 'Catalogos obtenidos ',
                    'list_catalog' => $catalogs
                ], Response::HTTP_OK);
            }
            
       }
       return response()->json(['error' => 'Error'], 400);
     
    }

    public function getAllMethodPayment(Request $request)
    {

        $methodPayments = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types',)
        ->where('cat_types.code', '=', 'SYST_PAYMENT')
        ->select('cat_catalogs.id','cat_catalogs.code')
        ->get();

        if ($methodPayments) {
            return response()->json([
                'message' => 'Si hay metodos de pago',
                'CatalogPagos' => $methodPayments
            ], Response::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'No hay metodos de pago',
            ], 401);
    }
}


// getallcatalogbycodecattype
}

// 1