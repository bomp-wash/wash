<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a_id = $_POST['a_id'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $into_day = $_POST['into_day'];
   
    // 插入數據到資料庫
    $sql = "INSERT INTO a_user (`a_id`, `password`, `name`, `into_day`) 
            VALUES ('$a_id', '$password', '$name', '$into_day')";

    if (mysqli_query($link, $sql)) {
        echo "<script>
            alert('已新增員工資訊');
            window.location.href = 'top_admin.php';
          </script>";
    } else {
        echo "錯誤: " . $sql . "<br>" . mysqli_error($link);
    }

    mysqli_close($link);
}
?>
