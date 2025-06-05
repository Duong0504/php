<?php
define("__ROOT__", __DIR__);
require_once "./App/configs/app.php";
require_once "./App/core/Controller.php";
require_once "./App/App.php";

if (file_exists("./App/App.php")) {
    if (class_exists("App")) {
        $app = new App();
    }
}else {
    echo "Error";
}