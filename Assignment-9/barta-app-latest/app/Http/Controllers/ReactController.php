<?php

namespace App\Http\Controllers;

use App\Models\React;
use Illuminate\Http\Request;

class ReactController extends Controller
{
    public function react(Request $request)
    {
        $post_id = $request->post_id;
        $user_id = $request->user_id;

        $react = React::where('user_id', $user_id)->where('post_id', $post_id)->first();

        if ($react != null) {

            React::where('id', $react->id)->update([
                'react_yn' => isset($react->react_yn) && $react->react_yn == 'Y' ? 'N' : 'Y',
            ]);
        } else {

            React::create([
                'user_id' => $user_id,
                'post_id' => $post_id,
                'react_yn' => 'Y',
            ]);
        }

        $react = React::where('user_id', $user_id)->where('post_id', $post_id)->first();

        $react_count = React::where('post_id', $post_id)->where('react_yn', 'Y')->count();

        return response()->json(['react' => $react, 'react_count' => $react_count]);

    }
}
