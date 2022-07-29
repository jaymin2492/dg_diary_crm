<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\RoleUser;

class MasterUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check()){
            return redirect('/')->withErrors('You do not have access to this page.');
        }
        $currentUser = Auth::user();
        $checkCurrentrole = RoleUser::select('role_users.*', 'roles.title', 'roles.description')
                            ->join('roles', 'roles.id', '=', 'role_users.role_id')
                            ->where("role_users.user_id",$currentUser->id)
                            ->get()
                            ->toArray();
        if(empty($checkCurrentrole)){
            return redirect('/')->withErrors('You do not have access to this page.');
        }                    
        $checkCurrentrole = $checkCurrentrole[0];
        if($checkCurrentrole['title'] == "Director" || $checkCurrentrole['title'] == "Onboarding Manager"){
            return $next($request);
        }
        return redirect('/')->withErrors('You do not have access to this page.');
    }
}
