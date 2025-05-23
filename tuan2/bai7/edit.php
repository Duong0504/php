<?php
session_start();
include_once 'connections/Database.php';
$masp = $_GET['id'];
$product = firstRaw("SELECT * FROM `products` WHERE `masp` = $masp");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Sản Phẩm</title>
    <link rel="stylesheet" href="form_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="breadcrumbs mb-5">
        <div class="container">
            <a href="index.php">Dashboard</a> &gt; Sửa sản phẩm
        </div>
    </div>

    <main class="form-container container">
        <h2>Thêm Sản Phẩm Mới</h2>
        <form action="handel_edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="masp" value="<?php echo $product['masp']; ?>">
            <div class="form-group mb-3">
                <label for="productName">Tên sản phẩm <span class="required">*</span></label>
                <input class="form-control" type="text" id="productName" name="tensanpham" value="<?php echo $product['tensanpham'] ?>" placeholder="Nhập tên sản phẩm" required>
            </div>

            <div class="form-group mb-3">
                <label for="productPrice">Giá (VNĐ) <span class="required">*</span></label>
                <input type="number" value="<?php echo $product['giaban'] ?>" class="form-control" id="productPrice" name="giaban" placeholder="VD: 1500000" min="0" required>
            </div>

            <div class="form-group mb-3">
                <label for="productSalePrice">Giá khuyến mãi (nếu có)</label>
                <input type="number" value="<?php echo $product['giakhuyenmai'] ?>" class="form-control" id="productSalePrice" name="giakhuyenmai" placeholder="VD: 1200000" min="0">
            </div>


            <div class="form-group mb-3">
                <label for="productDescription">Mô tả sản phẩm</label>
                <textarea class="form-control" value="<?php echo $product['motangan'] ?>" id="productDescription" name="motangan" rows="6" placeholder="Mô tả chi tiết về sản phẩm..."></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="productSpecs">Thông số kỹ thuật (mỗi dòng một thông số)</label>
                <textarea class="form-control" value="<?php echo $product['motachitiet'] ?>" id="productSpecs" name="motachitiet" rows="4" placeholder="Màn hình: 6.1 inch OLED
Chip: A17 Bionic
RAM: 8GB
Bộ nhớ: 256GB"></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="productImage">Ảnh sản phẩm <span class="required">*</span></label>
                <input type="file" class="form-control" id="productImage" name="hinhanh" accept="image/*" multiple required>
                <div class="image-preview" id="imagePreview">
                    </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-save"></i>Cập nhật Sản Phẩm</button>
            </div>
        </form>
    </main>

    <footer class="main-footer mt-5">
        <div class="container">
            <p>&copy; 2024 Admin Dashboard. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>