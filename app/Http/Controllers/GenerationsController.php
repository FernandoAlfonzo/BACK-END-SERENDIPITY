<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\commercial_product;
use App\Models\Generations;
use App\Models\Collaborator;
use App\Models\RulePayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class GenerationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         $this->middleware('auth');
     }

    public function index(Request $request)
    {   
        $generations = Generations::where('is_active', 1)
            ->orderBy('id', 'asc')
            ->paginate(5);
        
        $type_services = DB::table('commercial_product')
            ->join('type_service', 'type_service.id', '=', 'commercial_product.id_type')
            ->where('commercial_product.is_active', 1)
            ->select('commercial_product.id as offerId', 'commercial_product.id_type as OfferIdtype', 'type_service.id as typeServiceId', 'type_service.name as typeServiceName')
            ->get();

        $services = commercial_product::where('is_active', 1)
            ->get();

        $teachers = DB::table('collaborators')
            ->join('persons', 'persons.id', '=', 'collaborators.id_person')
            ->where('collaborators.is_active', '=', 1)
            ->select('collaborators.*', 'persons.id as personId', 'persons.last_father_name as lastNameF', 'persons.last_mother_name as lastNameM', 'persons.name')
            ->get();

        
        return view('generations.index', ['generations' => $generations,'services' => $services,'teachers' => $teachers, 'type_services' => $type_services]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createGeneration($id)
    {   
        $service = commercial_product::findOrFail($id);

        $payment_rules = RulePayment::where('is_active', 1)
            ->orderBy('id', 'asc')
            ->get();

        $salesmen = DB::table('collaborators')
            ->join('persons', 'persons.id', '=', 'collaborators.id_person')
            ->where('collaborators.is_active', '=', 1)
            ->where('collaborators.is_salesmen', 1)
            ->select('collaborators.*', 'persons.id as personId', 'persons.last_father_name as lastNameF', 'persons.last_mother_name as lastNameM', 'persons.name', 'collaborators.id as idCollab')
            ->get();

        $teachers=DB::table('collaborators')
            ->join('persons', 'persons.id', '=', 'collaborators.id_person')
            ->where('collaborators.is_active', 1)
            ->where('collaborators.is_teacher', 1)
            ->select('collaborators.*', 'persons.name as namePerson', 'persons.last_father_name as personLastFName', 'persons.last_mother_name as personLastMName')
            ->get();

        $profile_profesion = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_catalogs.is_active', 1)
        ->where('cat_types.is_active', 1)
        ->where('cat_types.code', '=', 'SYST_PROFESIONES')
        ->select('cat_catalogs.id','cat_catalogs.code', 'cat_catalogs.label')
        ->get();

        $plataformas = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_catalogs.is_active', 1)
        ->where('cat_types.is_active', 1)
        ->where('cat_types.code', '=', 'SYST_PLATFORM_EDU')
        ->select('cat_catalogs.id','cat_catalogs.code', 'cat_catalogs.label')
        ->get();

        $new_platform = 0;

        

        return view('generations.create', compact('service', 'teachers', 'payment_rules', 'salesmen', 'profile_profesion', 'new_platform', 'plataformas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        dd($request);
        /* $idService = $request['idserviceGeneration'];
        $service = commercial_product::findOrFail($idService); */
        $generation = new Generations();
        $generation->id_service = $request->input('id_service');
        $generation->name = $request->input('name');
        $generation->description = $request->input('description');
        $list_modules = $request['modules'];
        $list_teachers = $request['id_teachers'];
        $list_duration = $request['duration'];
        // dd($list_modules);
        foreach($list_modules as $key=>$module) {
            $id_teacher = $list_teachers[$key];
            $item_dura = $list_duration[$key];
            $module_teacher[$key] = array('modulo'=> $module, 'id_teacher'=> intval($id_teacher), 'duration'=>$item_dura);
        }
        $generation->modules_teachers = json_encode($module_teacher);
        //dd($generation->modules_teachers);
        if ($request['discount']) {
            $generation->discount = $request->input('discount');
        }
        $generation->start_at = $request->input('start_at');
        $generation->finish_at = $request->input('finish_at');
        $generation->short_code = $request->input('short_code');
        $generation->code = $request->input('code');
        $generation->long_code = $request->input('long_code');
        $generation->generation = $request->input('generation');
        $generation->status = $request->input('status');
        $generation->min_price = $request->input('min_price');
        $generation->max_price = $request->input('max_price');
        $rules = $request['payment_rules'];
        foreach($rules as $key=>$rule) {
            $pay_rules[$key] = array('id_rule'=> intval($rule));
        }
        $json_rule = '{"list_rules":'.json_encode($pay_rules).'}';
        $generation->payment_rules = $json_rule;
        
        $sales = $request['salesmen'];
        foreach($sales as $key => $sale) {
            $salesmen[$key] = array('id_salesmen' => intval($sale));
        }
        $json_salesmen = '{"list_salesmen":'. json_encode($salesmen) . '}';
        
        $generation->salesmen = $json_salesmen;

        $id_coordinator = $request['id_coordinator'];
        $generation->id_coordinator = $id_coordinator;

        $teachers=DB::table('collaborators')
            ->join('persons', 'persons.id', '=', 'collaborators.id_person')
            ->where('collaborators.id', $id_coordinator)
            ->where('collaborators.is_active', 1)
            ->where('collaborators.is_teacher', 1)
            ->select('collaborators.*', 'persons.name as namePerson', 'persons.last_father_name as personLastFName', 'persons.last_mother_name as personLastMName')
            ->get()
            ->first();

        $nameTeacher = $teachers->namePerson.' '.$teachers->personLastFName.' '.$teachers->personLastMName;
        $generation->name_coordinator = $nameTeacher;
        
        $listProfesion = $request['profesion'];

        foreach ($listProfesion as $key => $item) {
            
            $profesionCatalog = DB::table('cat_catalogs')
            ->where('cat_catalogs.is_active', 1)
            ->where('cat_catalogs.id', $item)
            ->select('cat_catalogs.id','cat_catalogs.code', 'cat_catalogs.label')
            ->get()
            ->first();

            $list_profesions[$key] = array('label'=> $profesionCatalog->label, 'id'=> $profesionCatalog->id);
        }
        //dd($list_profesions);
        //se agrega las plataforma de educación
        if ($request['selectPlatform'] !=null && $request['selectPlatform']) {
            $generation->educative_platform = $request['selectPlatform'];
        }else{
            if ($request['add_platform'] != null && $request['add_platform']) {
                $generation->educative_platform = $request['add_platform'];
            }
        }

        $generation->profesions = json_encode($list_profesions);
        $generation->consider = $request->input('consider');
        $generation->is_active = 1;
        $generation->created_at = Date(now());
        $generation->created_by = Auth::user()->id;
        $generation->save();

        Session::flash('message','Se guardó correctamente');
        return redirect()->route('generations.index');
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
        //$service = commercial_product::findOrFail($id);

        $generation = Generations::findOrFail($id);

        /* $service = DB::table('commercial_product')
            ->where('id', $generation->id_service)
            ->select('commercial_product.name as ServiceName')
            ->get(); */

        $payment_rules = RulePayment::where('is_active', 1)
            ->orderBy('id', 'asc')
            ->get();

        $rules = json_decode($generation->payment_rules);
        $listprofesions = json_decode($generation->profesions);

        $profile_profesion = DB::table('cat_catalogs')
        ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
        ->where('cat_catalogs.is_active', 1)
        ->where('cat_types.is_active', 1)
        ->where('cat_types.code', '=', 'SYST_PROFESIONES')
        ->select('cat_catalogs.id','cat_catalogs.code', 'cat_catalogs.label', 'cat_catalogs.is_private')
        ->get();

     if ($listprofesions) {
        foreach ($profile_profesion as $key => $profesion) {
            foreach ($listprofesions as $key => $value) {
                if($profesion->id == $value->id) {
                    $profesion->is_private = 1;
                }
            }
        }
     }
            
        foreach ($payment_rules as $key => $rule) {
            foreach ($rules->list_rules as $key => $value) {
                if($rule->id == $value->id_rule) {
                    $rule->is_private = 1;
                }
            }
        }

        $collaborators = DB::table('collaborators')
            ->join('persons', 'persons.id', '=', 'collaborators.id_person')
            ->where('collaborators.is_active', '=', 1)
            ->where('collaborators.is_salesmen', 1)
            ->select('collaborators.*', 'persons.id as personId', 'persons.last_father_name as lastNameF', 'persons.last_mother_name as lastNameM', 'persons.name', 'collaborators.id as idCollab')
            ->get();
        
        $sales = json_decode($generation->salesmen);
        //dd($sales);
            
        foreach ($collaborators as $key => $sale) {
            foreach ($sales->list_salesmen as $key => $value) {
                if($sale->idCollab == $value->id_salesmen) {
                    $sale->is_private = 1;
                }else{
                    $sale->is_private = 0;
                }
            }
        }

   
        $teachers=DB::table('collaborators')
            ->join('persons', 'persons.id', '=', 'collaborators.id_person')
            ->where('collaborators.is_active', 1)
            ->where('collaborators.is_teacher', 1)
            ->select('collaborators.*', 'persons.name as namePerson', 'persons.last_father_name as personLastFName', 'persons.last_mother_name as personLastMName')
            ->get();

        return view('generations.edit', compact('generation', /* 'service', */ 'payment_rules', 'teachers', 'collaborators','profile_profesion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $generation = Generations::findOrFail($id);
        $generation->name = $request->input('name');
        $generation->description = $request->input('description');
        $list_modules = $request['modules'];
        $list_teachers = $request['id_teachers'];
        foreach($list_modules as $key=>$module) {
            $id_teacher = $list_teachers[$key];
            $module_teacher[$key] = array('modulo'=> $module, 'id_teacher'=> intval($id_teacher));
        }
        $generation->modules_teachers = json_encode($module_teacher);
        //dd($generation->modules_teachers);
        $generation->discount = $request->input('discount');
        $generation->start_at = $request->input('start_at');
        $generation->finish_at = $request->input('finish_at');
        $generation->short_code = $request->input('short_code');
        $generation->code = $request->input('code');
        $generation->long_code = $request->input('long_code');
        $generation->generation = $request->input('generation');
        $generation->status = $request->input('status');
        $generation->min_price = $request->input('min_price');
        $generation->max_price = $request->input('max_price');
        $rules = $request['payment_rules'];
        //dd($rules);
        foreach($rules as $key=>$rule) {
            $pay_rules[$key] = array('id_rule'=> intval($rule));
        }
        $json_rule = '{"list_rules":'.json_encode($pay_rules).'}';
        $generation->payment_rules = $json_rule;
        $sales = $request['salesmen'];
        foreach($sales as $key => $sale) {
            $salesmen[$key] = array('id_salesmen' => intval($sale));
        }
        $json_salesmen = '{"list_salesmen": '. json_encode($salesmen) . '}';
        $generation->salesmen = $json_salesmen;

        $id_coordinator = $request['id_coordinator'];
        $generation->id_coordinator = $id_coordinator;

        if ($id_coordinator) {
            $teachers=DB::table('collaborators')
            ->join('persons', 'persons.id', '=', 'collaborators.id_person')
            ->where('collaborators.id', $id_coordinator)
            ->where('collaborators.is_active', 1)
            ->where('collaborators.is_teacher', 1)
            ->select('collaborators.*', 'persons.name as namePerson', 'persons.last_father_name as personLastFName', 'persons.last_mother_name as personLastMName')
            ->get()
            ->first();

        $nameTeacher = $teachers->namePerson.' '.$teachers->personLastFName.' '.$teachers->personLastMName;
        $generation->name_coordinator = $nameTeacher;
        }
        
        $listProfesion = $request['profesion'];

        foreach ($listProfesion as $key => $item) {
            
            $profesionCatalog = DB::table('cat_catalogs')
            ->where('cat_catalogs.is_active', 1)
            ->where('cat_catalogs.id', $item)
            ->select('cat_catalogs.id','cat_catalogs.code', 'cat_catalogs.label')
            ->get()
            ->first();

            $list_profesions[$key] = array('label'=> $profesionCatalog->label, 'id'=> $profesionCatalog->id);
        }
        //dd($generation->payment_rules);
        $generation->consider = $request->input('consider');
        $generation->is_active = 1;
        $generation->updated_at = Date(now());
        $generation->updated_by = Auth::user()->id;
        $generation->save();

        Session::flash('message','Se editó correctamente');
        return redirect()->route('generations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $generation = Generations::findOrFail($request['delete']);
        $generation->is_active = 0;
        $generation->save();

        Session::flash('message','Se ha eliminado correctamente');
        return redirect()->route('generations.index');
    }
}
