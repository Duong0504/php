<?php

class Product extends Controller {
    private $data = [];

    public function index()
    {
        echo "Đây là trang sản phẩm";
        
    }
    public function list()
    {
        $model = $this->model('product');
        $this->data['products_list'] = $model->getList();
        
        $this->view('products/list', $this->data);
    }

    public function detail($id = 0)
    {
        $model = $this->model('product');
        $this->data['product_datail'] = $model->getList()[$id];

        $this->view('products/detail', $this->data);

    }
}