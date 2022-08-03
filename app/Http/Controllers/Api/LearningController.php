<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class LearningController extends Controller
{

    public function Learning(Request $request)
    {
        $id_user = $request->only('id_user');

        $learning  = DB::table('sales_detail')
            ->join('users', 'users.id', 'sales_detail.id_user')
            ->where('users.id', '=', $id_user)
            ->select('sales_detail.id_commercial_product as idcp')
            ->get();

        $listCommercial = array();

        foreach ($learning as $learn){
            $commercialProduct = DB::table('commercial_product')
            ->join('generations', 'generations.id_service', 'commercial_Product.id')
            ->where('commercial_product.id', $learn->idcp)
            ->select('commercial_product.name', 'commercial_product.description', 'commercial_product.status', 'commercial_product.url_image')
            ->get()
            ->first();
            if ($commercialProduct) {
                array_push($listCommercial, $commercialProduct);
            }
        }
            
        
        
        if ($learning) {
            return response()->json([
                'message' => 'Si hay datos',
                'CommercialProduct' => $listCommercial
            ], Response::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'No hay datos',
            ], 401);
        }
    }

}
