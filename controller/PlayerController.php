<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Player;
use App\Postfeed;
use App\Friendlist;

class PlayerController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    
    public function getPlayerInfo($id)
    {
        $playerInfo = Player::where('userid', Auth::guard('api')->id())->first();
       

        $postings = Postfeed::select(
            'postfeeds.id','postfeeds.user_id','postfeeds.api_token','postfeeds.post_type','postfeeds.post_title','postfeeds.post_detail','postfeeds.likes','postfeeds.shares','postfeeds.token','postfeeds.created_at','users.loginStatus',

            'postattachments.id','postattachments.post_id','postattachments.file_name','postattachments.preview_div','postattachments.shares','postattachments.status')->where('user_id', $id)->orderBy('postfeeds.id', 'DESC')->with('comments', 'usercomment', 'liked')

            ->join('postattachments', function ($join) {
                $join->on('postattachments.post_id', '=', 'postfeeds.id');
            })

            ->join('users', function ($join) {
                $join->on('users.id', '=', 'postfeeds.user_id');
            })
        ->get();

        $gallery = Postfeed::select(
            'postfeeds.id','postfeeds.user_id','postfeeds.api_token','postfeeds.post_type','postfeeds.post_title','postfeeds.created_at',

            'postattachments.id','postattachments.post_id','postattachments.file_name')->where('user_id', Auth::guard('api')->id())->where('post_type', '2')->orderBy('postfeeds.id', 'DESC')

            ->join('postattachments', function ($join) {
                $join->on('postattachments.post_id', '=', 'postfeeds.id');
            })
        ->get();


            $returnData = array(
                'playerInfo'        => $playerInfo,
                'postings'          => $postings,
                'gallery'           => $gallery
                );
        return response($returnData, 201);
    }

    

    public function search(Request $request)
    {
        $serachList = User::select('id','usertype','name','address','avatar','city','gender','api_token')
                ->with('isFollow')
                ->where('name','like','%'.$request->input('s').'%')
                ->where('status','0')
                ->where('usertype','!=','5')
                ->where('usertype','!=','0')
                ->get();
        
        if(count($serachList)>0)
        {
            foreach ($serachList as $totalFollows) {
                $fanFollowingcount[] = Friendlist::select(DB::raw('count(*) as followers_count, reciver_id'))->where('reciver_id',$totalFollows->id)->where('relationType','1')->groupBy('reciver_id')->get();
            }
        }
        else
        {
            $fanFollowingcount = '';
        }
        

        $returnData = array(
            'serachList'        => $serachList,
            'fanFollowingcount' => $fanFollowingcount
            );

        return response($returnData, 201);
    }

    
}
