<?php
session_start();
include_once 'connections/Database.php';

$masp = $_GET['id'];
$dele = delete('products', "masp=$masp");
if($ins) {
    $_SESSION['mes'] = 'Delete product successfully';
}else {
    $_SESSION['mes'] = 'Delete product error';
}header('location: index.php');
        exit();