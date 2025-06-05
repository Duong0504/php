<?php
trait QueryBuilder {
    public $tableName = '';
    public $where = '', $selectField = '*';
    public $operator = '';
    public $limit = '';
    public $orderBy = '';
    public $innerJoin = '';
    public function table($tableName) {
        $this->tableName = $tableName;
        return $this;
    }
    public function where($field, $compare, $value){
        if(empty($this->operator)) {
            $this->operator = 'WHERE';
        }else {
            $this->operator = ' AND';
        }
        $this->where .= "{$this->operator} {$field} {$compare} '{$value}'";
        return $this;
    }
    public function orWhere($field, $compare, $value){
        if(empty($this->operator)){
            $this->operator = 'WHERE';
        }else {
            $this->operator = ' OR';
        }
        $this->where .= "$this->operator $field $compare $value";
        return $this;
    }
    public function whereLike($field, $value){
        if(empty($this->operator)) {
            $this->operator = 'WHERE';
        }else {
            $this->operator = ' AND';
        }
        $this->where .= "$this->operator $field LIKE '$value'";
        return $this;
    }
    public function select($field= '*') {
        $this->selectField = $field;
        return $this;
    }

    public function limit($number, $offset=0) {
        $this->limit = "LIMIT $offset, $number";
        return $this;
    }
    
    public function orderBy($field, $type='ASC') {
        $fieldArr = array_filter(explode(',', $field));
        if(!empty($field) && count($fieldArr) >= 2){
            $this->orderBy = "ORDER BY ". implode(', ', $fieldArr);
        }else {
            $this->orderBy = "ORDER BY $field  $type";
        }
        return $this;
    }

    // Inner join 
    public function join($tableName, $relationship){
        $this->innerJoin .= "INNER JOIN $tableName ON $relationship ";
        return $this;
    }
    // insert
    public function insert($data){
        $table = $this->tableName;
        $insertData =  $this->insertDatabase($table, $data);
        return $insertData;
    }
    // lasst id
    public function lastId() {
        return $this->LastInsertId();
    }
    public function update($data) {
        $whereUpdate = str_replace('WHERE', '', $this->where);
        $whereUpdate = trim($whereUpdate);
        $table = $this->tableName;
        $updateStatus = $this->updateDatabase($table, $data, $whereUpdate);
        return $updateStatus;
    }

    public function delete(){
        $whereDelete = str_replace('WHERE', '', $this->where);
        $whereDelete = trim($whereDelete);
        $table = $this->tableName;
        $deleteStatus = $this->deleteDatabase($table, $whereDelete);
        return $deleteStatus;
    }

    public function get() {
        $sqlQuery = "SELECT {$this->selectField} FROM {$this->tableName} {$this->innerJoin} {$this->where} $this->orderBy $this->limit";
        // echo $sqlQuery;
        $query = $this->getRow($sqlQuery);
        // reset field
        $this->resetQuery();
        if(!empty($query)){
            return $query; //->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }
    public function first(){
        $sqlQuery = "SELECT {$this->selectField} FROM {$this->tableName} {$this->innerJoin} {$this->where} $this->limit";
        $query = $this->firstRaw($sqlQuery);//query($sqlQuery);
       // reset field
        $this->resetQuery();
        if(!empty($query)){
            return $query;//->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function resetQuery(){
         $this->tableName = '';
        $this->where = '';
        $this->operator = '';
        $this->selectField ='';
        $this->limit="";
        $this->innerJoin ="";
        $this->orderBy = "";
    }
}