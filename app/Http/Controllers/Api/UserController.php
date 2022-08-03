<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;
use App\Models\addres;
use App\Models\identification;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function getAllDataUser(Request $request)
    {   
        $id_user = $request->only('id_user');

        $dataUser = DB::table('users')
            ->join('persons', 'persons.id', '=', 'users.id_person')
            ->Leftjoin('address', 'address.id_person','=','users.id_person')
            ->Leftjoin('identifications', 'identifications.id_person','=','users.id_person')
            ->Leftjoin('students', 'students.id_person','=','users.id_person')
            ->where('users.id', '=', $id_user)
            ->where('users.is_active', '=', 1)
            ->select('users.*', 'persons.id as idPerson','persons.name as namePerson', 'persons.last_father_name as last_father_namePerson','persons.last_mother_name as last_mother_namePerson','persons.gender as genderPerson','persons.birth_date as birth_datePerson'
            ,'persons.phone as phonePerson','persons.facebook as facebookPerson', 'persons.interest_list as interest_listPerson','persons.profession as professionPerson','students.enrollment as enrollmentStudent', 'address.id as idAddress', 'address.full_address as full_addressAddress', 'address.location as locationAddress', 'address.city as cityAddress'
            , 'address.state as stateAddress', 'address.country as countryAddress', 'address.postal_code as postalCode', 'identifications.id as idIdenti','identifications.code as codeIdenti','identifications.code2 as code2Identi','identifications.code3 as code3Identi','identifications.url_img as url_imgIdenti')
            ->get()
            ->first();

        $catalogGenero = DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types',)
            ->where('cat_types.code', '=', 'SYST_GENERO')
            ->select('cat_catalogs.*')
            ->get();


        $catalogPaises = DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types',)
            ->where('cat_types.code', '=', 'SYST_PAISES')
            ->select('cat_catalogs.*')
            ->get();

        $catalogProfesiones = DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types',)
            ->where('cat_types.code', '=', 'SYST_PROFESIONES')
            ->select('cat_catalogs.*')
            ->get();

            $currency_list = DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
            ->where('cat_types.code', '=', 'SYST_CURRENCY')
            ->select('cat_catalogs.*')
            ->get();
    
            $Use_of_cfdi = DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
            ->where('cat_types.code', '=', 'SYST_CFDI')
            ->select('cat_catalogs.*')
            ->get();
    
            // $Payment_method = DB::table('cat_catalogs')
            // ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
            // ->where('cat_types.code', '=', 'SYST_METODODEPAGO')
            // ->select('cat_catalogs.*')
            // ->get();
    
            $Way_to_pay = DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
            ->where('cat_types.code', '=', 'SYST_PAYMENT')
            ->select('cat_catalogs.*')
            ->get();
    
            $Physical_or_moral_person = DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
            ->where('cat_types.code', '=', 'SYST_PERSONA')
            ->select('cat_catalogs.*')
            ->get();
    
        
        if ($dataUser) {
            return response()->json([
                'message' => 'Datos de usuario',
                'DataUser' => $dataUser,
                'CatalogsGenero' => json_encode($catalogGenero),
                'CatalogsPaises' => json_encode($catalogPaises),
                'CatalofsProfesiones' => json_encode($catalogProfesiones),
                'Catalogscurrency_list' => json_encode($currency_list),
                'CatalogsUse_of_cfdi' => json_encode($Use_of_cfdi),
                'CatalogsWayToPay' => json_encode($Way_to_pay),
                'CatalogsPhysical_or_moral_person' => json_encode($Physical_or_moral_person)
                
            ], Response::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'No hay usuario',
            ], 401);
        }

    }
    

    // public function geTwoUser(Request $request)
    //     {
    //         $id_user = $request->only('id_user');

    //         $catalogGenero = DB::table('cat_catalogs')
    //         ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types',)
    //         ->where('cat_types.code', '=', 'SYST_GENERO')
    //         ->select('cat_catalogs.*')
    //         ->get();
            

    //     if ($catalogGenero) {
    //         return response()->json([
    //             'message' => 'Catalogo de Generos',
    //             'catalogsGenero' => $catalogGenero
    //         ], Response::HTTP_OK);
    //     }else{
    //         return response()->json([
    //             'mesage' => 'No hay ningun Catalogo de Genero'
    //         ], 401);
    //     }

    // }

    public function UpdateAllDataUser(Request $request)
    {
        try {

            $id_user = $request->only('id_user');
            $DataUser = User::where('id', '=', $id_user)
            ->where('is_active', '=', 1)
            ->get()
            ->first();
            
            $DataPerson = Person::where('id', '=', $DataUser->id_person)
            ->get()
            ->first();
            
            if ($request['code'] == 'SYST_PERSON') {
                $DataPerson->name = $request['namePerson'];
                $DataPerson->last_father_name = $request['last_father_namePerson'];
                $DataPerson->last_mother_name = $request['last_mother_namePerson'];
                $DataPerson->gender = $request['genderPerson'];
                $DataPerson->birth_date = $request['birth_datePerson'];
                $DataPerson->phone = $request['phonePerson'];
                $DataPerson->facebook = $request['facebookPerson'];
                $DataPerson->profession = $request['professionPerson'];
                $DataPerson->save();
            }

           if ($request['code'] == 'SYST_ADDRESS') {
                $DataAddress = addres::where('id_person', '=', $DataPerson->id)
                ->get()
                ->first();

                if ($DataAddress) {
                    $DataAddress->full_address = $request['full_addressAddress'];
                    $DataAddress->state = $request['stateAddress'];
                    $DataAddress->city = $request['cityAddress'];
                    $DataAddress->country = $request['countryAddress'];
                    $DataAddress->location = $request['locationAddress'];
                    $DataAddress->postal_code = $request['postalCode'];
                    $DataAddress->save();
                }else{
                    $DataAddressNew = new addres();
                    $DataAddressNew->full_address = $request['full_addressAddress'];
                    $DataAddressNew->state = $request['stateAddress'];
                    $DataAddressNew->country = $request['countryAddress'];
                    $DataAddressNew->city = $request['cityAddress'];
                    $DataAddressNew->location = $request['locationAddress'];
                    $DataAddressNew->postal_code = $request['postalCode'];
                    $DataAddressNew->is_active = true;
                    $DataAddressNew->id_person = $DataPerson->id;
                    $DataAddressNew->save();
                }
           }

            if ($request['code'] == 'SYST_IDENTI') {
                $DataIdenti = identification::where('id_person', '=', $DataPerson->id)
                ->get()
                ->first();
            }

            return response()->json([
                'message' => 'Datos Actualizados'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erorr al actualizar',
                
            ], 401);
        }


        
    }
}

// 1