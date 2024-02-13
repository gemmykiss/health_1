<?php


require_once '../config/db.php';
session_start(); // เริ่ม session

if (!isset($_SESSION['user'])) {
    // ถ้าไม่มี session user แสดงว่าผู้ใช้ไม่ได้ทำการล็อกอิน
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user']; // ถ้ามี session user ให้นำข้อมูลมาใช้




$client_id = '33432222090-slavdramlke52egds7622saiumo43e2o.apps.googleusercontent.com';
$client_secret = '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';
$redirect_uri = 'http://localhost/std/project_health/API/login.php'; // แก้ไปที่ walk.php
$scope = 'https://www.googleapis.com/auth/fitness.activity.read';

if (!isset($_GET['code'])) {
    $auth_url = 'https://accounts.google.com/o/oauth2/auth';
    $auth_url .= '?client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&scope=' . $scope . '&response_type=code';

    // Redirect ไปยัง URL สำหรับการอนุญาต
    header('Location: ' . $auth_url);
    exit;
} else {
    $token_url = 'https://accounts.google.com/o/oauth2/token';
    $token_params = array(
        'code' => $_GET['code'],
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code'
    );

    // ขอรับ access token
    $curl = curl_init($token_url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $token_params);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $token_response = curl_exec($curl);
    curl_close($curl);

    $token_data = json_decode($token_response, true);

    if (isset($token_data['access_token'])) {
        // Redirect ไปที่ walk.php พร้อมกับส่ง Access Token
        header('Location: walk.php?access_token=' . $token_data['access_token']);
        exit;
    } else {
        echo "Error: Access token is missing.";
    }
}

?>
