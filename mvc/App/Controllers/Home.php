<?php

class Home extends Controller{
    private $model;
    private $data = [];
    public function __construct() {
        $this->model =  $this->model('home');
    }

    public function index()
    {
        // $data = $this->model->getList();
        $this->data['content'] = "home/index";
        $this->view("layouts/client", $this->data);
    }

    public function detail($id = "2", $slug = null)
    {
        echo $id;
    }
};