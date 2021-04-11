<?php

namespace App\Http\Controllers;

use App\Friend;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($id){
        $user = User::find($id);
        if(!$user){
            abort(404);
        }

        $friend  = Friend::friendship($id);
        $posts = [];
        if (!empty($friend)&& auth()->user()->id != $id){
            $posts = Post::with(['user','likes','comments.user'])->where('user_id',$user->id)->orderBy('created_at','desc')->get();
        }
        if (empty($friend) && auth()->user()->id == $id){
            $posts = Post::with(['user','likes','comments.user'])->where('user_id',auth()->user()->id)->orderBy('created_at','desc')->get();
        }
        return view('profile',compact('user','friend','posts'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'image'=>''
        ]);
        if (isset($data['image'])){
            $file = $data['image'];
            $destinationPath = public_path('/uploads/');
            $image = date('YmdHis').".".$file->getClientOriginalExtension();
            $file->move($destinationPath,$image);
            $user = User::find(auth()->user()->id);
            $user->image = url('/uploads/'.$image);
            $user->save();
        }
        return back();
    }
}
