<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lịch tháng</title>
</head>
<body>

<h2>Lịch</h2>
<form method="get">
    <table>
        <tr>
            <td>
                Tháng:
                <input type="number" name="month" min="1" max="12" required
                       style="width: 100px; height: 20px;"
                       value="<?php echo $_GET['month'] ?? date('n'); ?>">
            </td>
        </tr>
        <tr>
            <td>
                Năm:
                <input type="number" name="year" min="1900" max="2100" required
                       style="width: 100px; height: 20px;"
                       value="<?php echo $_GET['year'] ?? date('Y'); ?>">
            </td>
        </tr>
        <tr>
            <td>
                <button type="submit">Xem lịch</button>
            </td>
        </tr>
    </table>
</form>

<?php
if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = (int)$_GET['month'];
    $year = (int)$_GET['year'];

    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $daysInMonth = date("t", $firstDayOfMonth);
    $startDay = date('w', $firstDayOfMonth);

    $startDay = ($startDay == 0) ? 6 : $startDay - 1;

    echo "<h3>Lịch tháng $month năm $year</h3>";
    echo "<table>";
    echo "<tr>
        
        <th>T2</th>
        <th>T3</th>
        <th>T4</th>
        <th>T5</th>
        <th>T6</th>
        <th>T7</th>
            <th>CN</th>
          </tr>";

    $currentDay = 1;
    echo "<tr>";

    for ($i = 0; $i < $startDay; $i++) {
        echo "<td></td>";
    }

    for ($i = $startDay; $i < 7; $i++) {
        echo "<td>$currentDay</td>";
        $currentDay++;
    }
    echo "</tr>";

    while ($currentDay <= $daysInMonth) {
        echo "<tr>";
        for ($i = 0; $i < 7; $i++) {
            if ($currentDay <= $daysInMonth) {
                echo "<td>$currentDay</td>";
                $currentDay++;
            } else {
                echo "<td></td>";
            }
        }
        echo "</tr>";
    }

    echo "</table>";
}
?>

</body>
</html>
