<?php
session_start(); // Bắt đầu session để có thể hiển thị thông báo
require_once './db/connect.php';

if(!empty($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location:index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập Tài Khoản</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 90vh; background-color: #f4f4f4; }
        .container { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"], input[type="email"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover { background-color: #0056b3; }
        .message { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Đăng Nhập</h2>

        <?php
        // Hiển thị thông báo lỗi nếu có
        if (isset($_SESSION['error_message'])) {
            echo '<div class="message error">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
            unset($_SESSION['error_message']); // Xóa thông báo sau khi hiển thị
        }
        ?>

        <form action="login.php" method="post">
            <div>
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <input type="submit" value="Đăng Nhập">
        </form>
        <p style="text-align: center; margin-top: 15px;">Chưa có tài khoản? <a href="register.php">Đăng kí</a></p>
    </div>
</body>
</html>

<?php

$errors = [];

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if(empty($username)) {
    $errors[] = 'Tên người dùng không được để trống.';
}

if(empty($password)) {
    $errors[] = 'Tên người dùng không được để trống.';
}

if(!empty($errors)) {
    $_SESSION['error_message'] = implode("<br>", $errors);
}else {
    $user = firstRaw("SELECT `user_name`, `password` FROM `users` WHERE `user_name` = '$username'");
    if ($user === false) {
        $_SESSION['error_message'] = 'Tài khoản không tồn tại';
        header('Location:login.php');
        exit;
    }else {
        $check = password_verify($password, $user['password']);
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['user_name'];
        $_SESSION['user_id'] = $user['id'];

        header('Location: index.php');
        exit();
    }
}



?>