<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\AdminUser;
use App\Model\Role;
use App\Model\Permission;

class hasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        $route = \Route::current()->getActionName();
        $user = AdminUser::where('user_name',session()->get('username'))->first();
        // dump($route);
        $roles = $user->role;
        $arr = [];
        foreach ($roles as $v) {
            $perms = $v->permission;
            foreach ($perms as  $perm) {
                $arr[] = $perm->url;
            }
        }

        $arr = array_unique($arr);
        // dd($arr);
        if (in_array($route, $arr)) {
            return $next($request);
            
        }else{
            return redirect('noaccess');
        }
    }
}
