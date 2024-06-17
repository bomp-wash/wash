<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    include("db.php"); 
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>洗衣店-管理者管理</title>
    <link rel="stylesheet" href="css/styles_admin.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #fae5d3;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
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
            padding-top: 100px; /* Add padding to avoid content being hidden behind the navbar */
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
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #003f87;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #003f87;
            color: white;
        }

        .btn {
            padding: 5px 10px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn.edit {
            background-color: #f0ad4e;
            color: white;
        }

        .btn.delete {
            background-color: #d9534f;
            color: white;
        }

        .btn.logout {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            margin: 20px 0;
        }

        .row-left {
            background-color: #d3d3d3;
        }
    </style>
    <script>
        function a1() {
            document.getElementById('a1').style.display = "block";
            document.getElementById('a2').style.display = "none";
            document.getElementById('a3').style.display = "none";
            document.getElementById('a4').style.display = "none";
        }

        function a2() {
            document.getElementById('a1').style.display = "none";
            document.getElementById('a2').style.display = "block";
            document.getElementById('a3').style.display = "none";
            document.getElementById('a4').style.display = "none";
        }

        function a3() {
            document.getElementById('a1').style.display = "none";
            document.getElementById('a2').style.display = "none";
            document.getElementById('a3').style.display = "block";
            document.getElementById('a4').style.display = "none";
        }

        function a4() {
            document.getElementById('a1').style.display = "none";
            document.getElementById('a2').style.display = "none";
            document.getElementById('a3').style.display = "none";
            document.getElementById('a4').style.display = "block";
        }

        function b1() {
            document.getElementById('employee-list').style.display = "block";
            document.getElementById('add-employee').style.display = "none";
        }

        function b2() {
            document.getElementById('employee-list').style.display = "none";
            document.getElementById('add-employee').style.display = "block";
        }

        function c1() {
            document.getElementById('product-list').style.display = "block";
            document.getElementById('add-product').style.display = "none";
        }

        function c2() {
            document.getElementById('product-list').style.display = "none";
            document.getElementById('add-product').style.display = "block";
        }

        function d1() {
            document.getElementById('top-up-records').style.display = "block";
            document.getElementById('order-records').style.display = "none";
        }

        function d2() {
            document.getElementById('top-up-records').style.display = "none";
            document.getElementById('order-records').style.display = "block";
        }

        function generateProductId() {
            var lastProductId = document.getElementById('last-product-id').value;
            var newProductId = 'C' + String(parseInt(lastProductId.substring(1)) + 1).padStart(4, '0');
            document.getElementById('new-product-id').value = newProductId;
        }

        function loadTopUpRecords(sortOrder = 'ASC') {
            var memberId = document.getElementById('topup-member-id').value;
            var employeeId = document.getElementById('topup-employee-id').value;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'load_topup_records.php?member_id=' + memberId + '&employee_id=' + employeeId + '&sort_order=' + sortOrder, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('topup-records-table').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        function loadOrderRecords() {
            var memberId = document.getElementById('order-member-id').value;
            var employeeId = document.getElementById('order-employee-id').value;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'load_order_records.php?member_id=' + memberId + '&employee_id=' + employeeId, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('order-records-table').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        function searchMember() {
            var phone = document.getElementById('search-member-phone').value;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'search_member.php?phone=' + phone, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('member-info').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>
</head>

<body onload="generateProductId()">
    <div class="navbar">
        <a href="#"><img src="" alt="LOGO"></a>
        <div>
            <a href="#" onclick="a1()">員工管理</a>
            <a href="#" onclick="a2()">儲值/消費記錄</a>
            <a href="#" onclick="a3()">商品管理</a>
            <a href="#" onclick="a4()">管理帳戶</a>
        </div>
        <a class="profile">管理者</a>
    </div>

    <div class="container">
        <div id="a1" style="display: block;">
            <div class="tab-menu">
                <div class="active" onclick="b1()">員工列表</div>
                <div onclick="b2()">新增員工</div>
            </div>

            <div id="employee-list" class="tab-content active">
                <table>
                    <thead>
                        <tr>
                            <th>員工編號</th>
                            <th>員工姓名</th>
                            <th>入值日</th>
                            <th>離職日</th>
                            <th>狀態</th>
                            <th>編輯</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // 先按照狀態排序，然後按照 a_id 排序
                        $sql = "SELECT a_id, name, into_day, out_day, state FROM a_user ORDER BY state DESC, a_id";
                        $result = mysqli_query($link, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['a_id'] != 'admin') {
                                    $state = $row['state'] == 1 ? '在職' : '已離職';
                                    $row_class = $row['state'] == 0 ? 'class="row-left"' : '';
                                    echo "<tr $row_class>
                                        <td>{$row['a_id']}</td>
                                        <td>{$row['name']}</td>
                                        <td>{$row['into_day']}</td>
                                        <td>{$row['out_day']}</td>
                                        <td>{$state}</td>
                                        <td>
                                            <a href='edit_auser.php?a_id={$row['a_id']}' class='btn edit'>修改</a>
                                            <a href='delete_auser.php?a_id={$row['a_id']}' class='btn delete' onclick='return confirm(\"確定要刪除這位員工嗎？\");'>刪除</a>
                                        </td>
                                    </tr>";
                                }
                            }
                        } else {
                            echo "<tr><td colspan='6'>沒有資料</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div id="add-employee" class="tab-content">
                <h2>新增員工</h2>
                <form action="add_auser.php" method="post">
                    <table>
                        <tr>
                            <td>員工編號</td>
                            <td><input type="text" name="a_id" required></td>
                        </tr>
                        <tr>
                            <td>密碼</td>
                            <td><input type="password" name="password" required></td>
                        </tr>
                        <tr>
                            <td>名稱</td>
                            <td><input type="text" name="name" required></td>
                        </tr>
                       
                        <tr>
                            <td>入職日</td>
                            <td><input type="date" name="into_day" required></td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <input type="submit" value="新增">
                                <input type="reset" value="重置">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <div id="a2" style="display: none;">
            <div class="tab-menu">
                <div class="active" onclick="d1()">儲值記錄</div>
                <div onclick="d2()">消費記錄</div>
            </div>

            <div id="top-up-records" class="tab-content active">
                <form action="javascript:void(0);" method="get" onsubmit="loadTopUpRecords()">
                    <label for="topup-member-id">會員編號:</label>
                    <input type="text" id="topup-member-id" name="topup_member_id">
                    <label for="topup-employee-id">員工編號:</label>
                    <input type="text" id="topup-employee-id" name="topup_employee_id">
                    <input type="submit" value="查詢">
                </form><br>
                <button onclick="loadTopUpRecords('ASC')">升序</button>
                <button onclick="loadTopUpRecords('DESC')">降序</button>
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
                    <tbody id="topup-records-table">
                        <!-- AJAX response will be inserted here -->
                    </tbody>
                </table>
            </div>

            <div id="order-records" class="tab-content">
                <form action="javascript:void(0);" method="get" onsubmit="loadOrderRecords()">
                    <label for="order-member-id">會員編號:</label>
                    <input type="text" id="order-member-id" name="order_member_id">
                    <label for="order-employee-id">員工編號:</label>
                    <input type="text" id="order-employee-id" name="order_employee_id">
                    <input type="submit" value="查詢">
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>會員編號</th>
                            <th>員工編號</th>
                            <th>商品名稱</th>
                            <th>總價</th>
                            <th>訂單時間</th>
                        </tr>
                    </thead>
                    <tbody id="order-records-table">
                        <!-- AJAX response will be inserted here -->
                    </tbody>
                </table>
            </div>
        </div>

        <div id="a3" style="display: none;">
            <div class="tab-menu">
                <div class="active" onclick="c1()">商品列表</div>
                <div onclick="c2()">新增商品</div>
            </div>

            <div id="product-list" class="tab-content active">
                <table>
                    <thead>
                        <tr>
                            <th>商品編號</th>
                            <th>商品名稱</th>
                            <th>編輯</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $sql = "SELECT c_id, c_name FROM commodity ORDER BY c_id DESC LIMIT 1";
                        $result = mysqli_query($link, $sql);
                        $last_product_id = 'C0000'; //商品自動產生ID
                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $last_product_id = $row['c_id'];
                        }
                        $sql = "SELECT c_id, c_name FROM commodity ORDER BY c_id";
                        $result = mysqli_query($link, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                    <td>{$row['c_id']}</td>
                                    <td>{$row['c_name']}</td>
                                    <td>
                                        <a href='edit_commodity.php?c_id={$row['c_id']}' class='btn edit'>修改</a>
                                        <a href='delete_commodity.php?c_id={$row['c_id']}' class='btn delete' onclick='return confirm(\"確定要刪除這個商品嗎？\");'>刪除</a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>沒有資料</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div id="add-product" class="tab-content">
                <h2>新增商品</h2>
                <form action="add_commodity.php" method="post">
                    <table>
                        <tr>
                            <td>商品編號</td>
                            <td><input type="text" id="new-product-id" name="c_id" readonly></td>
                        </tr>
                        <tr>
                            <td>商品名稱</td>
                            <td><input type="text" name="c_name" required></td>
                        </tr>
                        <tr>
                            <td>乾洗原價</td>
                            <td><input type="number" name="dry" required></td>
                        </tr>
                       
                        <tr>
                            <td>水洗原價</td>
                            <td><input type="number" name="water" required></td>
                        </tr>
                        <tr>
                            <td>熨燙原價</td>
                            <td><input type="number" name="iro" required></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" value="新增">
                                <input type="reset" value="重置">
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" id="last-product-id" value="<?php echo $last_product_id; ?>">
                </form>
            </div>
        </div>

        <div id="a4" style="display: none;">
            <h2>管理帳戶</h2>
            <form action="javascript:void(0);" method="get" onsubmit="searchMember()">
                <label for="search-member-phone">會員電話:</label>
                <input type="text" id="search-member-phone" name="search_member_phone">
                <input type="submit" value="查詢">
            </form>
            <div id="member-info"></div>
        </div>
    </div>
    <button class="btn logout" onclick="window.location.href='logout.php'">登出</button>
    <div class="footer">
        footer 
    </div>
</body>

</html>
