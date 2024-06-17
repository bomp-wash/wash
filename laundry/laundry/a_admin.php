<?php
include("db.php");

$memberPhone = '';
$memberName = '';
$memberBalance = 0;
$memberDiscount = 1;
$memberPeriod = '';
$isMember = false;

 
// 获取当前日期
$currentDate = date('Y-m-d');

// 搜索会员信息
if (isset($_POST['search_member'])) {
    $memberPhone = $_POST['member_phone'];
    $memberQuery = "SELECT * FROM members WHERE phone = '$memberPhone'";
    $memberResult = mysqli_query($link, $memberQuery);

    if (mysqli_num_rows($memberResult) > 0) {
        $memberData = mysqli_fetch_assoc($memberResult);
        $memberName = $memberData['real_name'];
        $memberBalance = $memberData['money'];
        $memberDiscount = $memberData['discount'];
        $memberPeriod = $memberData['period'];
        $isMember = true;
        $_SESSION["m_id"] = $memberPhone;

        // 检查折扣是否需要重置
        if ($memberPeriod < $currentDate) {
            $memberDiscount = 1;
            $updateDiscountQuery = "UPDATE members SET discount = 1 WHERE phone = '$memberPhone'";
            mysqli_query($link, $updateDiscountQuery);
        }
    }
}

// 获取商品信息
$productsPerPage = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $productsPerPage;

$productQuery = "SELECT * FROM commodity LIMIT $productsPerPage OFFSET $offset";
$productResult = mysqli_query($link, $productQuery);
$totalProductsQuery = "SELECT COUNT(*) as total FROM commodity";
$totalProductsResult = mysqli_query($link, $totalProductsQuery);
$totalProducts = mysqli_fetch_assoc($totalProductsResult)['total'];
$totalPages = ceil($totalProducts / $productsPerPage);

// 计算折扣
function calculateDiscountedPrice($price, $discount) {
    if ($discount == 2) {
        return round($price * 0.9);
    } elseif ($discount == 3) {
        return round($price * 0.8);
    } else {
        return round($price);
    }
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>洗衣店-員工管理</title>
    <style>
        body, html {
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .navbar a {
            color: white;
            text-align: center;
            text-decoration: none;
            padding: 14px 20px;
        }

        .navbar a:hover {
            background-color: #5a7fdd;
            color: black;
        }

        .navbar .profile {
            color: white;
        }

        .container {
            flex: 1;
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            justify-content: space-between;
            padding: 20px;
        }

        .left-panel, .right-panel {
            flex: 1;
            margin: 0 10px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .search-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            padding: 10px;
            font-size: 18px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-container button {
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #f05454;
            color: white;
            margin-left: 10px;
        }

        .search-container button:hover {
            background-color: #d9534f;
        }

        .category-select {
            margin-bottom: 20px;
        }

        .category-select select {
            padding: 10px;
            font-size: 18px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .product-card {
            background-color: #577590;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            color: white;
            width: 150px;
            text-align: center;
        }

        .product-card.dry { background-color: #f39c12; }
        .product-card.water { background-color: #2980b9; }
        .product-card.iro { background-color: #8e44ad; }

        .product-card .price {
            font-size: 24px;
            margin: 10px 0;
        }

        .product-card .quantity {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .product-card .quantity input {
            width: 50px;
            text-align: center;
            margin: 0 10px;
        }

        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 10px 0;
            font-size: 18px;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination a {
            margin: 0 5px;
            padding: 10px 15px;
            text-decoration: none;
            color: #003f87;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .pagination a.active {
            background-color: #003f87;
            color: white;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .cart-table th, .cart-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        .cart-table th {
            background-color: #f2f2f2;
        }

        .remove-btn {
            cursor: pointer;
            color: red;
        }

        .vip-button {
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px 0;
        }

        .vip-button.blue {
            background-color: #5a7fdd;
            color: white;
        }

        .vip-button.grey {
            background-color: #7f8c8d;
            color: white;
        }

        .top-up-button {
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #f1c40f;
            color: white;
            margin-top: 10px;
        }

        .logout-button {
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #e74c3c;
            color: white;
            margin-top: 10px;
        }

        .tab-content {
            display: none;
            width: 50%;
            padding: 10px 350px;
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

        /* Custom styles for the top-up records table */
        .topup-table-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .topup-table-container .center-text {
            text-align: center;
            margin-bottom: 10px;
        }

        .topup-table-container table {
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .topup-table-container th,
        .topup-table-container td {
            border: 1px solid #003f87;
            padding: 10px;
            text-align: center;
        }

        .topup-table-container th {
            background-color: #003f87;
            color: #fff;
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

        let cart = [];

        function filterProducts() {
            const category = document.getElementById("category").value;
            const productCards = document.getElementsByClassName("product-card");

            for (let card of productCards) {
                card.style.display = card.classList.contains(category) || category === "all" ? "block" : "none";
            }
        }

        function updateQuantity(input, increment) {
            let value = parseInt(input.value);
            value = isNaN(value) ? 0 : value;
            value += increment;
            if (value < 0) value = 0;
            input.value = value;
        }

        function addToCart(name, category, price, input) {
            const quantity = parseInt(input.value);
            if (quantity > 0) {
                const existingItem = cart.find(item => item.name === name && item.category === category);
                if (existingItem) {
                    existingItem.quantity += quantity;
                    existingItem.totalPrice += quantity * price;
                } else {
                    cart.push({ name, category, price, quantity, totalPrice: quantity * price });
                }
                input.value = 0;
                updateCart();
            }
        }

        function updateCart() {
            const cartTableBody = document.getElementById("cart-table-body");
            cartTableBody.innerHTML = '';
            let totalAmount = 0;

            cart.forEach(item => {
                totalAmount += item.totalPrice;
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.name}</td>
                    <td>${item.category}</td>
                    <td>${item.quantity}</td>
                    <td>$ ${item.price.toFixed(2)}</td>
                    <td>$ ${item.totalPrice.toFixed(2)}</td>
                    <td><button onclick='removeFromCart("${item.name}", "${item.category}")'>刪除</button></td>
                `;
                cartTableBody.appendChild(row);
            });

            document.getElementById("current-amount").textContent = `$ ${totalAmount.toFixed(2)}`;
        }

        function removeFromCart(name, category) {
            cart = cart.filter(item => !(item.name === name && item.category === category));
            updateCart();
        }

        function d1() {
            document.getElementById('top-up-records').style.display = "block";
            document.getElementById('order-records').style.display = "none";
        }

        function d2() {
            document.getElementById('top-up-records').style.display = "none";
            document.getElementById('order-records').style.display = "block";
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

        function checkout() {
            let totalAmount = cart.reduce((sum, item) => sum + item.totalPrice, 0);
            let remainingBalance = <?= $memberBalance ?> - totalAmount;

            if (remainingBalance < 0) {
                alert("儲值金不足，請充值");
                return;
            }

            if (confirm(`總金額: $${totalAmount.toFixed(2)}\n扣除後餘額: $${remainingBalance.toFixed(2)}\n確認結帳嗎?`)) {
                // 发送表单数据到a_checkout.php
                let form = document.createElement('form');
                form.method = 'post';
                form.action = 'a_checkout.php';

                let memberIdInput = document.createElement('input');
                memberIdInput.type = 'hidden';
                memberIdInput.name = 'member_id';
                memberIdInput.value = '<?= $memberPhone ?>';
                form.appendChild(memberIdInput);

                let employeeIdInput = document.createElement('input');
                employeeIdInput.type = 'hidden';
                employeeIdInput.name = 'employee_id';
                employeeIdInput.value = '<?= $_SESSION["a_id"] ?>';
                form.appendChild(employeeIdInput);

                let totalAmountInput = document.createElement('input');
                totalAmountInput.type = 'hidden';
                totalAmountInput.name = 'total_amount';
                totalAmountInput.value = totalAmount;
                form.appendChild(totalAmountInput);

                let cartInput = document.createElement('input');
                cartInput.type = 'hidden';
                cartInput.name = 'cart';
                cartInput.value = JSON.stringify(cart);
                form.appendChild(cartInput);

                document.body.appendChild(form);
                form.submit();
            }
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

        function topUp(amount) {
            let memberPhone = '<?= $memberPhone ?>';
            let discount = 1;
            if (amount == 2000) {
                discount = 2;
            } else if (amount == 3000) {
                discount = 3;
            }
            if (confirm(`您確定要儲值 ${amount} 元嗎？`)) {
                // 发送表单数据到 top_up.php
                let form = document.createElement('form');
                form.method = 'post';
                form.action = 'top_up.php';

                let memberPhoneInput = document.createElement('input');
                memberPhoneInput.type = 'hidden';
                memberPhoneInput.name = 'member_phone';
                memberPhoneInput.value = memberPhone;
                form.appendChild(memberPhoneInput);

                let amountInput = document.createElement('input');
                amountInput.type = 'hidden';
                amountInput.name = 'amount';
                amountInput.value = amount;
                form.appendChild(amountInput);

                let discountInput = document.createElement('input');
                discountInput.type = 'hidden';
                discountInput.name = 'discount';
                discountInput.value = discount;
                form.appendChild(discountInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</head>

<body>
    <div class="navbar">
        <a href="#"><img src="" alt="LOGO"></a>
        <div>
            <a onclick="a1()">新增訂單</a>
            <a onclick="a2()">儲值金額</a>
            <a onclick="a3()">儲值/消費紀錄</a>
            <a onclick="a4()">管理帳戶</a>
            <a class="profile">帳號:<?= $_SESSION["a_id"]; ?></a>
        </div>
    </div>
    <div id="a1" style="display: block;">
        <div class="container">
            <div class="left-panel">
                <div class="search-container">
                    <form method="post">
                        <label for="member-phone">會員號碼:</label>
                        <input type="text" id="member-phone" name="member_phone" value="<?= $memberPhone ?>">
                        <button type="submit" name="search_member">搜尋</button>
                    </form>
                </div>
                <div class="category-select">
                    <label for="category">選擇項目:</label>
                    <select id="category" onchange="filterProducts()">
                        <option value="all">所有項目</option>
                        <option value="dry">乾洗</option>
                        <option value="water">水洗</option>
                        <option value="iro">熨燙</option>
                    </select>
                </div>
                <div class="product-container">
                    <?php
                    if (mysqli_num_rows($productResult) > 0) {
                        while ($row = mysqli_fetch_assoc($productResult)) {
                            $priceDry = calculateDiscountedPrice($row['dry'], $memberDiscount);
                            $priceWater = calculateDiscountedPrice($row['water'], $memberDiscount);
                            $priceIro = calculateDiscountedPrice($row['iro'], $memberDiscount);

                            echo "<div class='product-card dry'>
                                    <div>{$row['c_name']} (乾洗)</div>
                                    <div class='price'>$ {$priceDry}</div>
                                    <div class='quantity'>
                                        <button onclick='updateQuantity(this.nextElementSibling, -1)'>-</button>
                                        <input type='number' value='0' readonly>
                                        <button onclick='updateQuantity(this.previousElementSibling, 1)'>+</button>
                                    </div>
                                    <button onclick='addToCart(\"{$row['c_name']}\", \"乾洗\", {$priceDry}, this.previousElementSibling.querySelector(\"input\"))'>新增</button>
                                  </div>";

                            echo "<div class='product-card water'>
                                    <div>{$row['c_name']} (水洗)</div>
                                    <div class='price'>$ {$priceWater}</div>
                                    <div class='quantity'>
                                        <button onclick='updateQuantity(this.nextElementSibling, -1)'>-</button>
                                        <input type='number' value='0' readonly>
                                        <button onclick='updateQuantity(this.previousElementSibling, 1)'>+</button>
                                    </div>
                                    <button onclick='addToCart(\"{$row['c_name']}\", \"水洗\", {$priceWater}, this.previousElementSibling.querySelector(\"input\"))'>新增</button>
                                  </div>";

                            echo "<div class='product-card iro'>
                                    <div>{$row['c_name']} (熨燙)</div>
                                    <div class='price'>$ {$priceIro}</div>
                                    <div class='quantity'>
                                        <button onclick='updateQuantity(this.nextElementSibling, -1)'>-</button>
                                        <input type='number' value='0' readonly>
                                        <button onclick='updateQuantity(this.previousElementSibling, 1)'>+</button>
                                    </div>
                                    <button onclick='addToCart(\"{$row['c_name']}\", \"熨燙\", {$priceIro}, this.previousElementSibling.querySelector(\"input\"))'>新增</button>
                                  </div>";
                        }
                    } else {
                        echo "<p>沒有商品資料</p>";
                    }
                    ?>
                </div>
                <div class="pagination">
                    <?php
                    for ($i = 1; $i <= $totalPages; $i++) {
                        $active = $i == $page ? 'active' : '';
                        echo "<a href='?page=$i' class='$active'>$i</a>";
                    }
                    ?>
                </div>
            </div>
            <div class="right-panel">
                <h2>歡迎會員: <?= $memberName ?></h2> 
                <p>儲值金剩餘: $<?= $memberBalance ?></p>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>名稱</th>
                            <th>項目</th>
                            <th>數量</th>
                            <th>單價</th>
                            <th>總價</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody id="cart-table-body">
                        <!-- 購物車項目將在這裡顯示 -->
                    </tbody>
                </table>
                <p>目前消費金額: <span id="current-amount">$ 0</span></p>
                <button onclick="checkout()">結帳</button>
            </div>
        </div>
        
    </div>
    <div id="a2" style="display: none;">
        <div class="container">
            <div class="right-panel">
                <?php if ($isMember): ?>
                    <h2>歡迎會員: <?= $memberName ?></h2>
                    <p>儲值金剩餘: $<?= $memberBalance ?> &emsp;到期日: <?= $memberPeriod ?></p>
                    <button class="vip-button blue" onclick="topUp(2000)">2000 VIP</button>
                    <button class="vip-button grey" onclick="topUp(3000)">3000 VIP</button>
                    <h3>儲值金額</h3>
                    <input type="text" id="top-up-amount" name="top-up-amount">
                    <button class="top-up-button" onclick="topUp(document.getElementById('top-up-amount').value)">儲值</button>
                <?php else: ?>
                    <p>請先查找會員號碼</p>
                <?php endif; ?>
            </div>
        </div>
        <button class="logout-button" onclick="window.location.href='logout.php'">登出</button>
        
    </div>

    <div id="a3" style="display: none;">
        <div class="tab-menu">
            <br>
            <div class="active" onclick="d1()">儲值記錄</div>
            <div onclick="d2()">消費記錄</div>
        </div>

        <div id="top-up-records" class="tab-content " style="display: block;">
            <form action="javascript:void(0);" method="get" onsubmit="loadTopUpRecords()">
                <label for="topup-member-id">會員編號:</label>
                <input type="text" id="topup-member-id" name="topup_member_id">
                <label for="topup-employee-id">員工編號:</label><br>
                <input type="text" id="topup-employee-id" name="topup_employee_id">
                <input type="submit" value="查詢">
            </form><br>
            <button onclick="loadTopUpRecords('ASC')">升序</button>
            <button onclick="loadTopUpRecords('DESC')">降序</button>
            <div class="topup-table-container">
                <div class="center-text">
                    <h2>儲值記錄</h2>
                </div>
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
                <br><br>
            </div>
        </div>

        <div id="order-records" class="tab-content">
            <form action="javascript:void(0);" method="get" onsubmit="loadOrderRecords()">
                <label for="order-member-id">會員編號:</label>
                <input type="text" id="order-member-id" name="order_member_id"><br>
                <label for="order-employee-id">員工編號:</label><br>
                <input type="text" id="order-employee-id" name="order_employee_id">
                <input type="submit" value="查詢">
            </form>
            <div class="topup-table-container">
                <div class="center-text">
                    <h2>消費記錄</h2>
                </div>
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
                <br><br>
            </div>
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

    <button class="btn logout" onclick="window.location.href='logout.php'">登出</button>
    <div class="footer">
        footer 
    </div>
</body>
</html>
