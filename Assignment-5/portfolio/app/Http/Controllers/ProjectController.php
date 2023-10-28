<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProjectController extends Controller
{
    public function index(){
        // $filepath = Storage::path('data/projects.json');
        //$filepath = json_decode(file_get_contents(storage_path('data/projects.json')));

        $file = File::json(storage_path('data/projects.json'));
        return view('projects.index',['data'=>$file]);
    }


    public function view(Request $request){
        //dd($request);
        $id = $request->id;
        $project= $this->getProjectById($id);

        if($project){
            return view('projects.view',compact('project'));
        }

    }

    public function getProjectById($id){
        $file = File::json(storage_path('data/projects.json'));

        foreach($file as $value){
            if($id == $value['id']){
                return $value;
            }
        }
        return null;
    }
}

