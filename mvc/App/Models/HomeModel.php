<?php

class HomeModel {
    public $table = "product";
    public function __construct() {
        // echo $this->table;
    }

    public function getList()
    {
        $data  = [
            'id',
            "name"
        ];
        return $data;
    }
}