<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Helper
{
//    public static function postCreateTime($created_at)
//    {
//        $timestamp = strtotime($created_at);
//        $currentTimestamp = time();
//        $timeDifference = $currentTimestamp - $timestamp;
//        $minutesAgo = floor($timeDifference / 60);
//
//        if ($minutesAgo < 1) {
//            $result = 'Just now';
//        } elseif ($minutesAgo == 1) {
//            $result = '1 minute ago';
//        } elseif ($minutesAgo < 60) {
//            $result = $minutesAgo.' minutes ago';
//        } elseif ($minutesAgo >= 60 && $minutesAgo < 1440) {
//
//            $hoursAgo = floor($minutesAgo / 60);
//            $result = $hoursAgo.'h ago';
//        } else {
//            $formattedDate = date('g:i A · M j, Y', $timestamp);
//            $result = $formattedDate;
//        }
//
//        return $result;
//    }

//    public static function commentCreateTime($created_at)
//    {
//        $timestamp = strtotime($created_at);
//        $currentTimestamp = time();
//        $timeDifference = $currentTimestamp - $timestamp;
//        $minutesAgo = floor($timeDifference / 60);
//
//        if ($minutesAgo < 1) {
//            $result = 'Just now';
//        } elseif ($minutesAgo == 1) {
//            $result = '1 minute ago';
//        } elseif ($minutesAgo < 60) {
//            $result = $minutesAgo.' minutes ago';
//        } elseif ($minutesAgo >= 60 && $minutesAgo < 1440) {
//
//            $hoursAgo = floor($minutesAgo / 60);
//            $result = $hoursAgo.'h ago';
//        } else {
//            $formattedDate = date('g:i A · M j, Y', $timestamp);
//            $result = $formattedDate;
//        }
//
//        return $result;
//    }

//    public static function reactCheck($post_id)
//    {
//        return DB::table('reacts')->where('post_id', $post_id)->where('user_id', Auth::id())->first();
//    }
}
