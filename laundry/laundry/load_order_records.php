<?php
include("db.php");

$memberId = isset($_GET['member_id']) ? $_GET['member_id'] : '';
$employeeId = isset($_GET['employee_id']) ? $_GET['employee_id'] : '';

$orderQuery = "SELECT * FROM order_details WHERE m_id LIKE '%$memberId%' AND a_id LIKE '%$employeeId%' ORDER BY add_time DESC";
$orderResult = mysqli_query($link, $orderQuery);

if (mysqli_num_rows($orderResult) > 0) {
    while ($row = mysqli_fetch_assoc($orderResult)) {
        echo "<tr>
                <td>{$row['m_id']}</td>
                <td>{$row['a_id']}</td>
                <td>{$row['c_name']}</td>
                <td>{$row['all_money']}</td>
                <td>{$row['add_time']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>沒有消費記錄</td></tr>";
}
?>
