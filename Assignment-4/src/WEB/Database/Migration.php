<?php 

namespace App\WEB\Database;

use App\WEB\Storage\DB;


class Migration{

    private DB $db;

    public function __construct(DB $db){
            $this->db = $db;
    }

    public function run(){

        $files = glob(__DIR__.'/migrations/*');

            foreach($files as $file){
                if(is_file($file)){
                    $sql = file_get_contents($file);
                    $this->db->createTable($sql);
            }
        }
    }



}