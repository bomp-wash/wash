<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$client_id = 'YOUR_CHANNEL_ID';
$client_secret = 'YOUR_CHANNEL_SECRET';
$redirect_uri = 'https://yourdomain.com/line_callback.php';

if ($_SESSION['state'] !== $_GET['state']) {
    die('Invalid state');
}

$code = $_GET['code'];

$token_url = 'https://api.line.me/oauth2/v2.1/token';
$data = [
    'grant_type' => 'authorization_code',
    'code' => $code,
    'redirect_uri' => $redirect_uri,
    'client_id' => $client_id,
    'client_secret' => $client_secret
];

$options = [
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => http_build_query($data)
    ]
];
$context = stream_context_create($options);
$response = file_get_contents($token_url, false, $context);
$token_data = json_decode($response, true);

$access_token = $token_data['access_token'];

$user_info_url = 'https://api.line.me/v2/profile';
$options = [
    'http' => [
        'method' => 'GET',
        'header' => 'Authorization: Bearer ' . $access_token
    ]
];
$context = stream_context_create($options);
$response = file_get_contents($user_info_url, false, $context);
$user_info = json_decode($response, true);

// 獲取用戶資料
$line_id = $user_info['userId'];
$display_name = $user_info['displayName'];
$picture_url = $user_info['pictureUrl'];

// 將用戶資料存儲到session或數據庫中
$_SESSION['line_id'] = $line_id;
$_SESSION['display_name'] = $display_name;
$_SESSION['picture_url'] = $picture_url;

// 重定向到您的首頁或管理頁面
header('Location: 管理頁面URL');
exit;
?>
