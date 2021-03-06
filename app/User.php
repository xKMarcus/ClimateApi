<?php
# @Date:   2019-11-17T18:57:08+00:00
# @Last modified time: 2019-12-02T14:12:31+00:00




namespace App;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;


     // The attributes that are mass assignable.
    protected $fillable = [
        'name', 'email', 'password',
    ];


     //The attributes that should be hidden for arrays.
    protected $hidden = [
        'password', 'remember_token',
    ];


    // The attributes that should be cast to native types.
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function roles(){
      return $this->belongsToMany('App\Role', 'user_role');
    }


    public function authorizeRoles($roles){
      if (is_array($roles)){
        return $this->hasAnyRole($roles) || abort(401, 'this action is unauthorised');
      }
      return $this->hasRole($roles) || abort(401, 'this action is unauthorised');
    }

    public function hasRole($role){
      return null !== $this->roles()->where('name', $role)->first();
    }

    public function hasAnyRole($roles){
      return null !== $this->roles()->whereIn('name', $roles)->first();
    }
}
