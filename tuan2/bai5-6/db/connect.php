<?php
$servername = "localhost";
$username = "root";
$password = "";
$databaseName= "quanlysinhvien";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$databaseName", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully";
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }


function query($sql, $data = [], $stament=false) {
    global $conn;
    $query = false;
    try {
        $stmt = $conn->prepare($sql);
        if(empty($data)){
            $query = $stmt->execute();
        }else {
            $query = $stmt->execute($data);
        }
    }catch(Exception $e) {
        echo "Connection failed: " . $e->getMessage();
        die();
    }
    if($stament && $query){
        return $stmt;
    }
    return $query;  
}

function insert($table, $dataInsert) {
    # Tách key từ array
    $keyArr = array_keys($dataInsert);
    $fieldStr = implode(',', $keyArr);
    $valueStr = implode(', :', $keyArr);
    $sql = "INSERT INTO {$table}($fieldStr) VALUES (:$valueStr)";
    return query($sql, $dataInsert);
}


function update($table, $dataUpdate, $conditon=''){
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
    return query($sql, $dataUpdate);
}

function delete($table, $conditon = ''){
    if(!empty($conditon)){
        $sql = "DELETE FROM $table WHERE $conditon";
    }else {
        $sql = "DELETE FROM $table";
    }  
    return query($sql);
}

// Lấy tất cả dư liệu từ câu lệnh sql
function getRow($sql) {
    $stament = query($sql, [], true);
    if(is_object($stament)){
        $data = $stament->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } 
    return false;
}

// Lấy 1 phần tử trong csdl
function firstRaw($sql) {
    $stament = query($sql, [], true);
    if(is_object($stament)){
        $data = $stament->fetch(PDO::FETCH_ASSOC);
        return $data;
    } 
    return false;
}

function get($table, $field = ['*'], $conditon=''){
    $fieldStr = implode(',' ,$field);
    $sql= 'SELECT '. $fieldStr . ' FROM '. $table;
    if(!empty($conditon)) {
        $sql.= ' WHERE ' . $conditon;
    }
    return getRow($sql);
}


function first($table, $field =['*'], $conditon='') {
    $fieldStr = implode(',', $field);
    $sql = 'SELECT '. $fieldStr . ' FROM '. $table;
    if(!empty($conditon)){
        $sql.=' WHERE '. $conditon;
    }
    return firstRaw($sql);
}

// function bổ sung
function getRows($sql){
    $stament = query($sql, [], true);
    if(!empty($stament)){
        return $stament->rowCount();
    }
}

function lastInsertId() {
    global $conn;
    return $conn->lastInsertId();
}
?>