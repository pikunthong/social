<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    //
    protected $fillable = ['user_id','friend_id'];
    public static function friendship($userId){
        return(new static())
            ->where( function ($query)use($userId){
                return $query->where('user_id',$userId)
                    ->where('friend_id',auth()->user()->id);
            })
            ->orWhere(function ($query)use($userId){
                    return $query->where('user_id',auth()->user()->id)
                        ->where('friend_id',$userId);
            })
            ->first();
    }

    public static function  friendships(){
        return(new static())
            ->where(function ($query){
                return $query->where('user_id',auth()->user()->id)
                    ->orWhere('friend_id',auth()->user()->id);
            })
            ->get();
    }
}
