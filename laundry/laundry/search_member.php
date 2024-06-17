<?php
include("db.php");

$phone = $_GET['phone'];

$sql = "SELECT * FROM members WHERE phone LIKE '%$phone%'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>會員資訊</h2>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>會員姓名: " . $row['real_name'] . "</p>";
        echo "<p>會員電話: " . $row['phone'] . "</p>";
        echo "<p>儲值金額: $" . $row['money'] . "</p>";
        echo "<p>折扣: " . $row['discount'] . "</p>";
        echo "<p>到期日: " . $row['period'] . "</p>";
        echo "<hr>"; // 分隔不同會員信息
    }
} else {
    echo "<p>查無此會員</p>";
}
?>
