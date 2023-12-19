<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Url;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    /**
     * Handle the incoming request.
     */

    public function visitCount(Request $request)
    {
        $url = Url::where('shortener_url', $request->shortener_url)->first();

        if($url){
            $url->increment('visits');
            return redirect($url->original_url);
        }

        return redirect('/');
    }
}
