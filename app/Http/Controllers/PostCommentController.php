<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    //
    public function store(Request $request,$id){
        $data = $request->validate([
            'body'=>''
        ]);
        $data['post_id'] = $id;
        $data['user_id'] = auth()->user()->id;
        Comment::create($data);

        return back();
    }
}
