<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use DB;
use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
         'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('menu.Configuración', function ($user) {   

            $user_role=DB::table('user_roles')
            ->select('user_roles.*')
            ->where('user_roles.id_user', '=', $user->id)
            ->get()
            ->first();

            $user_role_sys=DB::table('user_module_rols')
            ->select('user_module_rols.*')
            ->where('user_module_rols.id_role', '=', 1)
            ->where('user_module_rols.id_sysmodules', '=', 5)
            ->get()
            ->first();
            
            $permisoC=$user_role_sys->access_granted;
            $p=str_replace ('"', " ", $permisoC);
            $p=str_replace (' ', "", $p);

            $Config='Maestro.Configuración.ModulodeConfiguración:true';

            if ($user->email!="admin@admin") {
                if (strpos($p, $Config)==1) {
                    return true;
                } else {
                    return false;
                }
            }else{
                return true;
            }
           
            
            
        });
        //
        
        Gate::define('menu.sistema', function ($user) {

           

            $user_role=DB::table('user_roles')
            ->select('user_roles.*')
            ->where('user_roles.id_user', '=', $user->id)
            ->get()
            ->first();

            $user_role_sys=DB::table('user_module_rols')
            ->select('user_module_rols.*')
            ->where('user_module_rols.id_role', '=', 1)
            ->where('user_module_rols.id_sysmodules', '=', 1)
            ->get()
            ->first();
            
            $permisoC=$user_role_sys->access_granted;
            $p=str_replace ('"', " ", $permisoC);
            $p=str_replace (' ', "", $p);

            $Sistema='Maestro.Sistema.ModulodeSistema:true';

            if ($user->email!="admin@admin") {
                if (strpos($p, $Sistema)==1) {
                    return true;
                } else {
                    return false;
                }
            }else{
                return true;
            }
            
            
        });
    }
}
