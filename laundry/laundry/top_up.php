<?php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $memberPhone = $_POST['member_phone'];
    $amount = $_POST['amount'];
    $discount = $_POST['discount'];

    // 更新会员余额和折扣
    $updateMemberQuery = "UPDATE members SET money = money + $amount, discount = $discount, period = DATE_ADD(CURDATE(), INTERVAL 6 MONTH) WHERE phone = '$memberPhone'";
    mysqli_query($link, $updateMemberQuery);

    // 获取会员ID
    $memberQuery = "SELECT id FROM members WHERE phone = '$memberPhone'";
    $memberResult = mysqli_query($link, $memberQuery);
    $memberData = mysqli_fetch_assoc($memberResult);
    //$memberId = $memberData['id'];

    // 获取员工ID
    session_start();
    $employeeId = $_SESSION["a_id"];

    // 获取当前时间并转换为UTC+8
    date_default_timezone_set('Asia/Taipei');
    $currentTime = date('Y-m-d H:i:s');
    $memberId=$_SESSION["m_id"];
    // 插入充值记录
    $insertTopUpQuery = "INSERT INTO add_money (m_id, a_id, discount, money, time, now_time) VALUES ($memberId, '$employeeId', $discount, $amount, DATE_ADD(CURDATE(), INTERVAL 6 MONTH), '$currentTime')";
    mysqli_query($link, $insertTopUpQuery);

    // 返回主页面
    $_SESSION["m_id"]="";
    header('Location: a_admin.php');

    exit();
}
?>
