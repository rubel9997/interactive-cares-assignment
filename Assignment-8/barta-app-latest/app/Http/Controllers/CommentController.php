<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    public function store(Request $request)
    {
       $uuid = str::uuid();

       $post = DB::table('posts')->where('id',$request->post_id)->select('id', 'uuid')->first();

       if($request->comment_id){
           $comment = DB::table('comments')->where('id',$request->comment_id)->update([
               'comment' => $request->comment,
               'updated_at' => now(),
           ]);
       }else{
           $comment = DB::table('comments')->insert([
               'uuid' => $uuid,
               'user_id' => Auth::id(),
               'post_id' => $post->id,
               'comment' => $request->comment,
               'created_at' => now(),
               'updated_at' => now(),
           ]);
       }

        if($comment){
            if($request->comment_id){
                Session::flash('success','Comment updated successfully!');
            } else{
                Session::flash('success','Comment published successfully!');
            }
            return redirect()->route('post.single',$post->uuid);
        }else{
            Session::flash('error','Something went wrong!');
            return redirect()->back();
        }
    }


    public function edit(Request $request)
    {
        $post_uuid = $request->post_uuid;
        $comment_uuid = $request->comment_uuid;

        $post = DB::table('posts')->select('users.*','posts.*','posts.created_at as post_created_at')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.uuid',$post_uuid)
            ->first();

        $comment = DB::table('comments')->where('post_id',$post->id)->where('uuid',$comment_uuid)->first();

        return view('posts.single-post',['data'=>$post,'user_comment'=>$comment]);

    }


    public function destroy($comment_id)
    {
        $comment = DB::table('comments')->where('id',$comment_id)->delete();

        Session::flash('success','Comment removed successfully!');
        return redirect()->back();
    }

}
