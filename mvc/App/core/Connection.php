<?php
class Connection {
    private static $instance = null;
    private $connect;
    private function __construct($config)
    {
        try {
            if(class_exists('PDO')){
                $dsn = $config['driver'].':host='.$config['host'].';dbname='.$config['dbname'];
                $option = [
                    PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',
                    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                ];
                $this->connect = new PDO($dsn, $config['username'], $config['pass'], $option);
            }
        }catch(Exception $exception){
            App::$app->loadErrors('database', $exception->getMessage());
            die();
        }
    }
    public static function getInstance($config) {
        if (self::$instance == null) {
            self::$instance = new Connection($config);
        }
        return self::$instance;
    }
    public function getConnect() {
        return $this->connect;
    }
}