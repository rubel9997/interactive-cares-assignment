<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReactController extends Controller
{
    public function react(Request $request)
    {
        $post_id = $request->post_id;
        $user_id = $request->user_id;

        $react = DB::table('reacts')->where('user_id', $user_id)->where('post_id', $post_id)->first();

        if ($react != null) {

            DB::table('reacts')->where('id', $react->id)->update([
                'react_yn' => isset($react->react_yn) && $react->react_yn == 'Y' ? 'N' : 'Y',
                'updated_at' => now(),
            ]);
        } else {

            DB::table('reacts')->insert([
                'user_id' => $user_id,
                'post_id' => $post_id,
                'react_yn' => 'Y',
                'created_at' => now(),
            ]);
        }

        $react = DB::table('reacts')->where('user_id', $user_id)->where('post_id', $post_id)->first();
        $react_count = DB::table('reacts')->where('post_id', $post_id)->where('react_yn', 'Y')->count();

        return response()->json(['react' => $react, 'react_count' => $react_count]);

    }
}
