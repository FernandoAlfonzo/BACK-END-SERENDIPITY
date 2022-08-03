<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collaborator;
use App\Models\Person;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Session;

class CollaboratorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   $searchUser = trim($request->get('search'));
        $collaborators = DB::table('collaborators')
            ->join('persons', 'persons.id', '=', 'collaborators.id_person')
            ->where('persons.name', 'LIKE', '%' . $searchUser . '%')
            ->where('collaborators.is_active', '=', 1)
            ->select('collaborators.*', 'persons.id as personId', 'persons.last_father_name as lastNameF', 'persons.last_mother_name as lastNameM', 'persons.name', 'collaborators.id as idCollab')
            ->orderBy('id', 'asc')
            ->paginate(5);
            //dd($collabs);
            
        
        return view('collaborators.index', ['collaborators' => $collaborators, 'searchUser' => $searchUser]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $gender_list = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CAT_GEN')
        ->select('cat_catalogs.*')
        ->get();

        /* $job_list = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CAT_GEN')
        ->select('cat_catalogs.*')
        ->get(); */

        $business_unit_list = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CAT_OFF')
        ->select('cat_catalogs.*')
        ->get();

        $area_list = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CAT_ARE')
        ->select('cat_catalogs.*')
        ->get();

        $status_list = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CAT_STP')
        ->select('cat_catalogs.*')
        ->get();

        return view('collaborators.create', compact('gender_list', 'business_unit_list', 'area_list', 'status_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        /* $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_father_name' => ['required', 'string', 'max:255'],
            'last_mother_name' => ['required', 'string', 'max:255'],
            'gender' => ['nullable', 'string'],
            'birth_date' => ['required', 'date'],
            'id_person' => ['required', 'integer'],
            'code' => ['nullable', 'string', 'max:100'],
            'is_teacher' => ['nullable', 'integer'],
            'is_salesmen' => ['nullable', 'integer'],
            'is_organization' => ['nullable', 'integer'],
            'specialties' => ['nullable', 'string', 'max:255'],
            'characteristics' => ['nullable', 'string', 'max:255'],
            'start_at' => ['required', 'date'],
            // 'id_adm_organization' => ['required', 'integer'],
            'office_id' => ['required', 'integer'],
            'area' => ['required', 'integer'],
            'activities' => ['required', 'string', 'max:255'],
            'status' => ['required', 'integer'],
            'url_photo' => ['nullable', 'image', 'mimes:jpeg,png', 'max:5000'],
        ]); */
dd($request);
        $person = new Person();
        $person->name = $request->input('name');
        $person->last_father_name = $request->input('last_father_name');
        $person->last_mother_name = $request->input('last_mother_name');
        $person->gender = $request->input('gender');
        $person->birth_date = $request->input('birth_date');
        $person->is_active = true;
        $person->created_by = Auth::user()->id;
        $person->updated_by = null;
        $person->save(); //Guarda los datos en la BD

        $collaborator = new Collaborator();
        $collaborator->id_person = $person->id;
        $collaborator->is_coordinator = $request->input('is_coordinator');
        $collaborator->salary = $request->input('salary');
        $collaborator->is_teacher = $request->input('is_teacher');
        $collaborator->is_salesmen = $request->input('is_salesmen');
        $collaborator->is_organization = $request->input('is_organization');
        $collaborator->specialties = $request->input('specialties');
        $collaborator->characteristics = $request->input('characteristics');
        $collaborator->start_at = $request->input('start_at');
        // $collaborator->finished_at = $request->input('finished_at');

        $business_list = $request['business_unit'];
        foreach ($business_list as $key => $business) {
            $business_unit[$key] = array('id_business_unit: ' => intval($business));
        }
        $json_business_unit = '{"list_business_unit": ' . json_encode($business_unit) . '}';

        $collaborator->business_unit = $json_business_unit;
        $collaborator->area = $request->input('area');
        $collaborator->activities = $request->input('activities');
        $collaborator->status = $request->input('status');
        if ($request->hasFile('url_photo')) {
            $file = $request->file('url_photo');
            $destinyPath = 'collaborators/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('url_photo')->move($destinyPath, $fileName);
            $collaborator->url_photo = $uploadFile/* $destinyPath . $fileName */;
        }
        $collaborator->is_active = 1;
        $collaborator->id_adm_organization = Auth::user()->id;
        $collaborator->created_by = Auth::user()->id;
        $collaborator->created_at = Date(now());
        $collaborator->save(); //Guarda los datos en la BD

        $collaborator->collaborator_code = 'SER' . $collaborator->id . mt_rand(0, 999);
        $collaborator->save(); //Crear el código del colaborador dinamicamente

        Session::flash('message','Se guardó correctamente');
        return redirect()->route('collaborator.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $collaborator = DB::table('collaborators')
            ->join('persons', 'persons.id', '=', 'collaborators.id_person')
            ->where('collaborators.id', $id)
            ->select('collaborators.*', 'persons.id as personId', 'persons.last_father_name as lastNameF', 'persons.last_mother_name as lastNameM', 'persons.name', 'persons.birth_date', 'persons.gender')
            ->get()
            ->first();

        $gender_list = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CAT_GEN')
        ->select('cat_catalogs.*')
        ->get();

        /* $job_list = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CAT_GEN')
        ->select('cat_catalogs.*')
        ->get(); */

        $business_unit_list = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CAT_OFF')
        ->select('cat_catalogs.*')
        ->get();

        $area_list = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CAT_ARE')
        ->select('cat_catalogs.*')
        ->get();

        $status_list = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_types.code', '=', 'SYST_CAT_STP')
        ->select('cat_catalogs.*')
        ->get();
            
        return view('collaborators.edit', compact('collaborator', 'gender_list', 'business_unit_list', 'area_list', 'status_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $person = Person::find($request->personId);
        $person->name = $request->input('name');
        $person->last_father_name = $request->input('last_father_name');
        $person->last_mother_name = $request->input('last_mother_name');
        $person->gender = $request->input('gender');
        $person->birth_date = $request->input('birth_date');
        $person->is_active = true;
        $person->updated_by = Auth::user()->id;
        $person->save(); //Guarda los datos en la BD

        $collaborator = Collaborator::find($request->id);
        if ($request->hasFile('url_photo')) {
            File::delete($collaborator->url_photo);
        }
        $collaborator->is_coordinator = $request->input('is_coordinator');
        $collaborator->salary = $request->input('salary');
        $collaborator->is_teacher = $request->input('is_teacher');
        $collaborator->is_salesmen = $request->input('is_salesmen');
        $collaborator->is_organization = $request->input('is_organization');
        $collaborator->specialties = $request->input('specialties');
        $collaborator->characteristics = $request->input('characteristics');
        $collaborator->start_at = $request->input('start_at');
        $collaborator->id_adm_organization = Auth::user()->id;
        $collaborator->business_unit = $request->input('business_unit');
        $collaborator->area = $request->input('area');
        $collaborator->activities = $request->input('activities');
        $collaborator->status = $request->input('status');
        if ($request->hasFile('url_photo')) {
            $file = $request->file('url_photo');
            $destinyPath = 'collaborators/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('url_photo')->move($destinyPath, $fileName);
            $collaborator->url_photo = $uploadFile/* $destinyPath . $fileName */;
        }
        $collaborator->updated_by = Auth::user()->id;
        $collaborator->updated_at = Date(now());
        $collaborator->save(); //Guarda los datos en la BD

        Session::flash('message','Se editó correctamente');
        return redirect()->route('collaborator.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $collaborator = Collaborator::findOrFail($request['delete']);
        $collaborator->is_active = false;
        $collaborator->save();

        Session::flash('message','Se eliminó correctamente');
        return redirect()->route('collaborator.index');
        
    }

    public function stsCollab(Request $request)
    {
        $stsCollab = $request['stsCollab']; 

        if ($stsCollab == "on") {
            $idCollab = $request['idCollabActive'];
            $collaborator = Collaborator::findOrFail($idCollab);
            $collaborator->status = "on";
            $collaborator->save();
        } else {
            $idCollab = $request['idCollabDelete'];
            $collaborator = Collaborator::findOrFail($idCollab);
            $collaborator->status = null;
            $collaborator->save();

        }

        Session::flash('message','Estatus actualizado correctamente');
        return redirect()->route('collaborator.index');
    }
}