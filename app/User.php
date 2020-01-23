<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','phone', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];




    public function likes()
    {
        return $this->hasMany(\App\Like::class);
    }
    public function dislikes()
    {
        return $this->hasMany(\App\Dislike::class);
    }
    public function downloads()
    {
        return $this->hasMany(\App\Download::class);
    }
    public function reports()
    {
        return $this->hasMany(\App\Report::class);
    }
    public function views()
    {
        return $this->hasMany(\App\View::class);
    }

    public function bookmarks(){
        return $this->hasMany(\App\Bookmark::class);
    }

    public function profile(){
        return $this->hasOne(\App\User::class);
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

}
