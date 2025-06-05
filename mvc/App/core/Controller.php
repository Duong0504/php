<?php

class Controller {
    public function model($model)
    {
        $model = ucfirst($model)."Model";
        if (file_exists(__ROOT__."/App/Models/$model.php")) {
            require_once __ROOT__."/App/Models/$model.php";
            if (class_exists($model)) {
                return  new $model();
            }
        }
        return false;
    }

    public function view($view, $data= [])
    {
        extract($data);
        if (file_exists(__ROOT__."/App/views/$view.php")) {
            require_once __ROOT__."/App/views/$view.php";
        }
    }

    public function redirect($location)
    {
        $location = ucfirst($location);
        $location = __ROOT__."/App/Controller/$location.php";
        echo $location;
        header("Location: $location");
        exit;
    }
}