<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function store(PostStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $uuid = Str::uuid()->toString();
            $post = DB::table('posts')->insert([
                'user_id'=>Auth::id(),
                'uuid'=>$uuid,
                'description'=>$data['description'],
                'created_at'=>now(),
            ]);

            if($post){
                Session::flash('success','Post uploaded successfully!');
                return redirect()->back();
            }else{
                Session::flash('error','Something went wrong!');
                return redirect()->back();
            }

        }catch (\Exception $exception){
            return redirect()->back()->with('error',$exception->getMessage());
        }
    }

    public function singlePostView(Request $request)
    {

        $auth_user = Auth::user();
        $user = DB::table('view_counts')->where('user_id',Auth::id())->where('post_id',$request->id)->first();

        if(!$user){
            DB::table('view_counts')->updateOrInsert([
                'user_id'=>Auth::id(),
                'post_id'=>$request->id,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }

        $posts = DB::table('posts')->join('users', 'posts.user_id', '=', 'users.id')->get();

        $view_count = DB::table('view_counts')->where('post_id',$request->id)->count();

//        return view('dashboard',['posts'=>$posts,'view_count'=>$view_count,'auth_user'=>$auth_user]);
        return back();

    }

    public function edit($id)
    {

    }

    public function destroy($id)
    {

    }
}
