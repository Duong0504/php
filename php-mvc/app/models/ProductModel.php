<?php
class ProductModel extends Model{
    public function tableFill()
    {
        return "users";
    }
    public function fieldFill()
    {
        return '*';   
    }
    public function getProductList(){
        return [
            'Sản phẩm 1',
            'Sản phẩm 2',
            'Sản phẩm 3'
        ];
    }
    public function primaryKey(){
        
    }
    public function getDetail($id) {
            $db = new Database();
            $sqls = $db->getRow("SELECT * FROM `users`");
            $deltailArr = [
                ["id"=>1, "name"=>"Điện thoại Oppo", "Price"=>"20.000đ", "Mota"=>["Ram"=>"8GB","Rom"=>"126GB"]],
                ["id"=>2, "name"=>"Điện thoại Samsung", "Price"=>"20.000đ"],
            ];
            return $deltailArr[$id];
    }
}