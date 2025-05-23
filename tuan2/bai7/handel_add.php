<?php
session_start();
include_once 'connections/Database.php';
if(isset($_POST['add'])) {

    
    $tensanpham =  $_POST['tensanpham'];
    $giaban =  $_POST['giaban'];
    $giakhuyenmai =  $_POST['giakhuyenmai'];
    $motangan =  $_POST['motangan'];
    $motachitiet =  $_POST['motachitiet'];

    // check hinh anh
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["hinhanh"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["hinhanh"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    

    // Check if file already exists
    if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["hinhanh"]["size"] > 1500000) {
        echo "Sorry, your file is too large.";
    $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    }


    //
    $errors = [];
    if(empty($tensanpham)) {
        $errors[] = 'Tên sản phẩm không được để trống';
    }
    if(empty($giaban)) {
        $errors[] = 'Giá sản phẩm không được để trống';
    }
    if(!empty($errors)) {
        $_SESSION['mes'] = implode(" - ", $errors );
    }else{
        if (move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $target_file)) {
            $ins =  insert("products",[
                'tensanpham' => $tensanpham,
                'giaban'=> $giaban,
                'giakhuyenmai' => $giakhuyenmai,
                'motangan'=> $motangan,
                'motachitiet' => $motachitiet,
                'hinhanh' => $target_file
            ]);
            if($ins) {
                $_SESSION['mes'] = 'Add product successfully';
            }else {
                $_SESSION['mes'] = 'Add product error';
            }
        
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
        
        header('location: index.php');
        exit();
    }

}