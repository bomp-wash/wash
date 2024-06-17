<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $c_id = $_POST['c_id'];
    $c_name = $_POST['c_name'];
    $dry = $_POST['dry'];
    $water = $_POST['water'];
    $iro = $_POST['iro'];
    $sell = $_POST['sell'];

    $sql = "INSERT INTO commodity (c_id, c_name, dry,water, iro) 
            VALUES ('$c_id', '$c_name', '$dry', '$water', '$iro')";

    if (mysqli_query($link, $sql)) {
        echo "<script>
            alert('已新增商品');
            window.location.href = 'top_admin.php';
          </script>";
    } else {
        echo "错误: " . $sql . "<br>" . mysqli_error($link);
    }

    mysqli_close($link);
}
?>
