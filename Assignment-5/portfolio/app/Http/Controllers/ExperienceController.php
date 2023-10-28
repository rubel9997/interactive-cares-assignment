<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class ExperienceController extends Controller
{
    public function index(){
        $file = File::json(storage_path('data/experience.json'));
        return view('experience',compact('file'));
    }
}
