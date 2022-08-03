<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\identification;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class StudentsController extends Controller
{
    public function getAllResourceByPayment(Request $request)
    {
        $id_user = $request->only('id_user');

        $dataStudents = DB::table('persons')
        ->join('users', 'users.id_person', '=', 'persons.id') 
        ->join('students','students.id_person', '=', 'persons.id')
        ->select('persons.name', 'persons.last_father_name as pf', 'persons.last_mother_name as pm', 'students.enrollment', 'users.email', 'persons.phone')
        ->get();

        $methodPayments = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types',)
        ->where('cat_types.code', '=', 'SYST_PAYMENT')
        ->select('cat_catalogs.id','cat_catalogs.code')
        ->get();

        $dataSalesMen = DB::table('persons')
        ->join('users', 'users.id_person', '=', 'persons.id')
        ->join('collaborators', 'collaborators.id_person', '=', 'persons.id')
        ->select('collaborators.collaborator_code', 'persons.name as collaName', 'persons.last_father_name as collaPf', 'persons.last_mother_name as collaPm', 'persons.phone as collaPhone')
        ->get();
        
        $dataRulePayment = DB::table('rule_payments')
        ->select('code','name')
        ->get();

        if ($dataStudents) {
            return response()->json([
                'message' => 'Datos de usuario',
                'DataStudents' => $dataStudents,
                'methodPayments' => $methodPayments,
                'DataSalesMen' => $dataSalesMen,
                'DataRulePayment' => $dataRulePayment
            ], Response::HTTP_OK);
        
    }else{
        return response()->json([
            'message' => 'No hay usuario',
        ], 401);
    }
}



public function document(Request $request)
{
    $identification_person = DB::table('identifications')
    ->where('identifications.id_person', $request->id)
    ->where('identifications.code', $request->name)
    ->get();
    if ($identification_person) {
        return response()->json([
        
            'message' => "test correcto",
            'data' => $identification_person,
         ], Response::HTTP_OK);

    
    }else {
        return response()->json([

            'message' => "test erroneo",
        ], 404);
    
    }
    
}


public function validate_doc(Request $request)
{
    $identification_person = DB::table('identifications')
    ->where('identifications.id_person', $request->id_person)
    ->where('identifications.code', $request->code)
    ->select('id')
    ->get();
        $document=identification::findOrFail($request->id_D);
        $document->is_validate = 1;
        $document->save();

        if ($identification_person) {
            return response()->json([
            
                'message' => "test correcto",
                'data' => $document,
             ], Response::HTTP_OK);
    
        
        }else {
            return response()->json([
    
                'message' => "test erroneo",
            ], 404);
        
        }
     
     

     
}

public function alumnBymost()
{ //SELECT * FROM `students` WHERE created_at BETWEEN "2022-03-15" and "2022-03-24" and is_active = 1;
    $f1='2022-01-15';
    $f2='2022-02-15';
    $f3='2022-03-15';
    $f4='2022-04-15';
    $f5='2022-05-15';
    $f6='2022-06-15';
/**
    **$f7='2022-07-15';
    **$f8='2022-08-15';
    **$f9='2022-09-15';
    **$f10='2022-10-15';
    **$f11='2022-11-15';
    **$f12='2022-15-15';*/

    $identification_person = DB::table('students')
    ->where('students.is_active', 1)
    ->where('students.status', 'ALUMNO')
    ->where('students.created_at','>=', $f1)
    ->where('students.created_at','<=',$f2)
    ->count();


    $identification_perso = DB::table('students')
    ->where('students.is_active', 1)
    ->where('students.status', 'ALUMNO')
    ->where('students.created_at','>=', $f2)
    ->where('students.created_at','<=',$f3)
    ->count();
    
    $identification_pers = DB::table('students')
    ->where('students.is_active', 1)
    ->where('students.status', 'ALUMNO')
    ->where('students.created_at','>=', $f3)
    ->where('students.created_at','<=',$f4)
    ->count();

    $array = [ $identification_person, $identification_perso, $identification_pers];

    
    if ($array) {
        return response()->json([
        
            'message' => "test correcto",
            'data' => $array,
         ], Response::HTTP_OK);

    
    }else {
        return response()->json([

            'message' => "test erroneo",
        ], 404);
    
    }


}

public function collaborator()
{
    return response()->json([
        
        'message' => "test correcto",
        'data' => "te quiero :C",
     ], Response::HTTP_OK);

}

public function alumnBymost_pros()
{ 
    $f1='2022-01-15';
    $f2='2022-02-15';
    $f3='2022-03-15';
    $f4='2022-04-15';
    $f5='2022-05-15';
    $f6='2022-06-15';
/**
    **$f7='2022-07-15';
    **$f8='2022-08-15';
    **$f9='2022-09-15';
    **$f10='2022-10-15';
    **$f11='2022-11-15';
    **$f12='2022-15-15';*/

    $identification_person = DB::table('students')
    ->where('students.is_active', 1)
    ->where('students.status', 'PROSPECTO')
    ->where('students.created_at','>=', $f1)
    ->where('students.created_at','<=',$f2)
    ->count();


    $identification_perso = DB::table('students')
    ->where('students.is_active', 1)
    ->where('students.status', 'PROSPECTO')
    ->where('students.created_at','>=', $f2)
    ->where('students.created_at','<=',$f3)
    ->count();
    
    $identification_pers = DB::table('students')
    ->where('students.is_active', 1)
    ->where('students.status', 'PROSPECTO')
    ->where('students.created_at','>=', $f3)
    ->where('students.created_at','<=',$f4)
    ->count();

    $array = [ $identification_person, $identification_perso, $identification_pers];

    
    if ($array) {
        return response()->json([
        
            'message' => "test correcto",
            'data' => $array,
         ], Response::HTTP_OK);

    
    }else {
        return response()->json([

            'message' => "test erroneo",
        ], 404);
    
    }
 

}


public function generations_grafic (){
    $f1='2022-03-01';
    $f2='2022-03-07';
    $f3='2022-03-14';
    $f4='2022-03-21';
    $f5='2022-03-27';
    $f6='2022-03-31';

    $generations = DB::table('generations')
        ->where('generations.is_active', 1)
        ->where('generations.created_at','>=', $f1)
        ->where('generations.created_at','<=', $f2)
        ->count();

    $generation = DB::table('generations')
        ->where('generations.is_active', 1)
        ->where('generations.created_at','>=', $f2)
        ->where('generations.created_at','<=',$f3)
        ->count();
    
    $generatio = DB::table('generations')
        ->where('generations.is_active', 1)
        ->where('generations.created_at','>=',$f3)
        ->where('generations.created_at','<=', $f4)
        ->count();

    $generati = DB::table('generations')
        ->where('generations.is_active', 1)
        ->where('generations.created_at','>=',$f4)
        ->where('generations.created_at','<=',$f5)
        ->count();

    $generat = DB::table('generations')
        ->where('generations.is_active', 1)
        ->where('generations.created_at','>=',$f5)
        ->where('generations.created_at','<=',$f6)
        ->count();

        $array = [ $generations, $generation, $generatio, $generati, $generat];

        if ($array) {
            return response()->json([
            
                'message' => "test correcto",
                'data' => $array,
             ], Response::HTTP_OK);
    
        
        }else {
            return response()->json([
    
                'message' => "test erroneo",
            ], 404);
        
        }

}



}
