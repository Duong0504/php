<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    $so1 = $so2 = "";
    $result = "";
    $err = "";
    $operator = array();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $so1 = $_POST["so1"];
        $so2 = $_POST["so2"];
        $operator = $_POST["option"];

        if (!is_numeric($so1) || !is_numeric($so2)) {
            $err = 'vui long nhap dung 2 so';
        } else if ($operator == "div" && $so2 == 0) {
            $err = 'khong chia duoc cho 0';
        } else {
            switch ($operator) {
                case "add":
                    $result = $so1 + $so2;
                    break;
                case "sub":
                    $result = $so1 - $so2;
                    break;
                case "mul":
                    $result = $so1 * $so2;
                    break;
                case "div":
                    $result = $so1 / $so2;
                    break;
            }
        }
    }
    ?>

    <h1>Máy tính 2 số</h1>
    <form method="post" action="">
        <label>Số thứ nhất: <input type="text" name="so1" required oninput="this.value = this.value.replace(/[^0-9]/, '')"> <br>
            <label>Số thứ hai: <input type="text" name="so2" required oninput="this.value = this.value.replace(/[^0-9]/, '')"><br>
                <label>Phép toán:
                    <select name="option">
                        <option value="add">+</option>
                        <option value="sub">-</option>
                        <option value="mul">*</option>
                        <option value="div">/</option>
                    </select>
                </label>
                <br>
                <button type="submit">click me</button>
    </form>

    <?php
    if (!empty($err)) {
        echo "<p style='color:red;'>$err</p>";
    } elseif ($result !== "") {
        echo "<p>Kết quả: $result</p>";
    }
    ?>
</body>

</html>