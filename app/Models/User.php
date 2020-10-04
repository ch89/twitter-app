<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, Followable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
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

    protected $appends = ["followed", "can"];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAvatarAttribute($value) {
        // return "https://i.pravatar.cc/150?u=" . $this->email;

        return "/storage/$value";
    }

    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->diffForHumans();
    }

    public function tweets() {
        return $this->hasMany(Tweet::class)->latest();
    }

    public function likes() {
        return $this->belongsToMany(Tweet::class, "likes");
    }

    public function getCanAttribute() {
        return ["update" => Gate::allows("update", $this)];
    }

    // public function setPasswordAttribute($password) {
    //     $this->attributes["password"] = bcrypt($password);
    // }
}
