<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>使用者-後台管理</title>
    <?php
    include("db.php");

    // 假設用戶已經登入，從 session 中獲取用戶電話號碼
    // if (!isset($_SESSION["phone"])) {
    //     header("Location: login.php"); // 如果未登入，重定向到登入頁面
    //     exit();
    // }

    $phone = $_SESSION["phone"];

    // 從 members 資料庫中抓取對應用戶的資料
    $query = "SELECT * FROM members WHERE phone = '$phone'";
    $result = mysqli_query($link, $query);
    $user = mysqli_fetch_assoc($result);

    // 使用者資料
    $line_name = $user['line_name'];
    $real_name = $user['real_name'];
    $money = $user['money'];
    $join_day = $user['join_day'];
    $birthday = $user['birthday'];
    $email = $user['email'];
    $address = $user['address'];
    $discount = $user['discount'];
    $period = $user['period'];
    ?>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #fae5d3;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .navbar {
            background-color: #003f87;
            overflow: hidden;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #5a7fdd;
            color: black;
        }

        .navbar .profile {
            float: right;
        }

        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            text-align: center;
            padding-top: 70px;
            /* Add padding to avoid content being hidden behind the navbar */
        }

        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .logo {
            width: 100px;
            height: 100px;
            background-color: #2c3e50;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .line-login {
            background-color: #00c300;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .line-login:hover {
            background-color: #00a300;
        }

        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 10px 0;
            font-size: 18px;
        }

        .admin-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            text-align: center;
            padding: 20px;
        }

        .balance {
            font-size: 48px;
            color: #000;
        }

        .note {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        .logout-button {
            background-color: #ff4c4c;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .logout-button:hover {
            background-color: #ff1c1c;
        }

        .tab-content {
            display: none;
            margin-top: 20px;
            /* Add margin to move the tab content up */
        }

        .tab-content.active {
            display: block;
        }

        .tab-menu {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .tab-menu div {
            margin: 0 10px;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 10px 10px 0 0;
            background-color: #fff;
            color: #003f87;
            font-weight: bold;
        }

        .tab-menu div.active {
            background-color: #003f87;
            color: #fff;
        }

        table {
            width: 80%;
            /* Adjust width for better alignment */
            border-collapse: collapse;
            margin: 20px auto;
            /* Center align the table */
        }

        table,
        th,
        td {
            border: 1px solid #003f87;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #003f87;
            color: white;
        }

        .row-left {
            background-color: #d3d3d3;
        }

        .form-container {
            width: 60%;
            /* Adjust width to make form narrower */
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group button {
            padding: 10px 20px;
            background-color: #00c300;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .form-group button:hover {
            background-color: #00a300;
        }
    </style>
    <script>
        function a1() {
            document.getElementById('a1').style.display = "block";
            document.getElementById('a2').style.display = "none";
            document.getElementById('a3').style.display = "none";
            document.getElementById('a4').style.display = "none";
            document.getElementById('mo').style.display = "none";
        }

        function a2() {
            document.getElementById('a1').style.display = "none";
            document.getElementById('a2').style.display = "block";
            document.getElementById('a3').style.display = "none";
            document.getElementById('a4').style.display = "none";
            document.getElementById('mo').style.display = "none";
        }

        function a3() {
            document.getElementById('a1').style.display = "none";
            document.getElementById('a2').style.display = "none";
            document.getElementById('a3').style.display = "block";
            document.getElementById('a4').style.display = "none";
            document.getElementById('mo').style.display = "none";
        }

        function a4() {
            document.getElementById('a1').style.display = "none";
            document.getElementById('a2').style.display = "none";
            document.getElementById('a3').style.display = "none";
            document.getElementById('a4').style.display = "block";
            document.getElementById('mo').style.display = "none";
        }

        function mo() {
            document.getElementById('a1').style.display = "none";
            document.getElementById('a2').style.display = "none";
            document.getElementById('a3').style.display = "none";
            document.getElementById('a4').style.display = "none";
            document.getElementById('mo').style.display = "block";
        }


        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleString();
            document.getElementById('current-time').innerText = '現在時間：' + timeString;
        }

        setInterval(updateTime, 1000);
        updateTime(); // initial call to set the time immediately when the page loads

        function logout() {
            // 執行登出邏輯，例如清除 session 並重定向到登入頁面
            window.location.href = 'u_logout.php';
        }

        function showTab(tabId) {
            var tabs = document.getElementsByClassName('tab-content');
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].style.display = 'none';
            }
            document.getElementById(tabId).style.display = 'block';
        }
    </script>
</head>

<body>
    <div class="navbar">
        <a onclick="a3()"><img src="" alt="LOGO"></a>
        <div>
            <a onclick="mo()">我要儲值</a>
            <a onclick="a1()">儲值記錄</a>
            <a onclick="a2()">消費記錄</a>
            <a onclick="a4()">資料修改</a>
        </div>
        <a class="profile">歡迎 <?= $_SESSION["name"]; ?></a>
    </div>

    <div id="a3" style="display: block;">
        <div class="container">
            <div class="header">
                <img src="" alt="頭貼"><br>
                您好, <?php echo $real_name; ?>
            </div>
            <div class="balance">
                $<?php echo number_format($money, 0); ?>
            </div>
            <p>剩餘儲值金</p><br>
            到期日:<?php echo $period; ?>&emsp;會員等級:
            <?php

            if ($discount == "1") {
                echo "無";
            }elseif($discount == "2"){
                echo "可享9折優惠";
            }else{
                echo "可享8折優惠";
            }

            ?>
            <div class="note">
                *新用戶記得先去填寫個人資料才能正式使用
            </div>
            <button class="logout-button" onclick="logout()">登出</button>
        </div>
    </div>


    <div id="a1" style="display: none;">
        <div id="top-up-records" class="tab-content active"><br>
            <h2 align="center">儲值記錄</h2>
            <table>
                <thead>
                    <tr>
                        <th>會員編號</th>
                        <th>員工編號</th>
                        <th>折扣</th>
                        <th>儲值金額</th>
                        <th>到期日</th>
                        <th>儲值時間</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM add_money WHERE m_id = '$phone'";
                    $result = mysqli_query($link, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                            <td>{$row['m_id']}</td>
                            <td>{$row['a_id']}</td>
                            <td>{$row['discount']}</td>
                            <td>{$row['money']}</td>
                            <td>{$row['time']}</td>
                            <td>{$row['now_time']}</td>
                        </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>沒有資料</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="a2" style="display: none;">
        <div class="tab-content active"><br>
            <h2 align="center">消費記錄</h2>
            <table style="width: 90%;">
                <thead>
                    <tr>
                        <th>會員編號</th>
                        <th>員工編號</th>
                        <th>商品名稱</th>
                        <th>總價</th>
                        <th>訂單時間</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM order_details WHERE m_id = '$phone'";
                    $result = mysqli_query($link, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                <td>{$row['m_id']}</td>
                                <td>{$row['a_id']}</td>
                                <td>{$row['c_name']}</td>
                                <td>$ {$row['all_money']}</td>
                                <td>{$row['add_time']}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>沒有資料</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="a4" style="display: none;">
        <div class="tab-content active form-container"><br>
            <h2 align="center">資料修改</h2>
            <form action="update_member.php" method="post">
                <div class="form-group">
                    <label for="phone">電話號碼:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="line_name">Line 名稱:</label>
                    <input type="text" id="line_name" name="line_name" value="<?php echo $line_name; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="real_name">真實名稱:</label>
                    <input type="text" id="real_name" name="real_name" value="<?php echo $real_name; ?>">
                </div>
                <div class="form-group">
                    <label for="email">電子郵件:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                </div>
                <div class="form-group">
                    <label for="address">地址:</label>
                    <input type="text" id="address" name="address" value="<?php echo $address; ?>">
                </div>
                <div class="form-group">
                    <label for="birthday">生日:</label>
                    <input type="date" id="birthday" name="birthday" value="<?php echo $birthday; ?>">
                </div>
                <div class="form-group">
                    <button type="submit">更新資料</button>
                </div>
            </form>
        </div>
    </div>
    <div class="time" id="current-time">
        現在時間：
    </div>
    <div class="footer">
        我是footer
    </div>
</body>

</html>