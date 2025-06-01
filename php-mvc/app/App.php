<?php
/**File làm việc với 3 folder */
// Khởi tạo class
class App {
    private $__controller, $__action, $__params, $__route, $__db;
    static public  $app;
    public function __construct()
    {
        global $routes;
        self::$app = $this;
        $this->__route = new Route;
        if(!empty($routes['default_controller'])){
            $this->__controller = $routes['default_controller'];
        }
        $this->__action = 'index';
        $this->__params = [];
        // Kiểm tra tồn tại class DB thì ms khởi tạo
        if(class_exists('DB', true)){
            $dbObject = new DB();
            $this->__db = $dbObject->db;
        }
        $this->handleUrl();
    }
    public function getUrl() {
        if(!empty($_SERVER['PATH_INFO'])){
            $url = $_SERVER['PATH_INFO'];
        }else {
            $url = '/';
        }
        return $url;
    }
    public function handleUrl(){
        $url = $this->getUrl();
        // Viét đường dân theo thân thiện
        $url = $this->__route->handleRoute($url);

        // service provider
        $this->handleAppServiceProvider($this->__db);
        // Middleware app
        $this->handleGlobalMiddleware($this->__db);
        $this->handleRouteMiddleware($this->__route->getUri(),$this->__db);
        // xử lý url
        $urlArr = array_filter(explode('/', $url));
        $urlArr =  array_values($urlArr);
        $urlCheck = '';
        if(!empty($urlArr)) {
            foreach($urlArr as $key=> $item) {
                $urlCheck.=$item.'/';
                $fileCheck = rtrim($urlCheck, '/'); // Loại bỏ kí tự / cuối cùng
                // Chuyển về mảng để xử lý viết hoa từ cuối. để kiểm tra file có tồn tại
                $fileArr = explode("/", $fileCheck);
                //c1
                // $fileArr[count($fileArr)-1] = ucfirst(end($fileArr));
                // c2
                $fileArr[count($fileArr)-1] =  ucfirst($fileArr[count($fileArr)-1]);
                $fileCheck = implode('/', $fileArr);
                if(!empty($urlArr[$key-1])) {
                    unset($urlArr[$key-1]);
                }
                if(file_exists('app/controllers/'.$fileCheck.'.php')) {
                    $urlCheck = $fileCheck;
                    break;
                }
            }
            $urlArr = array_values($urlArr);
        }
        if(!empty($urlArr[0])) {
            $this->__controller = ucfirst($urlArr[0]);
        }else {
            $this->__controller = ucfirst($this->__controller);
        }

        if(!empty($urlCheck)){
            $modules = "app/controllers/{$urlCheck}.php";
        }else {
            $modules = "app/controllers/{$this->__controller}.php";
        }
        if(file_exists($modules)){
            require($modules);
            // Kiểm tra class của $this->__controllers có tồn tại
            if(class_exists($this->__controller, true)){
                $this->__controller = new $this->__controller();
                // kiểm tra thuộc tính __db có data ko
                if(!empty($this->__db)) {
                    $this->__controller->db =  $this->__db;
                }
            }else{
                $this->loadErrors();
            }
            unset($urlArr[0]);
        }else{
            return $this->loadErrors();
        }
        // Xử lý action
        if(!empty($urlArr[1])){
            $this->__action = $urlArr[1];
            unset($urlArr[1]);
        }
        // Xử lý params
        $this->__params = array_values($urlArr);
        // Kiểm tra methods tồn tại
        if(method_exists($this->__controller, $this->__action)){
            call_user_func_array([$this->__controller, $this->__action],$this->__params);
        }else{
           return $this->loadErrors();
        }
    }

    public function handleRouteMiddleware($routeKey, $db) {
        // Middleware app    
        global $config;
        if(!empty($config['app']['routeMiddleware'])){
            $routeMiddlewareArr= $config['app']['routeMiddleware'];
            foreach($routeMiddlewareArr as $key=> $middleWareItem){
                if(trim($routeKey)== trim($key) && file_exists('app/middlewares/'.$middleWareItem.'.php')){
                    require_once 'app/middlewares/'.$middleWareItem.'.php';
                    if(class_exists($middleWareItem)){
                        $middleWareObject = new $middleWareItem();
                        $middleWareObject->db = $db;
                        $middleWareObject->handle();
                    }
                }
            }
        }
    }

    public function handleGlobalMiddleware($db){
        global $config;
        if(!empty($config['app']['globalMiddleware'])){
            $globalMiddlewareArr= $config['app']['globalMiddleware'];
            foreach($globalMiddlewareArr as $key=> $middleWareItem){
                if(file_exists('app/middlewares/'.$middleWareItem.'.php')){
                    require_once 'app/middlewares/'.$middleWareItem.'.php';
                    if(class_exists($middleWareItem)){
                        $middleWareObject = new $middleWareItem();
                        $middleWareObject->db = $db;
                        $middleWareObject->handle();
                    }
                }
            }
        }
    }
    // View share
    public function handleAppServiceProvider($db)
    {
        global $config;
        if(!empty($config['app']['boot'])){
            $serviceProvider = $config['app']['boot'];
            foreach($serviceProvider as $serviceItem){
                if(file_exists("app/core/{$serviceItem}.php")){
                    require_once "app/core/{$serviceItem}.php";
                    if(class_exists($serviceItem)){
                        $serviceProvider = new $serviceItem();
                        if(!empty($db)){
                            $serviceProvider->db = $db;
                        }
                        $serviceProvider->boot();
                    }
                }
            }
        }
    }
    public function getCurrentController(){
        return $this->__controller;
    }
    public function loadErrors($error='404', $data=[]){
        if(is_array($data)){
             extract($data);
        }
        require "errors/{$error}.php";
    }
}