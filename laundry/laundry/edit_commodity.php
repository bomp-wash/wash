<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['c_id'])) {
    $c_id = $_GET['c_id'];
    $sql = "SELECT * FROM commodity WHERE c_id='$c_id'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $c_id = $_POST['c_id'];
    $c_name = $_POST['c_name'];
    $o_dry = $_POST['o_dry'];
    $m_dry = $_POST['m_dry'];
    $o_water = $_POST['o_water'];
    $m_water = $_POST['m_water'];
    $o_iro = $_POST['o_iro'];
    $m_iro = $_POST['m_iro'];
    $sell = $_POST['sell'];

    // 更新数据到数据库
    $sql = "UPDATE commodity SET c_name='$c_name', o_dry='$o_dry', m_dry='$m_dry', o_water='$o_water', m_water='$m_water', o_iro='$o_iro', m_iro='$m_iro', sell='$sell' WHERE c_id='$c_id'";

    if (mysqli_query($link, $sql)) {
        echo "<script>
            alert('已更新商品資訊');
            window.location.href = 'index.php';
          </script>";
    } else {
        echo "錯誤: " . $sql . "<br>" . mysqli_error($link);
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編輯商品資訊</title>
    <link rel="stylesheet" href="css/styles_admin.css">
</head>

<body>
    <div align="center" style="width: 90%;">
        <h2>編輯商品資訊</h2>
        <form action="edit_commodity.php" method="post">
            <input type="hidden" name="c_id" value="<?php echo $row['c_id']; ?>">
            <table align="center">
                <tr>
                    <td>商品編號</td>
                    <td><input type="text" name="c_id" value="<?php echo $row['c_id']; ?>" readonly></td>
                </tr>
                <tr>
                    <td>商品名稱</td>
                    <td><input type="text" name="c_name" value="<?php echo $row['c_name']; ?>" required></td>
                </tr>
                <tr>
                    <td>乾洗原價</td>
                    <td><input type="number" name="o_dry" value="<?php echo $row['o_dry']; ?>" required></td>
                </tr>
                <tr>
                    <td>乾洗會員價</td>
                    <td><input type="number" name="m_dry" value="<?php echo $row['m_dry']; ?>" required></td>
                </tr>
                <tr>
                    <td>水洗原價</td>
                    <td><input type="number" name="o_water" value="<?php echo $row['o_water']; ?>" required></td>
                </tr>
                <tr>
                    <td>水洗會員價</td>
                    <td><input type="number" name="m_water" value="<?php echo $row['m_water']; ?>" required></td>
                </tr>
                <tr>
                    <td>熨燙原價</td>
                    <td><input type="number" name="o_iro" value="<?php echo $row['o_iro']; ?>" required></td>
                </tr>
                <tr>
                    <td>熨燙會員價</td>
                    <td><input type="number" name="m_iro" value="<?php echo $row['m_iro']; ?>" required></td>
                </tr>
                <tr>
                    <td>出售量</td>
                    <td><input type="number" name="sell" value="<?php echo $row['sell']; ?>" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="更新">
                        <input type="reset" value="重置">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>