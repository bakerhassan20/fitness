<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'device_token',
    ];


    protected $casts = [
        'email' => 'string',
        'device_token'=>'string',
        'first_name'=>'string',
        'last_name'=>'string',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static array $rules = [
        'email' => 'required|unique:users',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'device_token' => 'string',
        'password' => [
            'required',
            'string',
            'min:10',             // must be at least 10 characters in length
            'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
            'regex:/[@$!%*#?&]/', // must contain a special character
        ],
    ];


    public $hidden = [ 'password','remember_token','updated_at','created_at','deleted_at'];



    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'user_exercises');
    }



}
