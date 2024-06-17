<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['a_id'])) {
    $a_id = $_GET['a_id'];

    // 刪除數據從資料庫
    $sql = "DELETE FROM a_user WHERE a_id='$a_id'";

    if (mysqli_query($link, $sql)) {
        echo "<script>
            alert('已刪除員工資訊');
            window.location.href = 'top_admin.php';
          </script>";
    } else {
        echo "錯誤: " . $sql . "<br>" . mysqli_error($link);
    }

    mysqli_close($link);
}
?>
