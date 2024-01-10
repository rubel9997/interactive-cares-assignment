<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\CommentAdd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Events\Comment as CommentEvent;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $uuid = str::uuid();
        $user = auth()->user();
        $post = Post::where('id', $request->post_id)->first();

        if ($request->comment_id) {
            $comment = Comment::where('id', $request->comment_id)->update([
                'comment' => $request->comment,
            ]);
        } else {
            $comment = Comment::create([
                'uuid' => $uuid,
                'user_id' => $user->id,
                'post_id' => $post->id,
                'comment' => $request->comment,
            ]);

            if($comment){

                $fullName = $user->full_name;
                $imagePath = $user->getFirstMediaUrl();

                $author = User::where('id',$post->user_id)->first();

                event(new CommentEvent($post,$fullName,$imagePath));
                $author->notify(new CommentAdd($author,$comment,$post,$fullName,$imagePath));

            }
        }

        if ($comment) {

            if ($request->comment_id) {
                Session::flash('success', 'Comment updated successfully!');
            } else {
                Session::flash('success', 'Comment published successfully!');
            }

            return redirect()->back();
        } else {
            Session::flash('error', 'Something went wrong!');

            return redirect()->back();
        }
    }

    public function edit(Request $request)
    {
        $post_uuid = $request->post_uuid;
        $comment_uuid = $request->comment_uuid;

        $post = Post::with(['user', 'comments', 'viewCounts'])->where('uuid', $post_uuid)->first();

        $comment = Comment::where('post_id', $post->id)->where('uuid', $comment_uuid)->first();

        return view('posts.single-post', ['post' => $post, 'user_comment' => $comment]);

    }

    public function destroy($comment_id)
    {
        $status = Comment::find($comment_id)->delete();

        if ($status) {
            Session::flash('success', 'Comment removed successfully!');

            return redirect()->back();
        } else {
            Session::flash('error', 'Something went wrong!');

            return redirect()->back();
        }

    }
}
