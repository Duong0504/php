<?php
class Controller {
    public $db;
    public function model($model){
        if(file_exists(_DIR_ROOT."/app/models/{$model}.php")){
            require_once(_DIR_ROOT."/app/models/{$model}.php");
            if(class_exists($model, true)){
                $model = new $model();
                return $model;
            }  
        }
        return false;
    }
    public function render($view, $data=[]) {
        if(!empty(View::$dataShare)){
            $data =  array_merge($data, View::$dataShare);
        }
        extract($data); // chuyển key về làm biến và value về làm giá trị của biến
        if(preg_match('~^layout~', $view)){
            if((file_exists(_DIR_ROOT."/app/views/{$view}.php"))) {
                require_once(_DIR_ROOT."/app/views/{$view}.php");
            }
        }else {
            $contentView =null;
            if((file_exists(_DIR_ROOT."/app/views/{$view}.php"))) {
                $contentView = file_get_contents(_DIR_ROOT."/app/views/{$view}.php");
            }
            $template = new Template();
            $template->run($contentView, $data);
        }
    }
}