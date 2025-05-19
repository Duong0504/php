<?php
session_start();

print_r(random_int(1, 100000));

// Tính tổng tiền
$total_price = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }
}
// unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <style>
        .text-center {
            text-align: center !important;
        }
        .img{
            display: block !important;
            max-width: 100% !important;
            width: 100% !important;
            height: 100% !important;
        }
        .img{
            border: none !important;
        }
        .buy-btn{
            background-color: #0071ce;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
        }

    </style>
    <title>Giỏ hàng của bạn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Giỏ hàng</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <p style="color: #45ef1f;"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 200px">Hình ảnh</th>
                    <th style="width: 200px">Tên sản phẩm</th>
                    <th style="width: 200px">Đơn giá</th>
                    <th style="width: 200px">Số lượng</th>
                    <th style="width: 200px">Tổng tiền</th>
                    <th class="text-center" style="width: 200px">
                        <img src="https://kosmen.com.vn/template/images/ic-trash.svg" alt="">
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                    <tr style="text-align: center">
                        <td><img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width:300px; text-align: center"></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo number_format($item['price']); ?> <div class="table-prd-price"><sup>đ</sup></div></td>
                        <td>
                            <form action="./handel/cart_action.php" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $product_id; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="0" style="width: 70px;">
                                <button type="submit" name="update_cart">Cập nhật</button>
                            </form>
                        </td>
                        <td><?php echo number_format($item['price'] * $item['quantity']); ?>
                        <div class="table-prd-price"><sup>đ</sup></div>
                        </td>
                        <td>
                        <a href="./handel/cart_action.php?remove_from_cart=true&id=<?php echo $product_id; ?>" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                            <div class="text-center" style="width: 200px;">
                                <img src="https://kosmen.com.vn/template/images/ic-trash.svg" alt="">
                            </div>
                        </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot >
                <tr >
                    <td colspan="4" style="text-align: right;"><strong>Tổng tiền:</strong></td>
                    <td colspan="2" ><strong><?php echo number_format($total_price); ?> <div class="table-prd-price"><sup>đ</sup></div></strong></td>
                </tr>
            </tfoot>
        </table>
        <p>
            <a href="index.php" class="buy-btn">Tiếp tục mua sắm</a>
            <a href="./handel/cart_action.php?action=true" class="buy-btn" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?');">Xóa toàn bộ giỏ hàng</a>
            <a href="checkout.php" class="buy-btn">Thanh toán</a> </p>
    <?php else: ?>

        <p>Giỏ hàng của bạn đang trống <a href="index.php" class="buy-btn">Hãy bắt đầu mua sắm!</a></p>
    <?php endif; ?>

</body>
</html>