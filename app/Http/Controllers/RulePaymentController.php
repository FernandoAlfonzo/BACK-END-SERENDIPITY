<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RulePayment;
use App\Models\cat_catalog;
use App\Models\cat_type;
use Illuminate\Support\Facades\DB;
use Session;

class RulePaymentController extends Controller
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

    public function index(Request $request )
    {
        
        $products = RulePayment::where('is_active', '=', 1)
        ->paginate(5);
        
        return view('product.index', ['products' => $products ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $frequencys = DB::table('cat_types')
            ->join('cat_catalogs', 'cat_catalogs.id_cat_types', '=', 'cat_types.id')
            ->where('cat_types.code', '=', "SYST_CAT_FREPAY")
            ->where('cat_types.is_active', '=', 1)
            ->where('cat_catalogs.is_active', '=', 1)
            ->select('cat_catalogs.*')
            ->get();

        $types = DB::table('cat_types')
            ->join('cat_catalogs', 'cat_catalogs.id_cat_types', '=', 'cat_types.id')
            ->where('cat_types.code', '=', "SYST_CAT_TYPAY")
            ->where('cat_types.is_active', '=', 1)
            ->where('cat_catalogs.is_active', '=', 1)
            ->select('cat_catalogs.*')
            ->get();

            
        $plazos = DB::table('cat_types')
            ->join('cat_catalogs', 'cat_catalogs.id_cat_types', '=', 'cat_types.id')
            ->where('cat_types.code', '=', "SYST_CAT_PLZ")
            ->where('cat_types.is_active', '=', 1)
            ->where('cat_catalogs.is_active', '=', 1)
            ->select('cat_catalogs.*')
            ->get();

        return view('product.NewProduct', compact('frequencys', 'types', 'plazos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new RulePayment();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->code = $request->input('code');
        $product->registration_amount = $request->input('registration_amount');
        $product->period = $request->input('period');
        $product->is_active = true;
        
        $cat_periodicity = cat_catalog::where('id', $request->input('periodicity'))
            ->where('is_active', 1)
            ->get()
            ->first();

        $cat_type = cat_catalog::where('id', $request->input('type'))
            ->where('is_active', 1)
            ->get()
            ->first();

        $cat_frequency = cat_catalog::where('id', $request->input('frequency'))
            ->where('is_active', 1)
            ->get()
            ->first();

        $product->id_cat_periodicity = $cat_periodicity->id;
        $product->label_cat_periodicity = $cat_periodicity->label;
        $product->code_cat_periodicity = $cat_periodicity->code;

        $product->id_cat_type = $cat_type->id;
        $product->label_cat_type = $cat_type->label;
        $product->code_cat_type = $cat_type->code;

        $product->id_cat_frequency = $cat_frequency->id;
        $product->label_cat_frequency = $cat_frequency->label;
        $product->code_cat_frequency = $cat_frequency->code;

        if ($request->input('check-require')) {
            $product->is_required = true;
        }else{
            $product->is_required = false;
        }

        if ($request->input('check-discount')) {
            $product->discount = true;
        }else{
            $product->discount = false;
        }
        
        if ($request->input('check-included')) {
            $product->included = true;
        }else{
            $product->included = false;
        }

        $product->save();
        Session::flash('message','Se guardo correctamente');
        return redirect()->route('products.index');
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
        $frequencys = DB::table('cat_types')
        ->join('cat_catalogs', 'cat_catalogs.id_cat_types', '=', 'cat_types.id')
        ->where('cat_types.code', '=', "SYST_CAT_FREPAY")
        ->where('cat_types.is_active', '=', 1)
        ->where('cat_catalogs.is_active', '=', 1)
        ->select('cat_catalogs.*')
        ->get();

        $types = DB::table('cat_types')
            ->join('cat_catalogs', 'cat_catalogs.id_cat_types', '=', 'cat_types.id')
            ->where('cat_types.code', '=', "SYST_CAT_TYPAY")
            ->where('cat_types.is_active', '=', 1)
            ->where('cat_catalogs.is_active', '=', 1)
            ->select('cat_catalogs.*')
            ->get();

            
        $plazos = DB::table('cat_types')
            ->join('cat_catalogs', 'cat_catalogs.id_cat_types', '=', 'cat_types.id')
            ->where('cat_types.code', '=', "SYST_CAT_PLZ")
            ->where('cat_types.is_active', '=', 1)
            ->where('cat_catalogs.is_active', '=', 1)
            ->select('cat_catalogs.*')
            ->get();

        $product = RulePayment::findOrFail($id);
        
        return view('product.EditProduct', compact('product', 'frequencys', 'types', 'plazos'));
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
        $product = RulePayment::findOrFail($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->code = $request->input('code');
        $product->registration_amount = $request->input('registration_amount');
        $product->period = $request->input('period');
        $product->is_active = true;

        $cat_periodicity = cat_catalog::where('id', $request->input('periodicity'))
        ->where('is_active', 1)
        ->get()
        ->first();

        $cat_type = cat_catalog::where('id', $request->input('type'))
            ->where('is_active', 1)
            ->get()
            ->first();

        $cat_frequency = cat_catalog::where('id', $request->input('frequency'))
            ->where('is_active', 1)
            ->get()
            ->first();

        $product->id_cat_periodicity = $cat_periodicity->id;
        $product->label_cat_periodicity = $cat_periodicity->label;
        $product->code_cat_periodicity = $cat_periodicity->code;

        $product->id_cat_type = $cat_type->id;
        $product->label_cat_type = $cat_type->label;
        $product->code_cat_type = $cat_type->code;

        $product->id_cat_frequency = $cat_frequency->id;
        $product->label_cat_frequency = $cat_frequency->label;
        $product->code_cat_frequency = $cat_frequency->code;

        if ($request->input('check-require')) {
            $product->is_required = true;
        }else{
            $product->is_required = false;
        }

        if ($request->input('check-discount')) {
            $product->discount = true;
        }else{
            $product->discount = false;
        }
        
        if ($request->input('check-included')) {
            $product->included = true;
        }else{
            $product->included = false;
        }

        $product->save();
        Session::flash('message','Se actualizo correctamente');
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = RulePayment::findOrFail($request['delete']);
        $product->is_active = 0;
        $product->save(); //Guarda los datos en la BD
        Session::flash('message','Se elimino correctamente');
        return redirect()->route('products.index');
    }
}
