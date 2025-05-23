<?php 
    session_start();
    include_once './connections/Database.php';
    // include_once './products.php';
    $products = getRow("SELECT * FROM `products`");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản Phẩm - Điện Thoại XYZ</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="logo">
                <a href="#">Shop Điện Thoại</a>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="#">Trang chủ</a></li>
                    <li><a href="#">Sản phẩm</a></li>
                    <li><a href="add.php">Thêm sản phẩm</a></li>
                    <li><a href="#">Liên hệ</a></li>
                </ul>
            </nav>
            <div class="header-icons">
                <a href="#" class="search-icon"><i class="fas fa-search"></i></a>
                <a href="#" class="cart-icon"><i class="fas fa-shopping-cart"></i> <span>0</span></a>
                <a href="#" class="user-icon"><i class="fas fa-user"></i></a>
            </div>
        </div>
    </header>

    <div class="breadcrumbs">
        <div class="container">
            <a href="#">Trang chủ</a> &gt; <a href="#">Điện thoại</a> &gt; Điện Thoại XYZ
        </div>
    </div>

    <main class="product-page container">
        <?php if (isset($_SESSION['mes'])): ?>
        <p style="color: red; background: black;"><?php echo $_SESSION['mes']; unset($_SESSION['mes']); ?></p>
        <?php endif; ?>
       <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá bán</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $key => $product): ?>
                <tr>
                    <th><?php echo $key++ ?></th>
                    <th><img width="100px" src="<?php echo $product['hinhanh'] ?>" alt=""></th>
                    <td><?php echo $product['tensanpham'] ?></td>
                    <td><?php echo number_format($product['giaban'], 0) ?></td>
                    <td>Còn hàng</td>
                    <td>
                        <a href="edit.php?id=<?php echo $product['masp']?>">Sửa</a>
                        <a href="delete.php?id=<?php echo $product['masp']?>" onclick="return confirm('Xóa?')">Xoá</a>

                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </main>

    <footer class="main-footer">
        <div class="container">
            <div class="footer-col">
                <h4>Về chúng tôi</h4>
                <ul>
                    <li><a href="#">Câu chuyện thương hiệu</a></li>
                    <li><a href="#">Cơ hội nghề nghiệp</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Hỗ trợ khách hàng</h4>
                <ul>
                    <li><a href="#">Chính sách đổi trả</a></li>
                    <li><a href="#">Chính sách bảo mật</a></li>
                    <li><a href="#">Điều khoản sử dụng</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Liên hệ</h4>
                <p><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận XYZ, TP. Hà Nội</p>
                <p><i class="fas fa-phone"></i> 0123 456 789</p>
                <p><i class="fas fa-envelope"></i> info@shopdienthoai.com</p>
            </div>
            <div class="footer-col">
                <h4>Kết nối với chúng tôi</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Shop Điện Thoại Việt Nam. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetTab = button.dataset.tab;

                    // Remove active class from all buttons and content
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    // Add active class to clicked button and target content
                    button.classList.add('active');
                    document.getElementById(targetTab).classList.add('active');
                });
            });

            // Basic thumbnail click for main image (add more sophisticated logic for actual product images)
            const thumbnails = document.querySelectorAll('.thumbnails img');
            const mainImage = document.querySelector('.main-image img');

            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', () => {
                    mainImage.src = thumbnail.src.replace('100x100', '600x600').replace('Thumb', 'Product');
                    // In a real scenario, you'd have different full-size images mapped to thumbnails
                });
            });
        });
    </script>
</body>
</html>