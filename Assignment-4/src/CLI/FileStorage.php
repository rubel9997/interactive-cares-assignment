<?php

namespace App\CLI;

class FileStorage implements Storage
{

    public function save(string $model,array $data):void{
        file_put_contents($this->getModelPath($model),serialize($data));
    }
    public function load(string $model):array{

       if(file_exists($this->getModelPath($model))){
            return unserialize(file_get_contents($this->getModelPath($model)));
       }
       return [];

    }
    public function getModelPath(string $model):string{
        return 'data/' . $model . ".txt";
    }

}