<?php
session_start();

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
    <title>Giỏ hàng của bạn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Giỏ hàng</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <p style="color: green;"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <table>
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                    <tr>
                        <td><img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width:50px;"></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo number_format($item['price']); ?> VND</td>
                        <td>
                            <form action="./handel/cart_action.php" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $product_id; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="0" style="width: 50px;">
                                <button type="submit" name="update_cart">Cập nhật</button>
                            </form>
                        </td>
                        <td><?php echo number_format($item['price'] * $item['quantity']); ?> VND</td>
                        <td>
                            <a href="./handel/cart_action.php?remove_from_cart=true&id=<?php echo $product_id; ?>" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right;"><strong>Tổng cộng:</strong></td>
                    <td colspan="2"><strong><?php echo number_format($total_price); ?> VND</strong></td>
                </tr>
            </tfoot>
        </table>
        <p>
            <a href="index.php">Tiếp tục mua sắm</a> |
            <a href="./handel/cart_action.php?action=true" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?');">Xóa toàn bộ giỏ hàng</a> |
            <a href="checkout.php">Thanh toán</a> </p>
    <?php else: ?>
        <p>Giỏ hàng của bạn đang trống. <a href="index.php">Hãy bắt đầu mua sắm!</a></p>
    <?php endif; ?>

</body>
</html>