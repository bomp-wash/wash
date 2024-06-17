<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['a_id'])) {
    $a_id = $_GET['a_id'];
    $sql = "SELECT * FROM a_user WHERE a_id='$a_id'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a_id = $_POST['a_id'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $into_day = $_POST['into_day'];
    $state = $_POST['state'];

    // 获取当前日期和时间
    $current_datetime = date('Y-m-d H:i:s');

    // 如果状态为“已離職”，更新 out_day 为当前日期和时间，否则保持原值
    $out_day = ($state == '0') ? $current_datetime : 'NULL';

    // 更新數據到資料庫
    $sql = "UPDATE a_user SET password='$password', name='$name', type='$type', into_day='$into_day', state='$state', out_day=IF('$state' = '0', '$current_datetime', out_day) WHERE a_id='$a_id'";

    if (mysqli_query($link, $sql)) {
        echo "<script>
            alert('已更新員工資訊');
            window.location.href = 'top_admin.php';
          </script>";
    } else {
        echo "錯誤: " . $sql . "<br>" . mysqli_error($link);
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編輯員工資訊</title>
</head>

<body>
    <h2>編輯員工資訊</h2>
    <form action="edit_auser.php" method="post">
        <input type="hidden" name="a_id" value="<?php echo $row['a_id']; ?>">
        <table>
            <tr>
                <td>帳號</td>
                <td><input type="text" name="a_id" value="<?php echo $row['a_id']; ?>" readonly></td>
            </tr>
            <tr>
                <td>密碼</td>
                <td><input type="password" name="password" value="<?php echo $row['password']; ?>" required></td>
            </tr>
            <tr>
                <td>名稱</td>
                <td><input type="text" name="name" value="<?php echo $row['name']; ?>" required></td>
            </tr>
            <tr>
                <td>類別</td>
                <td>
                    <select name="type" required>
                        <option value="a" <?php if ($row['type'] == 'a') echo 'selected'; ?>>管理者</option>
                        <option value="u" <?php if ($row['type'] == 'u') echo 'selected'; ?>>員工</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>入職日</td>
                <td><input type="date" name="into_day" value="<?php echo $row['into_day']; ?>" required></td>
            </tr>
            <tr>
                <td>狀態</td>
                <td>
                    <select name="state" required>
                        <option value="1" <?php if ($row['state'] == '1') echo 'selected'; ?>>在職</option>
                        <option value="0" <?php if ($row['state'] == '0') echo 'selected'; ?>>已離職</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="更新">
                    <input type="reset" value="重置">
                </td>
            </tr>
        </table>
    </form>
</body>

</html>
