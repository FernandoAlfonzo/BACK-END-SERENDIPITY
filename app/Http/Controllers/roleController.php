<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\sys_module;
use App\Models\user_module_rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Redirect;
use Session;

class roleController extends Controller
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

    public function index(Request $request)
    {   
        $searchUser = trim($request->get('search'));
        $roles = Role::where('is_active', '=', 1)
            ->where('roles.name', 'LIKE', '%' . $searchUser . '%')       
            ->orderBy('id', 'asc')
            ->paginate(5);
            
            return view('role.index', ['roles' => $roles, 'searchUser' => $searchUser]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Guardar
        $role = new Role();
        $role->name = $request->input('name');
        $role->code = $request->input('code');
        $role->description = $request->input('description');
        $role->is_active = 1;
        $role->created_by = Auth::user()->id;
        $role->updated_by = null;
        $role->created_at = Date(now());
        $role->updated_at = null;
        $role->save(); //Guarda los datos en la BD

        return redirect()->route('role.index');
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
        $role = Role::findOrFail($id);
        return view('role.edit', compact('role'));
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
        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->code = $request->input('code');
        $role->description = $request->input('description');
        $role->is_active = 1;
        // $role->created_by = $request->input('direccion');
        $role->updated_by = Auth::user()->id;
        // $role->created_at = null;
        $role->updated_at = Date(now());
        $role->save(); //Guarda los datos en la BD

        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $role = Role::findOrFail($request['delete']);
        $role->is_active = 0;
        $role->save(); //Guarda los datos en la BD

        return redirect()->route('role.index');
    }

    public function Permission($id)
    {   
        $newFilterModules = array();
        $newFilterSubModules = array();

        $role = Role::where('is_active', '=', 1)
            ->where('id', '=', $id)
            ->orderBy('id', 'asc')
            ->get()
            ->first();

        $user_module_rol=DB::table('user_module_rols')
            ->join('sys_modules', 'sys_modules.id', '=', 'user_module_rols.id_sysmodules')
            ->where('user_module_rols.id_role', '=', $id)
            ->get(); 

        foreach ($user_module_rol as $key1 => $modu) {

        }

        $modulos=DB::table('sys_modules')->whereid_parent(0)->whereactive(1)->get();
        $submodulos=DB::table('sys_modules')->whereactive(1)->where('id_parent','>',0)->get();
        
        //dd($user_module_rol);
        //dd($this->ValidatePermiso('{"Maestro.Sistema.Modulo de Sistema":false}'));

        return view('role.permission',compact('role','modulos','submodulos'));
    }

    public function ModulePermission($id)
    {   
        $NewListModule = array();
        $permisoC="";

        $role = Role::where('is_active', '=', 1)
            ->where('id', '=', $id)
            ->orderBy('id', 'asc')
            ->get()
            ->first();

        $modulos=DB::table('sys_modules')->whereid_parent(0)->whereactive(1)->get();

        $user_module_rol=DB::table('user_module_rols')
            ->join('sys_modules', 'sys_modules.id', '=', 'user_module_rols.id_sysmodules')
            ->where('user_module_rols.id_role', '=', $role->id)
            ->get(); 

        //$submodulos=DB::table('sys_modules')->whereactive(1)->where('id_parent','>',0)->get();
        /*foreach ($user_module_rol as $j) {
            $permisoC .=$j->access_granted;
        } */

        //dd($modulos);

        foreach ($modulos as $key1 => $modu) {
            $p='';
            $permisoC='';
            foreach ($user_module_rol as $key2 => $rol_modu) {
                $permisoC=$rol_modu->access_granted;
                $p=str_replace ('"', " ", $permisoC);
                $p=str_replace (' ', "", $p);
                //dd($modu);
                if($modu->id == $rol_modu->id_sysmodules){
                    //dd($modu);
                    $Sistema='Maestro.Sistema.ModulodeSistema:true';
                    $Config='Maestro.Configuración.ModulodeConfiguración:true';
                    $Orga='Maestro.Organización.ModulodeOrganización:true';
                    
                    
                    //dd($p);
                    if(strpos($p, $Sistema)==1){
                        $modu->register_by = 1;
                        $NewListModule[$key1] = $modu;
                    }

                    if(strpos($p, $Config)==1){
                        $modu->register_by = 1;
                        $NewListModule[$key1] = $modu;
                    }

                    if(strpos($p, $Orga)==1){
                        $modu->register_by = 1;
                        $NewListModule[$key1] = $modu;
                    }
                }else{
                   // dd($modu);
                    $NewListModule[$key1] = $modu;
                }
            }
        }
        
        //dd($NewListModule);

        return view('role.modulePermission',compact('role','NewListModule'));
    }

    public function AsignatePermisoModule(Request $request,$id_role)
    {
        
        //dd($request);
       $role = Role::where('is_active', '=', 1)
       ->where('id', '=', $id_role)
       ->orderBy('id', 'asc')
       ->get()
       ->first();

       $user_module_rol=DB::table('user_module_rols')
       ->join('sys_modules', 'sys_modules.id', '=', 'user_module_rols.id_sysmodules')
       ->where('user_module_rols.id_role', '=', $id_role)
       ->get(); 

       $modulos=DB::table('sys_modules')->whereid_parent(0)->whereactive(1)->get();

       foreach ($modulos as $key1 => $modu) {
            $rolemodule = new user_module_rol();
            if ($request[$modu->title] != null) {

                $get_module_rols = user_module_rol::where('is_active', '=', 1)
                ->where('id_sysmodules', '=', $modu->id)
                ->get()
                ->first();

                if($get_module_rols!=null){
                    $newPermisionTrue = $this->EditPermisoTrueModulo($get_module_rols->access_granted);
                    $get_module_rols->access_granted = $newPermisionTrue;
                    $get_module_rols->save();
                }else{
                    $newAccese = $this->CreatePermisoModulo($role->name, $modu->title, 'true');
                    $rolemodule->id_role = $id_role;
                    $rolemodule->id_sysmodules = $modu->id;
                    $rolemodule->is_active = 1;
                    $rolemodule->access_granted = $newAccese;
                    $rolemodule->register_by = 1;
                    $rolemodule->modify_by = 1;
                    $rolemodule->save();
                }
            }else{
                $get_module_rols = user_module_rol::where('is_active', '=', 1)
                ->where('id_sysmodules', '=', $modu->id)
                ->get()
                ->first();
                if ($get_module_rols!=null) {
                    $newPermisionFalse = $this->EditPermisoFalseModulo($get_module_rols->access_granted);
                    $get_module_rols->access_granted = $newPermisionFalse;
                    $get_module_rols->save();
                } else {
                    $newAccese = $this->CreatePermisoModulo($role->name, $modu->title, 'false');
                    $rolemodule->id_role = $id_role;
                    $rolemodule->id_sysmodules = $modu->id;
                    $rolemodule->is_active = 1;
                    $rolemodule->access_granted = $newAccese;
                    $rolemodule->register_by = 1;
                    $rolemodule->modify_by = 1;
                    $rolemodule->save();
                }
                
            }

       }

       //return Redirect::to('configPermission/'.$id_role);
       return redirect()->route('role.index');

       //$Newpermiso = $this->CreatePermisoModulo($role->name, 'Inicio', 'false');
       //$FalsePermiso = $this->EditPermisoFalseModulo('{"admin.Sistema.Modulo de Sistema":false}');
       //$truePermiso = $this->EditPermisoTrueModulo('{"admin.Sistema.Modulo de Sistema":false}');
       //dd($Newpermiso);

    }

    public function CreatePermisoModulo($NameRol, $NameModulo, $status)
    {
        //{"admin.Sistema.Modulo de Sistema":false}
        $open = "{";
        $close = "}";
        
        return $NewPermiso = $open . '"' . $NameRol . '.' . $NameModulo . '.Modulo de ' . $NameModulo . '"' . ':' . $status . $close;
    }

    public function EditPermisoFalseModulo($permiso)
    {
        return str_replace ('true', 'false', $permiso);
    }

    public function EditPermisoTrueModulo($permiso)
    {
        return str_replace ('false', 'true', $permiso);
    }

    public function getUser_module_rolById($id)
    {
        $user_module_rol=DB::table('user_module_rols')
        ->where('user_module_rols.id_sysmodules', '=', $id)
        ->get()
        ->first();

        return $user_module_rol;
    }

    public function ValidatePermiso($j_son_permision)
    {
        if (strpos($j_son_permision, 'false') !== false) {
            return false;
        }else{
            return true;
        }
    }

}
