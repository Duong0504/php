<?php
define('_DIR_ROOT', __DIR__);
// Xử lý http và https
if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $web_root = "https://". $_SERVER['HTTP_HOST'];
}else {
    $web_root = "http://". $_SERVER['HTTP_HOST'];
}
$dirRoot = str_replace('\\', '/', _DIR_ROOT);
$documentRoot = $_SERVER['DOCUMENT_ROOT'];
$forder = str_replace(strtolower($documentRoot),  '', strtolower($dirRoot));
$web_root = $web_root.$forder;
define("_WEB_ROOT", $web_root);
// Tự động load config
$config_dir = scandir('configs');
if(!empty($config_dir)) {
    foreach($config_dir as $item) {
        if($item !='.' && $item != ".." && file_exists("configs/".$item)){
            require_once("configs/".$item); // load routers config
        }
    }
}

// Load Service Provider
require_once "core/ServiceProvider.php";
// Load View share
require_once "core/View.php";
// load app
if(!empty($config['app']['service'])){
    $allService =  $config['app']['service'];
    if(!empty($allService)){
        foreach($allService as $serviceName){
            if(file_exists("app/core/{$serviceName}.php")){
                require_once "app/core/{$serviceName}.php";
            }
        }
    }
    
}

require_once "core/Load.php";
// Middleware
require_once "core/Middleware.php";
require_once("core/Route.php"); // load router class
require_once "core/Session.php";
// Kiểm tra config và load database
if (!empty($config['database'])) {
    // $db_config = array_filter($config['database']);
    $db_config = $config['database'];
    if (!empty($db_config)) {
        require_once("core/Connection.php");
        require_once("core/QueryBuilder.php"); // load querybuilder
        require_once("core/Database.php");
        require_once("core/DB.php");
    }
}

require_once "core/Helper.php";
// Load all helper
$allHelper =  scandir('app/helpers',1);
if(!empty($allHelper)){
    foreach($allHelper as $item){
        if($item !='.' && $item != ".." && file_exists("app/helpers/{$item}")){
            require_once "app/helpers/$item";
        }
    }
}
require_once("app/App.php"); // load app
require_once("core/Model.php"); // load base model
require_once("core/Template.php");
require_once("core/Controller.php"); // loadcontroller
require_once("core/Request.php"); // loadcontroller
require_once("core/Response.php");