<?php
session_start(); // Bắt đầu session để có thể hiển thị thông báo
require_once './db/connect.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký Tài Khoản</title>
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
        <h2>Đăng Ký</h2>

        <?php
        // Hiển thị thông báo lỗi nếu có
        if (isset($_SESSION['error_message'])) {
            echo '<div class="message error">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
            unset($_SESSION['error_message']); // Xóa thông báo sau khi hiển thị
        }

        // Hiển thị thông báo thành công nếu có
        if (isset($_SESSION['success_message'])) {
            echo '<div class="message success">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
            unset($_SESSION['success_message']); // Xóa thông báo sau khi hiển thị
        }
        ?>

        <form action="register.php" method="post">
            <div>
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <label for="confirm_password">Xác nhận mật khẩu:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <input type="submit" value="Đăng Ký">
        </form>
        <p style="text-align: center; margin-top: 15px;">Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
    </div>
</body>
</html>

<?php
// Lấy dữ liệu từ form
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // ----- VALIDATION ĐƠN GIẢN -----
    $errors = [];

    if (empty($username)) {
        $errors[] = "Tên đăng nhập không được để trống.";
    }
    // Trong thực tế, bạn nên kiểm tra username có ký tự đặc biệt không, độ dài,...
    // và quan trọng nhất là KIỂM TRA USERNAME ĐÃ TỒN TẠI TRONG DATABASE CHƯA.

    if (empty($email)) {
        $errors[] = "Email không được để trống.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Định dạng email không hợp lệ.";
    }
    // Tương tự, KIỂM TRA EMAIL ĐÃ TỒN TẠI TRONG DATABASE CHƯA.

    if (empty($password)) {
        $errors[] = "Mật khẩu không được để trống.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Mật khẩu phải có ít nhất 6 ký tự.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Mật khẩu xác nhận không khớp.";
    }

    
// ----- XỬ LÝ -----
    if (!empty($errors)) {
        // Nếu có lỗi, lưu thông báo lỗi vào session và quay lại form đăng ký
        $_SESSION['error_message'] = implode("<br>", $errors);
    } else {
        // **QUAN TRỌNG: Mã hóa mật khẩu trước khi lưu trữ!**
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $ins =  insert('users', ['user_name'=>$username, 'email'=>$email, 'password'=> $hashed_password]);
        if ($ins) {
            $_SESSION['success_message'] = "Đăng ký tài khoản thành công! Bạn có thể đăng nhập ngay bây giờ.";
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username; // Lưu tên người dùng vào session
            header("Location: register.php"); // Hoặc header("Location: register.php");
            exit();
        } else {
            // Lỗi khi lưu vào DB
            $_SESSION['error_message'] = "Có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại.";
            header("Location: register.php");
            exit();
        }
    }

?>