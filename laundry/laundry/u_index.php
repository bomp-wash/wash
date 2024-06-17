<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("db.php");?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>洗衣店12</title>
</head>
<body>
    <div class="container">
        <div class="header">
            洗衣店名稱
        </div>
        <div class="logo">
            LOGO
        </div>
        <button class="line-login" onclick="loginWithLine()">使用LINE登入</button>
        <form action="u_check.php" method="post">
            <table>
                <tr>
                    <td>帳號</td>
                    <td><input type="text" name="account" required></td>
                </tr>
               
                <tr>
                    <td colspan="2">
                        <input type="submit" value="送出">
                        <input type="reset" value="重置">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="footer">
        我是footer
    </div>

    <script>
        function loginWithLine() {
            alert('使用LINE登入');
            window.location.href = 'u_admin.php';
        }
    </script>
</body>
</html>
