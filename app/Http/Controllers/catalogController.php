<?php

namespace App\Http\Controllers;

use App\Models\cat_catalog;
use App\Models\cat_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
use Session;
use File;

class catalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $types = cat_type::where('is_active', '=', 1)
            ->orderBy('id', 'asc')
            ->paginate(5);

        return view('catalog.index')->with('types', $types);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('catalog.create');
    }

    public function createSubcatalog($id)
    {   
        $id_type = cat_type::findOrFail($id);
        return view('catalog.subcatalog.create', compact('id_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSubcatalog(Request $request)
    {   
        $subcatalog = new cat_catalog();
        $data = $request->only('label','description','avatarInput');

        $validator = Validator::make($data, [
            'label' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'avatarInput' => ['mimes:jpeg,png', 'max:5000'],
        ]);

        //dd($request);
        if ($validator->fails()) {
            return redirect('catalog.index')
                        ->withErrors($validator)
                        ->withInput();
        }

        if ($request->hasFile('avatarInput')) {
            $file = $request->file('avatarInput');
            $destinyPath = 'Cat_catalog/';
            $fileName = time() . '-' . $file->getClientOriginalName();
            //$destinyPath = 'eduOffer/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('avatarInput')->move($destinyPath, $fileName);
            $subcatalog->url_imagen = $uploadFile/* $destinyPath . $fileName */;
        }

        //Guardar
        $subcatalog->label = $request->input('label');
        $subcatalog->description = $request->input('description');
        $subcatalog->short_code = $request->input('short_code');
        $subcatalog->code = $request->input('code');
        $subcatalog->code2 = $request->input('code2');
        $subcatalog->code3 = $request->input('code3');
        $subcatalog->long_code =  $request->input('long_code');
        $subcatalog->is_active = 1;
        $subcatalog->id_cat_types = $request->input('id_cat_types');
        $subcatalog->created_at = Date(now());
        $subcatalog->save(); //Guarda los datos en la BD
        
        Session::flash('message','Se guardo correctamente');

        return redirect()->action('App\Http\Controllers\catalogController@show', $subcatalog->id_cat_types);
    }

    public function store(Request $request)
    {
        //Guardar
        $type = new cat_type();
        $type->label = $request->input('label');
        $type->description = $request->input('description');
        $type->short_code = $request->input('short_code');
        $type->code = $request->input('code');
        $type->long_code =  $request->input('long_code');
        $type->is_active = 1;
        $type->created_at = Date(now());
        $type->save(); //Guarda los datos en la BD

        return redirect()->route('catalog.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id_type = cat_type::findOrFail($id);
        
        $subcatalogs = cat_catalog::where('id_cat_types', $id)
            ->where('is_active', 1)
            ->paginate(5);
        return view('catalog.subcatalog.list', compact('id_type', 'subcatalogs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = cat_type::findOrFail($id);
        return view('catalog.edit', compact('type'));
    }

    public function editSubcatalog($id)
    {
        $subcatalog = cat_catalog::findOrFail($id);
        //dd($subcatalog);
        return view('catalog.subcatalog.edit', compact('subcatalog'));
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
        $type = cat_type::findOrFail($id);
        $type->label = $request->input('label');
        $type->description = $request->input('description');
        $type->short_code = $request->input('short_code');
        $type->code = $request->input('code');
        $type->long_code = $request->input('long_code');
        $type->is_active = 1;
        $type->updated_at = Date(now());
        $type->save(); //Guarda los datos en la BD

        return redirect()->route('catalog.index');
    }

    public function updateSubcatalog(Request $request, $id)
    {
        //dd($request);
        $subcatalog = cat_catalog::findOrFail($id);
        if ($request->hasFile('avatarInput')) {
            File::delete($subcatalog->url_imagen);
        }

        if ($request->hasFile('avatarInput')) {
            $file = $request->file('avatarInput');
            $destinyPath = 'Cat_catalog/';
            $fileName = time() . '-' . $file->getClientOriginalName();
            //$destinyPath = 'eduOffer/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('avatarInput')->move($destinyPath, $fileName);
            $subcatalog->url_imagen = $uploadFile/* $destinyPath . $fileName */;
        }
        $subcatalog->label = $request->input('label');
        $subcatalog->long_code = $request->input('long_code');
        $subcatalog->description = $request->input('description');
        $subcatalog->code = $request->input('code');
        $subcatalog->code2 = $request->input('code2');
        $subcatalog->code3 = $request->input('code3');
        $subcatalog->is_active = 1;
        $subcatalog->updated_at = Date(now());
        $subcatalog->save(); //Guarda los datos en la BD

        return redirect()->action('App\Http\Controllers\catalogController@show', $subcatalog->id_cat_types);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $type = cat_type::findOrFail($request['delete']);
        $type->is_active = 0;
        $type->save(); //Guarda los datos en la BD

        return redirect()->route('catalog.index');
    }

    public function destroySubcatalog(Request $request)
    {
        $type = cat_catalog::findOrFail($request['delete']);
        $type->is_active = 0;
        $type->save(); //Guarda los datos en la BD
        
        return redirect()->action('App\Http\Controllers\catalogController@show', $type->id_cat_types);

    }
}
