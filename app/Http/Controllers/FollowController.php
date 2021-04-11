<?php

namespace App\Http\Controllers;

use App\Friend;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    //
    public function store($id){
        $friend = Friend::friendship($id);
        if (!empty($friend)){
            Friend::where('user_id',$id)->orWhere('friend_id',$id)->delete();
        }else{
            Friend::create([
                'friend_id'=>$id,
                'user_id'=>auth()->user()->id
            ]);
        }
        return back();
    }
}
