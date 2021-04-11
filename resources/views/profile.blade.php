@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{$user->image ? $user->image:'https://picsum.photos/50/50'}}" alt="" class="rounded-circle "width="85">
                            @if($user->id == \Auth::user()->id)
                                <form action="{{url('/profile')}}"method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="file"class="form-control-file" name="image">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">
                                            upload
                                        </button>
                                    </div>
                                </form>
                            @endif
                            <div class="h5">{{$user->name}}</div>
                            @if($user->id!=\Auth::user()->id)
                                <form action="{{url('/follow/'.$user->id)}}" class=""method="post">
                                    @csrf
                                    <div class="form-group">
                                        @if(!$friend)
                                            <button type="submit" class="btn btn-info">
                                                Follow
                                            </button>
                                            @else
                                            <button type="submit" class="btn btn-info">
                                                Unfollow
                                            </button>
                                        @endif
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                @if($user->id==\Auth::user()->id )
                    <div class="card">
                        <div class="card-body">
                            <form action="{{url('/post')}}"method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <textarea class="form-control" rows="3" name="body">

                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <input type="file" class="form-control-file" name="image">
                                </div>
                                <div class="btn-toolbar justify-content-end">
                                    <div class="btn-group">
                                        <button class="btn btn-primary" type="submit">
                                            Post
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                @if(!empty($posts))
                    @foreach($posts as $post)
                        {{--                    posts คือ ตัวที่มีค่ามากกว่า 1 ค่า หรือเก็บค่ามากกว่า 1 ค่า อาจจะเป็น array หรือตัวแปรอื่นๆที่มีการเก็บค่าหลายๆค่า --}}
                        {{--                    post ที่ไม่มี s คือตัวแปรที่วิ่งส่งวิ่งใช้ทีละ 1 ค่า จาก $posts วนไปเรื่อยๆตามจำนวนที่มีอยู่ ใน $posts ดังนั้นถ้าไม่มี s คือตัวแปรที่วิ่งงวน คล้ายกับตัวแปร i ใน for ภาษา c++ เช่น for(i = 0,i++,i<20){cout<<i}--}}
                        {{--                    dynamic programming คือตัวแปรมีการเคลื่อนไหว เปลี่ยนแปลงตามเงื่อนไขต่างๆ static คือตัวแปรที่แก้แล้วแก้เลย ไม่เปลี่ยนแปลง เช่น html css--}}
                        <div class="card mt-3">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mr-2">
                                            <a href="{{url('/profile/'.$post->user->id)}}">
                                                <img src="{{$post->user->image ? $post->user->image:'https://picsum.photos/50/50'}}" width="45" class="rounded-circle" alt="">
                                            </a>
                                        </div>
                                        <div class="ml-2">
                                            <div class="h5 m-0">
                                                {{$post->user->name}}
                                            </div>
                                            <div class="text-muted">
                                                <i class="fa fa-clock-o"></i> {{$post->created_at->diffForhumans()}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    {{$post->body}}
                                </p>
                                <p class="text-center">
                                    <img src="{{$post->image}}"class="img-fluid" alt="">
                                </p>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex justify-content-between">
                                        <form action="{{url('/post/like/'.$post->id)}}"method="post">
                                            @csrf
                                            @if(!$post->likes->contains('user_id',\Auth::user()->id))
                                                <button class="btn btn-outline-primary "type="submit"><i class="far fa-thumbs-up"></i>Like</button>
                                            @else
                                                <button class="btn btn-primary "type="submit"><i class="far fa-thumbs-up"></i>Like</button>
                                            @endif
                                        </form>
                                        <span class="text-muted">
                                            &nbsp;{{$post->likes->count()}}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-muted">{{$post->comments->count()}}</span>
                                    </div>

                                </div>
                                <div class="mt-2">
                                    <form action="{{url('/post/comment/'.$post->id)}}"method="post">
                                        @csrf
                                        <div class="form-group">
                                            <textarea name="body" id="" cols="" rows="3" class="form-control"></textarea>
                                        </div>
                                        <div class="btn-toolbar justify-content-end">
                                            <div class="btn-group">
                                                <button class="btn btn-primary" type="submit">
                                                    comment
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    @if(!$post->comments->isEmpty())
                                        <ul class="list-unstyled mt-3">
                                            @foreach($post->comments as $comment)
                                                <li class="media p-2 mt-2">
                                                    <a href="{{url('/profile/'.$comment->user->id)}}">
                                                        <img src="{{$comment->user->image ? $comment->user->image:'https://picsum.photos/50/50'}}" alt="" class="rounded-circle mr-3"width="30">
                                                    </a>
                                                    <div class="media-body">
                                                        <div class="h6 m-0">{{$comment->user->name}}</div>
                                                        {{$comment->body}}
                                                        <div class="text-muted">
                                                            <i class="fa fa-clock-o"></i>{{$comment->created_at->diffForHumans()}}
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
