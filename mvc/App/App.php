<?php

class App {
    private $controller, $action, $parram;
    static public $app;
    public function __construct() {
        global $config;
        self::$app = $this;
        if(!empty($config)){
            $this->controller = $config['controller'];
            $this->action = $config['action'];
            $this->parram = $config['parram'];
        }
        $this->handelUrl();
    }

    private function getUrl() {
        return $_SERVER["PATH_INFO"] ?? "/";
    }
    private function handelUrl() {
        $url =  $this->getUrl();
        if (!empty($url)) {
            $urLArr =  array_values(array_filter(explode('/', $url)));
        }
        // Handel controller
        if (!empty($urLArr[0])) {
            $this->controller =  ucfirst($urLArr[0]);
        }else {
            $this->controller = ucfirst($this->controller);
        }

        if (file_exists("App/Controllers/$this->controller.php")) {
            require_once "App/Controllers/$this->controller.php";
            if (class_exists($this->controller)) {
                $this->controller = new $this->controller;
                unset($urLArr[0]);
                // Handel action
                if (!empty($urLArr[1])) {
                    $this->action = strtolower($urLArr[1]);
                    unset($urLArr[1]);
                }
                if (method_exists($this->controller, $this->action)) {
                    // handel param
                    if (!empty($urLArr)) {
                        $this->parram = array_values($urLArr);
                    }
                    call_user_func_array([$this->controller, $this->action], $this->parram);
                    exit();
                }
            }
        }
        $this->getError('404');
        exit();
    }

    private function getError(String $error="404") {
            require_once "App/errors/$error.php";
    }


}