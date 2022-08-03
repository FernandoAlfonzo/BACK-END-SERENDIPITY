<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use App\Models\Role;
use App\Models\user_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Session;
use Redirect;

class UserController extends Controller
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
         $users = DB::table('users')
            ->join('persons', 'persons.id', '=', 'users.id_person')
            ->Leftjoin('user_roles', 'user_roles.id_user','=','users.id')
            ->Leftjoin('roles', 'roles.id', '=', 'user_roles.id_role')
            ->where('users.is_active', '=', 1)
            ->where('persons.name', 'LIKE', '%' . $searchUser . '%')
            //->orWhere('users.email', 'LIKE', '%' . $searchUser . '%')
            ->select('users.*', 'persons.id as personId', 'persons.last_father_name as lastNameF', 'persons.last_mother_name as lastNameM', 'persons.name', 'roles.name as NameRol')
            ->orderBy('id', 'asc')
            ->paginate(5);

            //$role_user = user_role::where('id_user',  $users->id)->first();
            //dd($users);
            //$hostales::paginate(5);
            
            return view('user.index', ['users' => $users,'searchUser' => $searchUser]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Guardar nueva persona al registrar usuario
        $person = new Person();
        $person->name = $request->input('name');
        $person->last_father_name = $request->input('last_father_name');
        $person->last_mother_name = $request->input('last_mother_name');
        $person->gender = null;
        $person->birth_date = null;
        $person->is_active = true;
        $person->created_by = Auth::user()->id;
        $person->updated_by = null;
        $person->save(); //Guarda los datos en la BD

        // if ($person->save()) {
        //     $person->id; // Aca obtenés el identificador registrado en la tabla
        //     return Response::json(['success' => true], 200);
        // }

        //Guardar nuevo usuario usuario
        $user = new User();
        $user->id_person = $person->id;
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->email_verified_at = null;
        $user->status = 1;
        $user->is_active = true;
        $user->created_by = Auth::user()->id;
        $user->updated_by = null;
        $person->login_for_google = false;
        $user->save(); //Guarda los datos en la BD

         //Guarda los permisos de los usuarios
         if($request->IdRole != null && $request->IdRole != ''){
            $role_user = user_role::where('id_user',  $request->id)->first();
            if($role_user != null){
                $role_user->id_user = $user->id;
                $role_user->id_role = $request->IdRole;
                $role_user->save();
            }else{
                $user_role = new user_role();
                $user_role->id_user = $user->id;
                $user_role->id_role = $request->IdRole;
                $user_role->save();
            }
            
        }

        Session::flash('message','Se guardo correctamente');
        return redirect()->route('user.index');
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
        $user = DB::table('users')
            ->join('persons', 'persons.id', '=', 'users.id_person')
            ->where('users.is_active', '=', 1)
            ->where('users.id', '=', $id)
            ->select('users.*', 'persons.id as personId', 'persons.last_father_name', 'persons.last_mother_name', 'persons.name')
            ->get()
            ->first();

        $role_user = user_role::where('id_user',  $user->id)->first();

        $roles = Role::all();
             //dd($user);
        return view('user.edit', compact('user', 'roles', 'role_user'));
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
        //dd($request);
        //Guardar nueva persona al registrar usuario
        $person = Person::find($request->personId);
        $person->name = $request->name;
        $person->last_father_name = $request->last_father_name;
        $person->last_mother_name = $request->last_mother_name;
        $person->is_active = true;
        $person->created_by = Auth::user()->id;
        $person->updated_by = Auth::user()->id;
        $person->save(); //Guarda los datos en la BD

        // if ($person->save()) {
        //     $person->id; // Aca obtenés el identificador registrado en la tabla
        //     return Response::json(['success' => true], 200);
        // }

        //Guardar nuevo usuario usuario
        $user = User::find($request->id);
        $user->email = $request->email;
        $user->is_active = true;
        $user->created_by = Auth::user()->id;
        $user->updated_by = Auth::user()->id;
        $user->save(); //Guarda los datos en la BD

        //Guarda los permisos de los usuarios
        if($request->IdRole != null && $request->IdRole != ''){
            $role_user = user_role::where('id_user',  $request->id)->first();
            if($role_user != null){
                $role_user->id_role = $request->IdRole;
                $role_user->save();
            }else{
                $user_role = new user_role();
                $user_role->id_user = $request->id;
                $user_role->id_role = $request->IdRole;
                $user_role->save();
            }
            
        }

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $user = User::findOrFail($request['delete']);
        $user->is_active = 0;
        $user->save(); //Guarda los datos en la BD

        Session::flash('message','Se eliminó correctamente');
        return redirect()->route('user.index');
    }
}
