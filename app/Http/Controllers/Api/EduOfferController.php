<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\type_service;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EduOfferController extends Controller
{
    public function getAllService()
    {
        $type_services = type_service::where('is_active', 1)
        ->orderBy('id', 'asc')
        ->get();

        if ($type_services) {
            return response()->json([
                'message' => 'Datos de Servicio',
                'DataService' => $type_services
            ], Response::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'No hay Servicios',
            ], 401);
        }
    }

    public function getOferByIdService(Request $request)
    {
        $id_service = $request->only('id_service');

        $type_services=DB::table('type_service')
            ->Leftjoin('commercial_product', 'commercial_product.id_type', '=', 'type_service.id')
            ->join('generations', 'generations.id_service', '=', 'commercial_product.id')
            ->where('type_service.id', '=', $id_service)
            ->where('generations.is_active', '=', 1)
            ->select('generations.*', 'commercial_product.url_image', 'commercial_product.name as NameOfer', 'commercial_product.min_cost as min_cost','commercial_product.max_cost as max_cost')
            ->get();

        if ($type_services) {
            return response()->json([
                'message' => 'Datos de Servicio',
                'DataService' => $type_services
            ], Response::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'No hay Servicios',
            ], 401);
        }
    }
}
