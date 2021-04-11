<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request){
        $data = $request->validate([
           'body'=>'',
            'image'=>''
        ]);

        if(isset($data['image'])){
            $file = $data['image'];
            $destinationPath = public_path('/uploads/');
            $image = date('YmdHis').".".$file->getClientOriginalExtension();
            $file->move($destinationPath,$image);
            $data['image']= url('/uploads/'.$image);
        }

        $data['user_id'] = auth()->user()->id;
        Post::create($data);
//        dd($data);
         return back();
    }
}
