<?php
include("db.php");

$member_id = $_GET['member_id'];
$employee_id = $_GET['employee_id'];
$sort_order = $_GET['sort_order'] ?? 'ASC';

$sql = "SELECT * FROM add_money WHERE 1=1";
if (!empty($member_id)) {
    $sql .= " AND m_id = '$member_id'";
}
if (!empty($employee_id)) {
    $sql .= " AND a_id = '$employee_id'";
}
$sql .= " ORDER BY now_time $sort_order";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $discount_text = '無';
        if ($row['discount'] == 2) {
            $discount_text = '9折';
        } elseif ($row['discount'] == 3) {
            $discount_text = '8折';
        }
        echo "<tr>
            <td>{$row['m_id']}</td>
            <td>{$row['a_id']}</td>
            <td>{$discount_text}</td>
            <td>{$row['money']}</td>
            <td>{$row['time']}</td>
            <td>{$row['now_time']}</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='6'>沒有資料</td></tr>";
}
?>
