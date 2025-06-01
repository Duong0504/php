<?php
class Load {
    static public function model(String $model)
    {
        if(file_exists(_DIR_ROOT."/app/models/{$model}.php")){
            require_once(_DIR_ROOT."/app/models/{$model}.php");
            if(class_exists($model, true)){
                $model = new $model();
                return $model;
            }  
        }
        return false; 
    }
    static public function view($view, $data=[]) {
        extract($data); // chuyển key về làm biến và value về làm giá trị của biến
        if((file_exists(_DIR_ROOT."/app/views/{$view}.php"))) {
            require_once(_DIR_ROOT."/app/views/{$view}.php");
            // return true;
        }
        // return false;
    }
}