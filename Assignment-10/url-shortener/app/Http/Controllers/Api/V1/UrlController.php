<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UrlSotreRequest;
use App\Http\Resources\UrlResource;
use App\Models\Url;
use App\Services\Services;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urls = Url::with('user')->where('user_id',auth()->user()->id)->get();
        return response()->json([
            'urls' => UrlResource::collection($urls),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UrlSotreRequest $request,Services $services)
    {
        $url_exists = Url::where('original_url',$request->original_url)->where('user_id',auth()->user()->id)->first();

        if($url_exists){
            return response()->json([
                'url' => new UrlResource($url_exists),
            ]);
        }

       $url = $services->store($request->validated());

        return response()->json([
            'message' => 'Url inserted successfully.',
            'url' => new UrlResource($url),
        ], Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     */
    public function show(Url $url)
    {
        $url->load('user');
        return response()->json([
            'url' => new UrlResource($url),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Url $url,Services $services)
    {
        $services->destroy($url);
        return response()->json([
            'message' => 'Url deleted successfully.',
        ], Response::HTTP_OK);
    }
}
