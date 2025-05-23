<?php
session_start();
require_once './db/connect.php';
$masv =  $_GET['ma_sv'];
$student =  firstRaw("SELECT * FROM `sinh_vien` WHERE `MaSV`= $masv");
var_dump($student);
?>

<h2>Sửa sinh viên</h2>
<form method="post">
    Họ tên: <input name="HoTen" value="<?php echo $student['HoTen'] ?? $_POST['HoTen'] ?>" ><br>
    Email: <input name="Email" value="<?php echo $student['Email'] ?? $_POST['Email'] ?>" ><br>
    Điểm: <input name="Diem" type="number" value="<?php echo $student['Diem'] ?? $_POST['Diem'] ?>" ><br>
    Ngày sinh: <input name="NgaySinh" type="date" value="<?php echo $student['NgaySinh'] ?? $_POST['NgaySinh'] ?>"  ><br>
    <button type="submit" name="edit_student">Cập nhật</button>
</form>
<?php
if (isset($_POST['edit_student'])) {
    if (!empty($_POST)) {
        $dataUp = [
        "HoTen" => $_POST['HoTen'],
        "Email" => $_POST['Email'],
        "NgaySinh" => $_POST['NgaySinh'],
        "Diem" => $_POST['Diem']
        ];

        $update =  update('sinh_vien', $dataUp, "MaSV = $masv");
        if($update) {
            $_SESSION['mes'] = 'Cập nhật sinh viên thành công';

        }else {
            $_SESSION['mes'] = 'Cập nhật sinh viên thất bại';
        }
        header('Location: index.php');
    }
}
?>