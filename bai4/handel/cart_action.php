<?php
session_start();
$http_referer =  $_SERVER['HTTP_REFERER'];
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// thêm vào cart
if(isset($_POST['add_to_cart'])) {
    $product_id =  $_POST['id'];
    $product_name = $_POST['name'];
    $product_price =  $_POST['price'];
    $product_image = $_POST['image'];
    $product_quantity = $_POST['quantity'] ?? 1; 

    // kiểm tra đã có sản phẩm trong giỏ hàng hay chưa

    if(isset($_SESSION['cart'][$product_id])){
        $_SESSION['cart'][$product_id]['quantity'] += $product_quantity;
    }else {
        $_SESSION['cart'][$product_id] = [
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'image' => $product_image,
            'quantity' => $product_quantity
        ];
    }

    $_SESSION['massage'] = 'Thêm sản phẩm thành công';
    $http_referer =  $_SERVER['HTTP_REFERER'];
    header("Location: $http_referer");
    exit;

}

// update cart

if(isset($_POST['update_cart'])) {
    $product_id = $_POST['id']; 
    $new_quantity = $_POST['quantity'];

    if($new_quantity > 0 ) {
        $_SESSION['cart'][$product_id]['quantity'] = $new_quantity;
        $_SESSION['message'] = 'Sản phẩm đã được cập nhập';
        
    }else {
        unset($_SESSION['cart'][$product_id]);
        $_SESSION['message'] = 'Sản phẩm đã bị xóa ';
        
    }
   
    header("Location: $http_referer");
    exit;

}

echo "<pre>";
var_dump($_GET);
echo "<pre>";

// xoá sản phẩm khỏi giỏ hàng
if(isset($_GET['remove_from_cart']) && isset($_GET['id'])) {
    $product_id = $_GET['id'];
    if(isset($_SESSION['cart'][$product_id])){
        unset($_SESSION['cart'][$product_id]);
        $_SESSION['message'] =  'Sản phẩm đã bị xóa khỏi giỏ hàng';
        header("Location: $http_referer");
    }
}

// xoa toan bo gio hang

if(isset($_GET['action']) && $_GET['action'] = true) {
    unset($_SESSION['cart']);
    $_SESSION['message'] =  'Toàn bộ sản phẩm bị xóa khỏi giỏ hàng';
    header("Location: $http_referer");

}
// echo "<pre>";
// var_dump($_SESSION['cart']);
// echo "<pre>";
