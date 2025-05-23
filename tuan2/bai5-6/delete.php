<?php
session_start();
require_once './db/connect.php';
$masv =  $_GET['ma_sv'];
$dele = delete('sinh_vien', "MaSV = $masv");
if($dele) {
        $_SESSION['mes'] = 'Xoá sinh viên thành công';

    }else {
        $_SESSION['mes'] = 'Xoá sinh viên thất bại';
    }
    header('Location: index.php');
?>
