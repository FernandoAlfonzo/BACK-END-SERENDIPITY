<?php

namespace App\Http\Controllers;

use App\Models\commercial_product;
use App\Models\type_service;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class eduOfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $type_services = type_service::where('is_active', 1)
            ->orderBy('id', 'asc')
            ->get();
        return view('eduoffer.index', compact('type_services'));
    }

    public function listOffer($id)
    {   
        $type_service = type_service::findOrFail($id);
        $services = commercial_product::where('id_type', $id)
            ->where('is_active', 1)
            ->orderBy('id', 'asc')
            ->get();
            
        return view('eduoffer.list_offer', compact('type_service', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        //Comsulta para traer las categorias del servicio por código del padre
        /* $categories=DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
            ->where('cat_types.code', '=', 'SYS_CAT_SRV')
            ->select('cat_catalogs.*')
            ->get();
             */

        /* $categories = cat_catalog::where('id_cat_types', 4)
            ->orderBy('id', 'asc')
            ->get(); */
        return view('eduoffer.create_type_service');
    }

    public function createOffer($id)
    {   
        $type_service = type_service::findOrFail($id);
        $categories=DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
            ->where('cat_types.code', '=', 'SYST_CAT_SRV')
            ->select('cat_catalogs.*')
            ->get();

        $list_status=DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
            ->where('cat_types.code', '=', 'SYST_CAT_STS')
            ->select('cat_catalogs.*')
            ->get();
        
        $duration_types=DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
            ->where('cat_types.code', '=', 'SYST_CAT_PDT')
            ->select('cat_catalogs.*')
            ->get();

        return view('eduoffer.create_offer', compact('type_service', 'categories', 'list_status', 'duration_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* $validateFields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string'],
            'id_type' => ['required', 'integer'],
            'url_image' => ['nullable', 'image', 'mimes:jpeg,png', 'max:5000'],
        ]); */
        

        $type_service = new type_service();
        $type_service->name = $request->input('name');
        $type_service->description = $request->input('description');
        $type_service->code = $request->input('code');
        $type_service->is_active = 1;
        $type_service->created_at = Date(now());
        $type_service->created_by = Auth::user()->id;
        if ($request->hasFile('url_image')) {
            $file = $request->file('url_image');
            $destinyPath = 'type_service/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('url_image')->move($destinyPath, $fileName);
            $type_service->url_image = $uploadFile/* $destinyPath . $fileName */;
        }
        $type_service->save(); //Guardar en la BD

        return redirect()->route('educativeoffer.index');
    }

    public function storeOffer(Request $request)
    {
        $validateFields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'category' => ['required', 'integer'],
            'modules' => ['nullable', 'string', 'max:255'],
            'duration_time' => ['nullable', 'integer'],
            'duration_type' => ['nullable', 'integer'],
            'min_cost' => ['required', 'numeric'],
            'max_cost' => ['required', 'numeric'],
            'long_code' => ['nullable', 'string', 'max:255'],
            'id_type' => ['required', 'integer'],
            'status' => ['required', 'string', 'max:255'],
            'url_image' => ['nullable', 'image', 'mimes:jpeg,png', 'max:5000'],
        ]);

        $service = new commercial_product();
        $service->name = $request->input('name');
        $service->description = $request->input('description');
        $service->category = $request->input('category');
        $service->duration_time = $request->input('duration_time');
        $service->duration_type = $request->input('duration_type');
        $service->min_cost = $request->input('min_cost');
        $service->max_cost = $request->input('max_cost');
        $service->id_type = $request->input('id_type');
        $service->long_code = $request->input('long_code');
        $service->status = $request->input('status');
        if ($request->hasFile('url_image')) {
            $file = $request->file('url_image');
            $destinyPath = 'eduOffer/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('url_image')->move($destinyPath, $fileName);
            $service->url_image = $uploadFile/* $destinyPath . $fileName */;
        }
        $service->is_active = 1;
        $service->created_at = Date(now());
        $service->created_by = Auth::user()->id;
        $service->save(); //Guardar en la BD

        Session::flash('message','Se guardó correctamente');
        return redirect()->action('App\Http\Controllers\eduOfferController@listOffer', $service->id_type);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = commercial_product::findOrFail($id);
        return view('eduoffer.details', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $type_service = type_service::findOrFail($id);
        return view('eduoffer.edit_type_service', compact('type_service'));
    }

    public function editOffer($id)
    {   
        $service = commercial_product::findOrFail($id);
        $categories=DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
            ->where('cat_types.code', '=', 'SYST_CAT_SRV')
            ->select('cat_catalogs.*')
            ->get();

        $list_status=DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
            ->where('cat_types.code', '=', 'SYST_CAT_STS')
            ->select('cat_catalogs.*')
            ->get();
        
        $duration_types=DB::table('cat_catalogs')
            ->join('cat_types', 'cat_types.id', '=', 'cat_catalogs.id_cat_types')
            ->where('cat_types.code', '=', 'SYST_CAT_PDT')
            ->select('cat_catalogs.*')
            ->get();

        return view('eduoffer.edit_offer', compact('service', 'categories', 'list_status', 'duration_types'));
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
        $type_service = type_service::findOrFail($id);

        if ($request->hasFile('url_image')) {
            File::delete($type_service->url_image);
        }

        $type_service->name = $request->input('name');
        $type_service->description = $request->input('description');
        $type_service->code = $request->input('code');
        $type_service->status = $request->input('status');
        $type_service->is_active = 1;
        $type_service->updated_at = Date(now());
        $type_service->updated_by = Auth::user()->id;
        if ($request->hasFile('url_image')) {
            $file = $request->file('url_image');
            $destinyPath = 'eduOffer/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('url_image')->move($destinyPath, $fileName);
            $type_service->url_image = $uploadFile/* $destinyPath . $fileName */;
        }
        $type_service->save(); //Guardar en la BD

        return redirect()->route('educativeoffer.index');
    }

    public function updateOffer(Request $request, $id)
    {
        $validateFields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'integer'],
            'modules' => ['nullable', 'string', 'max:255'],
            'duration_time' => ['nullable', 'integer'],
            'duration_type' => ['nullable', 'integer'],
            'min_cost' => ['required', 'numeric'],
            'max_cost' => ['required', 'numeric'],
            'long_code' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'url_image' => ['nullable', 'image', 'mimes:jpeg,png', 'max:5000'],
        ]);

        $service = commercial_product::findOrFail($id);
        if ($request->hasFile('url_image')) {
            File::delete($service->url_image);
        }
        $service->name = $request->input('name');
        $service->description = $request->input('description');
        $service->category = $request->input('category');
        $service->duration_time = $request->input('duration_time');
        $service->duration_type = $request->input('duration_type');
        $service->min_cost = $request->input('min_cost');
        $service->max_cost = $request->input('max_cost');
        $service->long_code = $request->input('long_code');
        $service->status = $request->input('status');
        if ($request->hasFile('url_image')) {
            $file = $request->file('url_image');
            $destinyPath = 'eduOffer/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('url_image')->move($destinyPath, $fileName);
            $service->url_image = $uploadFile/* $destinyPath . $fileName */;
        }
        $service->updated_at = Date(now());
        $service->updated_by = Auth::user()->id;
        $service->save(); //Guardar en la BD

        Session::flash('message','Se editó correctamente');
        return redirect()->action('App\Http\Controllers\eduOfferController@listOffer', $service->id_type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type_service = type_service::findOrFail($id);
        $type_service->is_active = 0;
        $type_service->save(); //Guarda los datos en la BD

        return redirect()->route('educativeoffer.index');
    }

    public function destroyOffer($id)
    {
        $service = commercial_product::findOrFail($id);
        $service->is_active = 0;
        $service->save(); //Guarda los datos en la BD

        Session::flash('message','Se eliminó correctamente');
        return redirect()->action('App\Http\Controllers\eduOfferController@listOffer', $service->id_type);
    }
}
