<?php
class Product extends Controller{ 
    private $data = [];
    public function index() {
       echo "Trang sản phẩm";
    }
    public function list_product(){
        $product = $this->model('ProductModel');
        $dataProduct =  $product->getProductList();
        // Render ra view
        $this->data['sub_content']['dataProduct_'] = $dataProduct;
        $this->data['pageTitle'] = "Sản phẩm";
        $this->data['content'] = "products/list";
        $this->render("layout/client_layout", $this->data);
    }
    public function detail($id=0){
        $productDetail =  $this->model('ProductModel');
        $this->data['sub_content']['info'] = $productDetail->getDetail($id);
        $this->data['pageTitle'] = "Chi tiết sản phẩm";
        $this->data['content'] = "products/detail";
        $this->render("layout/client_layout", $this->data);
    }
}