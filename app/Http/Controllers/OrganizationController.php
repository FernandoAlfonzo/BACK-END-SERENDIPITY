<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\organization;
use Session;

class OrganizationController extends Controller
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
        $organizations = organization::where('is_active', '=', 1)
            ->get();
        return view('organization.listOrganization')->with('organizations', $organizations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('organization.newOrganization');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $organization = new organization();

        $organization->name_commercial = $request->input('name_commercial');
        $organization->name_business = $request->input('name_business');
        $organization->address = $request->input('address');
        $organization->RFC = $request->input('RFC');
        $organization->phone = $request->input('phone');
        $organization->email = $request->input('email');
        $organization->social_networks = $request->input('social_networks');
        $organization->is_active = 1;
        
        if ($request->hasFile('avatarInput')) {
            $file = $request->file('avatarInput');
            $destinyPath = 'organization/';
            //$fileName = time() . '-' . $file->getClientOriginalName();
            //$destinyPath = 'eduOffer/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('avatarInput')->move($destinyPath, $fileName);
            $organization->url_logo = $uploadFile/* $destinyPath . $fileName */;
        }

        $organization->save();

        return redirect()->route('organizations.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $organization = organization::findOrFail($id);
        return view('organization.editOrganization', compact('organization'));
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
        $organization = organization::findOrFail($id);
        
        if ($request->hasFile('avatarInput')) {
            File::delete($organization->url_logo);
            $file = $request->file('avatarInput');
            $destinyPath = 'Cat_catalog/';
            $fileName = time() . '-' . $file->getClientOriginalName();
            //$destinyPath = 'eduOffer/';
            $fileName = uniqid(). '.' . $file->getClientOriginalExtension();
            $uploadFile = $request->file('avatarInput')->move($destinyPath, $fileName);
            $organization->url_logo = $uploadFile/* $destinyPath . $fileName */;
        }
        $organization->fill($request->all());
        $organization->save();
        Session::flash('message','Se editó correctamente');
        return redirect()->route('organizations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
