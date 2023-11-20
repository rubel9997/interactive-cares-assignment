<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Helper{

    public static function postCreateTime($created_at)
    {
        $timestamp = strtotime($created_at);
        $currentTimestamp = time();
        $timeDifference = $currentTimestamp - $timestamp;
        $minutesAgo = floor($timeDifference / 60);

        if ($minutesAgo < 1) {
            $result = "Just now";
        } elseif ($minutesAgo == 1) {
            $result = "1 minute ago";
        } elseif ($minutesAgo < 60) {
            $result = $minutesAgo . " minutes ago";
        }
        elseif ($minutesAgo >= 60 && $minutesAgo < 1440) {

            $hoursAgo = floor($minutesAgo / 60);
            $result = $hoursAgo . "h ago";
        }
        else{
            $formattedDate = date("g:i A · M j, Y", $timestamp);
            $result = $formattedDate;
        }

        return $result;
    }

    public static function commentCreateTime($created_at)
    {
        $timestamp = strtotime($created_at);
        $currentTimestamp = time();
        $timeDifference = $currentTimestamp - $timestamp;
        $minutesAgo = floor($timeDifference / 60);

        if ($minutesAgo < 1) {
            $result = "Just now";
        } elseif ($minutesAgo == 1) {
            $result = "1 minute ago";
        } elseif ($minutesAgo < 60) {
            $result = $minutesAgo . " minutes ago";
        }
        elseif ($minutesAgo >= 60 && $minutesAgo < 1440) {

            $hoursAgo = floor($minutesAgo / 60);
            $result = $hoursAgo . "h ago";
        }
        else{
            $formattedDate = date("g:i A · M j, Y", $timestamp);
            $result = $formattedDate;
        }

        return $result;
    }

//    public static function viewCount($post_id)
//    {
//        return DB::table('view_counts')->where('post_id',$post_id)->count();
//    }

    public static function postCount()
    {
        return DB::table('posts')->where('user_id',Auth::id())->count();
    }


    public static function reactCheck($post_id)
    {
     return  DB::table('reacts')->where('post_id',$post_id)->where('user_id',Auth::id())->first();
    }


    public static function reactCount($post_id)
    {
     return  DB::table('reacts')->where('post_id',$post_id)->where('react_yn','Y')->count();
    }

    public static function postComment($post_id)
    {
        $comments = DB::table('comments')->select('users.*','posts.*','posts.uuid as post_uuid','comments.*','comments.uuid as comment_uuid','comments.created_at as comment_created_at')
            ->join('users','comments.user_id','=','users.id')
            ->join('posts','comments.post_id','=','posts.id')
            ->where('post_id',$post_id)
            ->orderBy('comments.created_at','desc')
            ->get();
        return $comments ?? 0;
    }



}
