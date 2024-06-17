<?php
include "db.php";

$account = $_POST['account'];
$password = $_POST['password'];

$sql = "SELECT * FROM `members` WHERE `phone`= '$account' ";
$res = mysqli_query($link, $sql);
if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $_SESSION["phone"] = $account;
            $_SESSION["name"] = $row["line_name"];
            header("location:u_admin.php");
        }

} else {
    echo "帳號";
    header("location:u_index.php");
}
