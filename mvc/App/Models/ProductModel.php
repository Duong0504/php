<?php 

class ProductModel {
    private $table ="products";

    public function getList()
    {
        $data =  [
            "Sản phẩm 1",
            "Sản phẩm 2",
            "Sản phẩm 3",
        ];
        return $data;
    }
}