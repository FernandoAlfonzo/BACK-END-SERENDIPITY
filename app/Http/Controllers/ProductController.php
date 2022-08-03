<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\cat_catalog;
use App\Models\cat_type;
use Illuminate\Support\Facades\DB;
use Session;

class ProductController extends Controller
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
        $products = Product::where('is_active', '=', 1)
            ->get();
        return view('product.index')->with('products', $products);
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
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->code = $request->input('code');
        $product->registration_amount = $request->input('registration_amount');
        $product->period = $request->input('period');
        $product->is_active = true;
        
        $product->periodicity = $request->input('periodicity');
        $product->type = $request->input('type');
        $product->frequency = $request->input('frequency');

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

        $product = Product::findOrFail($id);
        
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
        $product = Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->code = $request->input('code');
        $product->registration_amount = $request->input('registration_amount');
        $product->period = $request->input('period');
        $product->is_active = true;
        
        $product->periodicity = $request->input('periodicity');
        $product->type = $request->input('type');
        $product->frequency = $request->input('frequency');

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
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = 0;
        $product->save(); //Guarda los datos en la BD
        Session::flash('message','Se elimino correctamente');
        return redirect()->route('products.index');
    }
}
