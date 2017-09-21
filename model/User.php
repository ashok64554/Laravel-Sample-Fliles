<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'usertype','name', 'email','password','gender', 'dob','mobile','address','city','state','country','avatar','info','start_date','ipaddress','api_token','pc_id','status','loginStatus',
    ];


    protected $casts = [
        'usertype'      => 'integer',
        'pc_id'         => 'integer',
        'loginStatus'   => 'integer',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function followedUsers()
    {
        return $this->belongsToMany('App\User', 'friendlists', 'sender_id', 'reciver_id')->select('users.id','users.usertype','users.name','users.avatar','users.api_token','users.dob','users.address','users.loginStatus');
    }

    public function followers()
    {
        return $this->belongsToMany('App\User', 'friendlists', 'reciver_id', 'sender_id')->select('users.id','users.usertype','users.name','users.avatar','users.api_token','users.dob','users.address','users.loginStatus');
    }

    public function isFollow()
    {
        return $this->belongsToMany('App\User', 'friendlists', 'reciver_id', 'sender_id')->where('sender_id', Auth::guard('api')->id())->select('users.id');
    }

    public function getFollowersCountAttribute()
    {
        return $this->followers()->count();
    }

}
