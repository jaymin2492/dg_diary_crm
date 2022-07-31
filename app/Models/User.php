<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\RoleUser;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->hasOne('App\Models\RoleUser');
    }

    public function checkMasterRole() {
        $checkCurrentrole = RoleUser::select('role_users.*', 'roles.title', 'roles.description')
                            ->join('roles', 'roles.id', '=', 'role_users.role_id')
                            ->where("role_users.user_id",$this->id)
                            ->get()
                            ->toArray();                
        $checkCurrentrole = $checkCurrentrole[0];
        if($checkCurrentrole['title'] == "Director" || $checkCurrentrole['title'] == "Onboarding Manager"){
            return true;
        }
        return false;
    }

    public function currentRole() {
        $checkCurrentrole = RoleUser::select('role_users.*', 'roles.title', 'roles.description')
                            ->join('roles', 'roles.id', '=', 'role_users.role_id')
                            ->where("role_users.user_id",$this->id)
                            ->get()
                            ->toArray();                
        $checkCurrentrole = $checkCurrentrole[0];
        return $checkCurrentrole['title'];
    }

    public function currentUSerRoleId() {
        $checkCurrentrole = RoleUser::select('role_users.*', 'roles.title', 'roles.description')
                            ->join('roles', 'roles.id', '=', 'role_users.role_id')
                            ->where("role_users.user_id",$this->id)
                            ->get()
                            ->toArray();                
        $checkCurrentrole = $checkCurrentrole[0];
        return $checkCurrentrole['id'];
    }
}
