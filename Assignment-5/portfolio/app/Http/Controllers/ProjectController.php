<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(){
        // $filepath = Storage::path('data/projects.json');
        //$filepath = json_decode(file_get_contents(storage_path('data/projects.json')));

        $file = File::json(storage_path('data/projects.json'));
        return view('projects.index',['data'=>$file]);
    }


    public function view(){
        return view('project.view');
    }
}
