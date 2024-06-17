<?php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $memberId = $_POST['member_id'];
    $employeeId = $_POST['employee_id'];
    $totalAmount = $_POST['total_amount'];
    $cart = json_decode($_POST['cart'], true);

    // 更新会员余额
    $updateMemberQuery = "UPDATE members SET money = money - $totalAmount WHERE phone = '$memberId'";
    mysqli_query($link, $updateMemberQuery);

    // 获取当前时间并转换为UTC+8
    date_default_timezone_set('Asia/Taipei');
    $currentTime = date('Y-m-d H:i:s');

    // 插入订单记录到orders表
    $orderDetails = [];
    foreach ($cart as $item) {
        $orderDetails[] = "{$item['name']}/{$item['category']}/{$item['quantity']}";
    }
    $orderDetailsStr = implode('、', $orderDetails);
    $insertOrderQuery = "INSERT INTO orders (m_id, a_id, details, total_amount, order_time) VALUES ('$memberId', '$employeeId', '$orderDetailsStr', $totalAmount, '$currentTime')";
    mysqli_query($link, $insertOrderQuery);

    // 插入每个商品到order_details表
    $consolidatedDetails = [];
    foreach ($cart as $item) {
        $consolidatedDetails[] = "{$item['name']}/{$item['category']}/{$item['quantity']}";
    }
    $consolidatedDetailsStr = implode('、', $consolidatedDetails);
    $insertOrderDetailsQuery = "INSERT INTO order_details (m_id, a_id, c_name, all_money, add_time) VALUES ('$memberId', '$employeeId', '$consolidatedDetailsStr', $totalAmount, '$currentTime')";
    mysqli_query($link, $insertOrderDetailsQuery);

    // 返回主页面
    header('Location: a_admin.php');
    exit();
}
?>
