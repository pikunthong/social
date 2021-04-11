<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    //
    public  function store($id){
        $post = Post::find($id);
        $post->likes()->toggle(auth()->user());

        return back();
    }
}
