<?php
include "db.php";

$account = $_POST['account'];
$password = $_POST['password'];

$sql = "SELECT * FROM `a_user` WHERE `a_id`= '$account' ";
$res = mysqli_query($link, $sql);
if (mysqli_num_rows($res) > 0) {
    $sql = "SELECT * FROM `a_user` WHERE `a_id`= '$account' and `password`= '$password' ";
    $res = mysqli_query($link, $sql);
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            if ($row["type"] == "a") {
                $_SESSION["type"] = "a";
                $_SESSION["a_id"] = $account;
                $_SESSION["name"] = $row["name"];
                $_SESSION['loggedin'] = true;
                header("location:top_admin.php");
            } else {
                $_SESSION["type"] = "u";
                $_SESSION["a_id"] = $account;
                $_SESSION["name"] = $row["name"];
                $_SESSION['loggedin'] = true;
                header("location:a_admin.php");
            }
        }
    } else {
        echo "密碼";
        header("location:a_index.php");
    }
} else {
    echo "帳號";
    header("location:a_index.php");
}
