    <?php
        session_start();
        include_once './products.php';
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            h1{
                font-size: 20px !important;
                color: red !important;
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
            .product-item {
                width: 40%;
            }

            div {
                display: block;
                unicode-bidi: isolate;
            }
        </style>
        <title>Shopping</title>

    </head>
    <body>
        <h1 class="tittle">Sản phẩm của chúng tôi</h1>
        <?php
            if(isset($_SESSION['massage']) && !empty($_SESSION['massage'])){
                $massage = $_SESSION['massage'];
                echo "<p> $massage </p>";
            }
            unset($_SESSION['massage'])
        ?>
        <div class="products-list">
            <?php foreach ($products as $key => $product):
                // var_dump($product);
            ?>
                <div class="product-item">
                    <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="width:150px;">
                    <h2><?php echo $product['name']; ?></h2>
                    <p>Giá: <?php echo number_format($product['price']); ?> <sup>đ</sup></p>
                    <form action="./handel/cart_action.php" method="post">
                        <input type="hidden" name="id" style="text-align: center" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="name" style="text-align: center" value="<?php echo $product['name']; ?>">
                        <input type="hidden" name="price" style="text-align: center" value="<?php echo $product['price']; ?>">
                        <input type="hidden" name="image" style="text-align: center" value="<?php echo $product['image']; ?>">
                        Số lượng: <input type="number" name="quantity" value="1" min="1" style="width: 50px; text-align: center;">
                        <button type="submit" name="add_to_cart">Thêm vào giỏ</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        <p><a href="cart.php" class="buy-btn">Xem giỏ hàng</a></p>
    </body>
    </html>