<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\cat_catalog;

class CatalogController extends Controller
{
    public function getCatalogByCode(Request $request)
    {   
       if ($request['code']) {
            $subcatalogs = cat_catalog::where('code', $request['code'])
            ->where('is_active', 1)
            ->get()
            ->first();

            if ($subcatalogs->count()>0) {
                return response()->json([
                    'message' => 'Catalogos obtenidos ',
                    'list_catalog' => json_encode($subcatalogs)
                ], Response::HTTP_OK);
            }
            
       }
       return response()->json(['error' => 'Error'], 400);
     
    }
}

// 1