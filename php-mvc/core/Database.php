<?php
class Database {
    private $__conn;
    use QueryBuilder;
    public function __construct()
    {
        global $db_config;     
        $this->__conn = Connection::getInstance($db_config)->getConnect();
    }
    function query($sql, $data = [], $stament=false) {
        $query = false;
        try {
            $stmt = $this->__conn->prepare($sql);
            if(empty($data)){
                $query = $stmt->execute();
            }else {
                $query = $stmt->execute($data);
            }
        }catch(Exception $exception) {
            $data['message']  = $exception->getMessage();
            App::$app->loadErrors('database', $data);
            die();
        }
        if($stament && $query){
            return $stmt;
        }
        return $query;  
    }
    
    function insertDatabase($table, $dataInsert) {
        # Tách key từ array
        $keyArr = array_keys($dataInsert);
        $fieldStr = implode(',', $keyArr);
        $valueStr = implode(', :', $keyArr);
        $sql = "INSERT INTO {$table}($fieldStr) VALUES (:$valueStr)";
        return $this->query($sql, $dataInsert);
    }

    function updateDatabase($table, $dataUpdate, $conditon=''){
        $updateStr = '';
        foreach($dataUpdate as $key => $value){
            $updateStr.=$key.'=:'.$key. ', '; 
        }
        $updateStr = rtrim($updateStr , ', ');
        if(!empty($conditon)){
            $sql = "UPDATE $table SET $updateStr WHERE $conditon";
        }else {
            $sql = "UPDATE $table SET $updateStr";
        }
        return $this->query($sql, $dataUpdate);
    }
    
    function deleteDatabase($table, $conditon = ''){
        if(!empty($conditon)){
            $sql = "DELETE FROM $table WHERE $conditon";
        }else {
            $sql = "DELETE FROM $table";
        }  
        return $this->query($sql);
    }
    // Lấy tất cả dư liệu từ câu lệnh sql
    function getRow($sql) {
        $stament = $this->query($sql, [], true);
        if(is_object($stament)){
            $data = $stament->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } 
        return false;
    }
    // Lấy 1 phần tử trong csdl
    function firstRaw($sql) {
        $stament = $this->query($sql, [], true);
        if(is_object($stament)){
            $data = $stament->fetch(PDO::FETCH_ASSOC);
            return $data;
        } 
        return false;
    }
    // Trả về id mới nhất vừa đc insert
    public function LastInsertId()
    {
        return $this->__conn->lastInsertId();
    }
    // function bổ sung
    function getRows($sql){
        $stament = $this->query($sql, [], true);
        if(!empty($stament)){
            return $stament->rowCount();
        }
    }
}