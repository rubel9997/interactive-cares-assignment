<?php


namespace App\Services;


use App\Models\Url;
use Illuminate\Support\Str;

class Services
{

    public function store(array $data)
    {

        $data['user_id'] = auth()->user()->id;
        $data['shortener_url'] = base_convert(time(), 10, 36);

        $url = Url::create($data);

        return $url;
    }


    public function destroy($url)
    {
        $url->delete();
    }
}
