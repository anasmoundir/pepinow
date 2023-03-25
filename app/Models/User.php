<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;


class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles;

    public function hasRole($roles, $guard = null)
    {
        return $this->hasAnyRole($roles, $guard);
    }
    /**
     * The attributes that are mass assignable.use Tymon\JWTAuth\Contracts\JWTSubject;
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    // claim the jwt auth
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    // claim the jwt auth   
    public function getJWTCustomClaims()
    {
        return [];
    }
    //set the relationship between user and role 

}