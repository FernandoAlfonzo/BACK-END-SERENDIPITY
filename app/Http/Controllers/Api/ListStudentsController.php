<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ListStudentsController extends Controller
{
    public function ListStudents(Request $request)
    {
        $code_salesman = $request->only('code_salesman');

        $listStudents = DB::table('users')
        ->join('account', 'account.id_user', 'users.id')
        ->join('persons', 'persons.id', 'users.id_person')
        ->join('students', 'students.id_person', 'persons.id')
        ->where('account.collaborator_code', '=', $code_salesman)
        ->select('persons.*', 'students.enrollment')
        ->get();

        if ($listStudents) {
            return response()->json([
            'message' => 'Datos de usuario',
            'ListStudents' => $listStudents
            ], Response::HTTP_OK);

        }else{
            return response()->json([
                'message' => 'No hay usuario',
            ], 401);
        }
    }

}