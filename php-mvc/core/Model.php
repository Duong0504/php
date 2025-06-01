<?php
abstract class Model extends Database {
    protected $db;
    public function __construct()
    {
       $this->db = new Database();
    }
    abstract function tableFill();
    abstract function fieldFill();
    abstract function primaryKey();
    // sủa dụng khi không sửa dụng query builder
    public function all(){
        $tableName =  $this->tableFill();
        $fieldSelect = $this->fieldFill();
        if(empty($fieldSelect)){$fieldSelect = '*';}
        $sql = "SELECT {$fieldSelect} FROM {$tableName}";
        $query = $this->db->getRow($sql);
        if (!empty($query)) {
            return $query;
        }
    }
    public function find($value){
        $tableName =  $this->tableFill();
        $fieldSelect = $this->fieldFill();
        $primaryKey = $this->primaryKey();
        if(empty($fieldSelect)){$fieldSelect = '*';}
        $sql = "SELECT {$fieldSelect} FROM {$tableName} WHERE $primaryKey = $value";
        $query = $this->db->firstRaw($sql);
        if (!empty($query)) {
            return $query;
        }
    }
}