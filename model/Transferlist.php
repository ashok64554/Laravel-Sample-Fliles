<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Transferlist extends Model
{
    protected $fillable = [
			'club_id', 'player_id', 'message', 'price', 'status', 'start_date', 'end_date'
    ];

    public function userBids()
    {
        return $this->belongsToMany('App\User', 'transferlistbids', 'transferId', 'userId')->select('users.id','users.name','users.avatar','users.api_token','transferlistbids.transferId','transferlistbids.amount','transferlistbids.player_id','transferlistbids.anyComment','transferlistbids.bidStatus');
    }

    public function userPlayerExchangeBids()
    {
        return $this->belongsToMany('App\User', 'transferlistbids', 'transferId', 'player_id')->select('users.name','users.avatar','users.api_token','transferlistbids.transferId','transferlistbids.userId')->where('bidStatus','!=','3');
    }

    public function perticularUserBids()
    {
        return $this->belongsToMany('App\User', 'transferlistbids', 'transferId', 'userId')->select('users.name','users.avatar','users.api_token','transferlistbids.transferId','transferlistbids.userId','transferlistbids.amount','transferlistbids.player_id','transferlistbids.anyComment','transferlistbids.bidStatus')->where('transferlistbids.userId',Auth::guard('api')->id());
    }

    public function bidAccecpt()
    {
        return $this->belongsToMany('App\User', 'transferlistbids', 'transferId', 'userId')->select('users.id','users.name','users.avatar','users.api_token','transferlistbids.transferId','transferlistbids.amount','transferlistbids.player_id','transferlistbids.anyComment','transferlistbids.bidStatus')
        ->where('transferlistbids.bidStatus','1');
    }

    public function playerExchange()
    {
        return $this->belongsToMany('App\User', 'transferlistbids', 'transferId', 'player_id')->select('users.name','users.avatar','users.api_token','transferlistbids.transferId','transferlistbids.userId')
        ->where('transferlistbids.bidStatus','1');
    }

    public function fromClub()
    {
        return $this->belongsToMany('App\User', 'transferlists', 'id', 'club_id')->select('users.name','users.avatar','users.api_token')
        ->where('transferlists.status','2');
    }
}
