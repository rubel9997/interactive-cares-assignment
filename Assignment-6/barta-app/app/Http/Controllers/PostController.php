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

        $user = DB::table('view_counts')->where('user_id',Auth::id())->where('post_id',$request->id)->exists();

        if(!$user){
           $view =  DB::table('view_counts')->insert([
                'user_id'=>Auth::id(),
                'post_id'=>$request->id,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);

           if($view){
               $view_count = DB::table('view_counts')->where('post_id',$request->id)->count();
               DB::table('posts')->where('id',$request->id)->update(['view_count'=>$view_count]);
           }
        }

        $post = DB::table('posts')->select('users.*','posts.*','posts.created_at as post_created_at')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.id',$request->id)
            ->first();

        return view('posts.single-post',['data'=>$post]);

    }

    public function edit($uuid)
    {
        $post = DB::table('posts')->where('uuid',$uuid)->first();
        return view('posts.edit',['data'=>$post]);
    }

    public function update(PostStoreRequest $request)
    {
        try {
            $data = $request->validated();

            $post = DB::table('posts')->where('id',$request->id)->update([
                'description'=>$data['description'],
                'updated_at'=>now(),
            ]);

            if($post){
                Session::flash('success','Post updated successfully!');
                return redirect()->route('dashboard');
            }else{
                Session::flash('error','Something went wrong!');
                return redirect()->back();
            }

        }catch (\Exception $exception){
            return redirect()->back()->with('error',$exception->getMessage());
        }
    }

    public function destroy($id)
    {
        $post = DB::table('posts')->where('id',$id)->delete();

        if($post){
          $view_count = DB::table('view_counts')->where('post_id',$id)->get();

          foreach ($view_count as $value){
              $value->delete();
          }
        }

        Session::flash('success','Post removed successfully!');
        return redirect()->route('dashboard');
    }

    public function react(Request $request)
    {
       $post_id = $request->post_id;
       $user_id = $request->user_id;

       $react = DB::table('reacts')->where('user_id',$user_id)->where('post_id',$post_id)->first();

       if($react != null){

            DB::table('reacts')->where('id',$react->id)->update([
               'react_yn'=> isset($react->react_yn) && $react->react_yn == 'Y' ? "N" : "Y",
               'updated_at'=> now()
           ]);
       }
       else{

            DB::table('reacts')->insert([
               'user_id'=> $user_id,
               'post_id'=> $post_id,
               'react_yn'=> 'Y',
               'created_at'=> now(),
           ]);
       }

        $react = DB::table('reacts')->where('user_id',$user_id)->where('post_id',$post_id)->first();
       $react_count = DB::table('reacts')->where('post_id',$post_id)->where('react_yn','Y')->count();

       return response()->json(['react'=>$react,'react_count' => $react_count]);

    }

}
