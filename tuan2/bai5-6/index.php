<?php
session_start();
include 'db/connect.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // Nếu chưa, chuyển về trang đăng nhập
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    
<h2>Danh sách sinh viên</h2>
<a href="add.php">Thêm sinh viên</a>
<a href="register.php">Đăng kí tài khoản</a>
<a href="logout.php" style="float: right;">Đằng xuất</a>

<?php
    $students = getRow("SELECT * FROM `sinh_vien`");
?>

<?php if (isset($_SESSION['mes'])): ?>
        <p style="color: red; background: black;"><?php echo $_SESSION['mes']; unset($_SESSION['mes']); ?></p>
<?php endif; ?>
<table class="table table-bordered" border="1" cellpadding="10">
    <tr>
        <th>STT</th><th>Họ tên</th><th>Email</th><th>Điểm</th><th>Ngày sinh</th><th>Hành động</th>
    </tr>
    <?php foreach ($students as $key => $student): 
        ?>
    <tr>
        <td><?php echo $student['MaSV'] ?></td>
        <td><?php echo $student['HoTen'] ?></td>
        <td><?php echo $student['Email'] ?></td>
        <td><?php echo $student['Diem'] ?></td>
        <td><?php echo $student['NgaySinh'] ?></td>
        <td>
            <a href="edit.php?ma_sv=<?php echo $student['MaSV'] ?>">Sửa</a> |
            <a href="delete.php?ma_sv=<?php echo $student['MaSV'] ?>" onclick="return confirm('Xóa?')">Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
