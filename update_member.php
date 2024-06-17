<?php
include("db.php");

// 獲取用戶電話號碼
session_start();
$phone = $_SESSION["phone"];

// 獲取表單數據
$real_name = $_POST['real_name'];
$email = $_POST['email'];
$address = $_POST['address'];
$birthday = $_POST['birthday'];

// 更新資料庫中的數據
$query = "UPDATE members SET real_name='$real_name', email='$email', address='$address', birthday='$birthday' WHERE phone='$phone'";
if (mysqli_query($link, $query)) {
    echo "資料更新成功";
} else {
    echo "資料更新失敗: " . mysqli_error($link);
}

// 重定向回到管理頁面
header("Location: u_admin.php");
exit();
?>
