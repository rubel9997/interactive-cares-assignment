<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use App\Models\ViewCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function store(PostStoreRequest $request)
    {
        try {
            $data = $request->validated();

            $data['uuid'] = Str::uuid();

            $data['user_id'] = Auth::id();

            $post = Post::create($data);

            if ($request->has('picture')) {
                $post->addMediaFromRequest('picture')->toMediaCollection();
            }

            if ($post) {
                Session::flash('success', 'Post uploaded successfully!');

                return redirect()->back();
            } else {
                Session::flash('error', 'Something went wrong!');

                return redirect()->back();
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function singlePostView(Request $request)
    {

        $post = Post::where('uuid', $request->uuid)->first();

        $user_view_check = ViewCount::where('user_id', Auth::id())->where('post_id', $post->id)->exists();

        if (! $user_view_check) {
            $view = ViewCount::create([
                'user_id' => Auth::id(),
                'post_id' => $post->id,
            ]);

            if ($view) {
                $view_count = ViewCount::where('post_id', $post->id)->count();
                Post::where('id', $post->id)->update(['view_count' => $view_count]);
            }
        }

        $post = Post::with(['user', 'comments', 'viewCounts'])->where('id', $post->id)->orderBy('created_at', 'desc')->first();

        return view('posts.single-post', ['post' => $post]);

    }

    public function edit($uuid)
    {
        $post = Post::with(['user', 'comments', 'viewCounts'])->where('uuid', $uuid)->first();

        return view('posts.edit', ['post' => $post]);
    }

    public function update(PostStoreRequest $request)
    {
        try {
            $data = $request->validated();

            $post = Post::find($request->id);

            $post->update([
                'description' => $data['description'],
            ]);

            if ($request->has('picture')) {
                $post->clearMediaCollection();
                $post->addMediaFromRequest('picture')->toMediaCollection();
            }

            if ($post) {
                Session::flash('success', 'Post updated successfully!');

                return redirect()->route('dashboard');
            } else {
                Session::flash('error', 'Something went wrong!');

                return redirect()->back();
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        $post = Post::with(['comments', 'viewCounts'])->find($id);

        if ($post->hasMedia()) {
            $post->clearMediaCollection();
        }

        $status = $post->delete();

        if ($status) {
            Session::flash('success', 'Post removed successfully!');

            return redirect()->route('dashboard');
        } else {
            Session::flash('error', 'Something  went wrong!');

            return back();
        }

    }
}
