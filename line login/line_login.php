<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$client_id = 'YOUR_CHANNEL_ID';
$redirect_uri = 'https://yourdomain.com/line_callback.php';
$scope = 'profile openid email';
$state = bin2hex(random_bytes(16));
$_SESSION['state'] = $state;

$auth_url = "https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id={$client_id}&redirect_uri={$redirect_uri}&scope={$scope}&state={$state}";

header('Location: ' . $auth_url);
exit;
?>
