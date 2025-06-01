<?php
class DB {
    // global query builder
    public $db;
    public function __construct()
    {
        $this->db = new Database();
    }
}