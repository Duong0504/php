<?php
session_start();
require_once './db/connect.php';
?>

<h2>Thêm sinh viên</h2>
<form method="post">
    Mã sinh viên: <input name="MaSV" ><br>
    Họ tên: <input name="HoTen" ><br>
    Email: <input name="Email" ><br>
    Điểm: <input name="Diem" type="number" ><br>
    Ngày sinh: <input name="NgaySinh" type="date" ><br>
    <button type="submit" name="add_student">Lưu</button>
</form>
<?php
if (isset($_POST['add_student'])) {
    if (!empty($_POST)) {
        $dataIns = [
        "MaSV"=> $_POST['MaSV'],
        "HoTen" => $_POST['HoTen'],
        "Email" => $_POST['Email'],
        "NgaySinh" => $_POST['NgaySinh'],
        "Diem" => $_POST['Diem']
        ];

        $ins =  insert('sinh_vien', $dataIns);
        if($ins) {
            $_SESSION['mes'] = 'Thêm sinh viên thành công';
            // var_dump("ok");
        }else {
            $_SESSION['mes'] = 'Thêm sinh viên thất bại';
        }
        header('Location: index.php');
    }
}
?>