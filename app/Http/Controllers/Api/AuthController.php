<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use App\Models\User;
use App\Models\Person;
use App\Models\user_role;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\Student;
use App\Models\sys_module;
use App\Models\user_module_rol;
use Illuminate\Support\Facades\DB;
use App\Mail\UserEmailResetpass;
use App\Mail\UserValidateEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Hash;
use Str;

class AuthController extends Controller
{
      //Función que utilizaremos para registrar al usuario
      public function register(Request $request)
      {
          //Indicamos que solo queremos recibir name, email y password de la request
          $data = $request->only('name','last_father_name','last_mother_name','email', 'password', 'login_for_google');
          //Realizamos las validaciones
         if (!$request->login_for_google) {
             $login_for_google = false;
            $validator = Validator::make($data, [
                'name' => 'required|string',
                'last_father_name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|max:50',
            ]);
            //Devolvemos un error si fallan las validaciones
            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 400);
            }
         } else {
            $login_for_google = true;
            $validator = Validator::make($data, [
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
            ]);
            //Devolvemos un error si fallan las validaciones
            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 400);
            }
         }
          //Guardamos datos a la tabla de personas
          $person = Person::Create([
              'id' => Str::uuid()->toString(),
              'name' => $request->name,
              'last_father_name' => $request->last_father_name,
              'last_mother_name' => $request->last_mother_name,
              'is_active' => 1
          ]);
          //Creamos el nuevo usuario
          $user = User::create([
              'id_person' => $person->id,
              'email' => $request->email,
              'password' =>  $login_for_google ? Hash::make($request->email) : bcrypt($request->password),
              'status' => 1, 
              'login_for_google' => $login_for_google,
              'is_active' => 1,
              'is_validate_email' => $request->email_verified_at != null ? 1 : false 
          ]);

          $studen = Student::create([
              'id_person' => $person->id,
              'enrollment' => 'ALU' . $person->id . mt_rand(0, 999), //ALU46123
              'is_active' => 1
          ]);

          $roles=DB::table('roles')
          ->where('roles.code', '=', 'SYST_ROLE_ALUMNO')
          ->get()
          ->first();

        $role_user = user_role::Create([
            'id_user' => $user->id,
            'id_role' => $roles->id,
        ]);

        if(!$user->is_validate_email){
            $token = Str::random(60);
            
            $user->remember_token = $token;
            $user->expired_token_at = Carbon::now()->addDays(7)->toDateTimeString();
            $user->save();

            $objDemo = new \stdClass();
            $objDemo->user_email = $user->email;
            $objDemo->urlvalidate = $token;
            //dd($objDemo);
            Mail::to($user->email)->send(new UserValidateEmail($objDemo));
        }

          return response()->json([
              'message' => 'Usuario Creado',
              'user' => $user
          ], Response::HTTP_OK);
      }
      //Funcion que utilizaremos para hacer login
      public function authenticate(Request $request)
      {
          //Indicamos que solo queremos recibir email y password de la request
          $credentials = $request->only('email', 'password');
          //Validaciones
          $validator = Validator::make($credentials, [
              'email' => 'required|email',
              'password' => 'required|string|min:6|max:50'
          ]);
          //Devolvemos un error de validación en caso de fallo en las verificaciones
          if ($validator->fails()) {
              return response()->json(['error' => $validator->messages()], 400);
          }
          //Intentamos hacer login
          try {
            //if($request->remember_me){
                $token = JWTAuth::attempt($credentials, ['exp' => Carbon::now()->addDays(7)->timestamp]);
           /* }else{ 
                $tokenexpired = JWTAuth::attempt($credentials, ['exp' => Carbon::now()->addHours(7)->timestamp]);
                //$tokenexpired = Carbon::now();
                $token = JWTAuth::attempt($credentials, ['exp' => $tokenexpired]);            
            }*/
            if (!$token) {
                //Credenciales incorrectas.
                return response()->json([
                    'message' => 'Login failed',
                ], 401);
            }

            $user = $request->user();/// datos de usuario

            $DataPerson=DB::table('persons')
            ->join('users', 'users.id_person', '=', 'persons.id')
            ->where('users.id', '=', $user->id)
            ->select('users.id','persons.id as id_person', 'persons.name','persons.last_father_name', 'persons.last_mother_name', 'persons.phone','users.email')
            ->get()
            ->first();

            $roles_user=DB::table('user_roles')
            ->where('user_roles.id_user', '=', $user->id)
            ->get()
            ->first();

            $roles=DB::table('roles')
            ->where('roles.id', '=', $roles_user->id_role)
            ->get()
            ->first();

            $user_module_rol=DB::table('user_module_rols')
            ->join('sys_modules', 'sys_modules.id', '=', 'user_module_rols.id_sysmodules')
            ->where('user_module_rols.id_role', '=', $roles_user->id_role)
            ->get(); 

            $salesman=DB::table('collaborators')
            ->join('persons', 'persons.id', '=', 'collaborators.id_person')
            ->where('collaborators.id_person', '=', $DataPerson->id_person)
            ->where('collaborators.is_salesmen', '=', 1)
            ->select('collaborators.collaborator_code')
            ->get()
            ->first(); 

          } catch (JWTException $e) {
              //Error chungo
              return response()->json([
                  'message' => 'Error',
              ], 500);
          }
          //Devolvemos el token
          return response()->json([
            'accessToken' => $token,
            'token_type'   => 'Bearer',
            'DataPerson' => $DataPerson,
            'Datasalesman' => $salesman != null ? $salesman : [] ,
            'permissions' =>  $user_module_rol,
            'Rol' => $roles
            //'expires_at'   => Carbon::parse($token)->toDateTimeString()
          ]);
      }
      //login con cuenta de google
      public function googleAuthenticate(Request $request)
      {
          //Indicamos que solo queremos recibir email y password de la request
          $credentials = $request->only('email');
          //Devolvemos un error de validación en caso de fallo en las verificaciones
          if (!$request['email']) {
            return response()->json([
                'message' => 'Login failed',
            ], 401);
          }
          //Intentamos hacer login
          try {
            //if($request->remember_me){

            $user = User::where('email', '=', $credentials['email'])
            ->where('is_active', '=', 1)
            ->get()
            ->first();

            $credentials = ['email' => $request->input('email'), 'password' => $request->input('email')];
            
            $token = JWTAuth::attempt($credentials);

           /* }else{ 
                $tokenexpired = JWTAuth::attempt($credentials, ['exp' => Carbon::now()->addHours(7)->timestamp]);
                //$tokenexpired = Carbon::now();
                $token = JWTAuth::attempt($credentials, ['exp' => $tokenexpired]);            
            }*/
            if (!$token) {
                //Credenciales incorrectas.
                return response()->json([
                    'message' => 'Login failed',
                ], 401);
            }

            /*$user = User::where('email', '=', $request->email)
            ->where('is_active', '=', 1)
            ->get()
            ->first();*/

            $DataPerson=DB::table('persons')
            ->join('users', 'users.id_person', '=', 'persons.id')
            ->where('users.id', '=', $user->id)
            ->select('users.id','persons.id as id_person', 'persons.name','persons.last_father_name', 'persons.last_mother_name', 'persons.phone','users.email')
            ->get()
            ->first();

            $roles_user=DB::table('user_roles')
            ->where('user_roles.id_user', '=', $user->id)
            ->get()
            ->first();

            $roles=DB::table('roles')
            ->where('roles.id', '=', $roles_user->id_role)
            ->get()
            ->first();

            $user_module_rol=DB::table('user_module_rols')
            ->join('sys_modules', 'sys_modules.id', '=', 'user_module_rols.id_sysmodules')
            ->where('user_module_rols.id_role', '=', $roles_user->id_role)
            ->get(); 

            $salesman=DB::table('collaborators')
            ->join('persons', 'persons.id', '=', 'collaborators.id_person')
            ->where('collaborators.id_person', '=', $DataPerson->id_person)
            ->where('collaborators.is_salesmen', '=', 1)
            ->select('collaborators.collaborator_code')
            ->get()
            ->first();

          } catch (JWTException $e) {
              //Error chungo
              return response()->json([
                  'message' => 'Error',
              ], 500);
          }
          //Devolvemos el token
          return response()->json([
            'accessToken' => $token,
            'token_type'   => 'Bearer',
            'DataPerson' => $DataPerson,
            'Datasalesman' => $salesman != null ? $salesman : [] ,
            'permissions' =>  $user_module_rol,
            'Rol' => $roles
            //'expires_at'   => Carbon::parse($token)->toDateTimeString()
          ]);
      }

      //Función que utilizaremos para eliminar el token y desconectar al usuario
      public function logout(Request $request)
      {
          //Validamos que se nos envie el token
          $validator = Validator::make($request->only('token'), [
              'token' => 'required'
          ]);
          //Si falla la validación
          if ($validator->fails()) {
              return response()->json(['error' => $validator->messages()], 400);
          }
          try {
              //Si el token es valido eliminamos el token desconectando al usuario.
              JWTAuth::invalidate($request->token);
              return response()->json([
                  'success' => true,
                  'message' => 'User disconnected'
              ]);
          } catch (JWTException $exception) {
              //Error chungo
              return response()->json([
                  'success' => false,
                  'message' => 'Error'
              ], Response::HTTP_INTERNAL_SERVER_ERROR);
          }
      }
      //Función que utilizaremos para obtener los datos del usuario y validar si el token a expirado.
      public function getUser(Request $request)
      {
       
          //Realizamos la autentificación
          $user = JWTAuth::authenticate($request->token);
          //Si no hay usuario es que el token no es valido o que ha expirado
          if(!$user)
              return response()->json([
                  'message' => 'Invalid token / token expired',
              ], 401);
          //Devolvemos los datos del usuario si todo va bien. 
          return response()->json(['user' => $user]);
      }

      public function resetPassword(Request $request)
      { 

        $user_email = $request['email'];

        /*$result=DB::table('users')
        ->where('users.email', '=', $user_email)
        ->get()
        ->first();*/

        $result = User::where('email', '=', $user_email)
        ->where('is_active', '=', 1)
        ->get()
        ->first();

        if($result!=null){

            $token = Str::random(60);
            $fecha_expired = Carbon::now()->addDays(7)->timestamp;
            $result->remember_token = $token;
            $result->expired_token_at = Carbon::now()->addDays(7)->toDateTimeString();
            $result->save();

            $urlrecuperate = $token;
            $objDemo = new \stdClass();
            $objDemo->user_email = $user_email;
            $objDemo->urlrecuperate = $urlrecuperate;
            //dd($objDemo);
            Mail::to($user_email)->send(new UserEmailResetpass($objDemo));
            return new JsonResponse(
                [
                    'success' => true, 
                    'message' => "Correo enviado"
                ], 
                200
            );
        }else{
            return new JsonResponse(
                [
                    'success' => false, 
                    'message' => "No existe el correo"
                ], 
                401
            );
        }
      }

      public function resetPasswordValidate(Request $request)
      {
        $token = $request['token'];
        $result = User::where('remember_token', '=', $token)
        ->where('is_active', '=', 1)
        ->get()
        ->first();

       $dateNow = Carbon::now();

        // if($dateNow > $result->expired_token_at){
        //     dd("Si es mayor");
        // }else{
        //     dd("No es mayor");
        // }

        if ($result) {
           if ($dateNow < $result->expired_token_at) {
            return new JsonResponse(
                [
                    'success' => true, 
                    'message' => "Token valido"
                ], 
                200
            );
           } else {
            return new JsonResponse(
                [
                    'success' => false, 
                    'message' => "El token expiro"
                ], 
                401
            );
           }
           
        } else {
            return new JsonResponse(
                [
                    'success' => false, 
                    'message' => "El token no existe"
                ], 
                401
            );
        }
      }

      public function newpassword(Request $request)
      {
        $newPass = $request['newPass'];
        $newPassConfirm = $request['newPassConfirm'];
        $token = $request['token'];

        $result = User::where('remember_token', '=', $token)
        ->where('is_active', '=', 1)
        ->get()
        ->first();

        $result->password = Hash::make($newPass);
        $result->remember_token = Str::random(60);
        $result->expired_token_at = null;
        $result->save();

        /*Mail::to($email)->send(new UserEmailResetpass($email));
        return new JsonResponse(
            [
                'success' => true, 
                'message' => "Correo enviado",
                ''
            ], 
            200
        );*/
        return new JsonResponse(
            [
                'success' => true, 
                'message' => "Contraseña actualizada"
            ], 
            200
        );
      }

      public function validateExistEmail(Request $request)
      {
        $email = $request['email'];
        $result = User::where('email', '=', $email)
        ->where('is_active', '=', 1)
        ->get()
        ->first();

        if ($result) {
            return new JsonResponse(
                [
                    'success' => true, 
                    'message' => "Existe el usuario"
                ], 
                200
            );
        } else {
            return new JsonResponse(
                [
                    'success' => false, 
                    'message' => "No existe"
                ], 
                400
            );
        }
        

        
      }

      public function updateEmailValidate(Request $request)
      {
        $token = $request['token'];
        $result = User::where('remember_token', '=', $token)
        ->where('is_active', '=', 1)
        ->get()
        ->first();

        $result->remember_token = Str::random(60);
        $result->expired_token_at = "";
        $result->is_validate_email = true;
        $result->save();


        if ($result) {
            return new JsonResponse(
                [
                    'success' => true, 
                    'message' => "Existe el usuario"
                ], 
                200
            );
        } else {
            return new JsonResponse(
                [
                    'success' => false, 
                    'message' => "No existe"
                ], 
                400
            );
        }
      }

      public function test()
      {

        $result = User::all();


        return new JsonResponse(
            [
                'success' => true, 
                'message' => $result
            ], 
            200
        );
      }
      
}
