<?php
// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // If not logged in, redirect to login page
    header("Location: index.php");
    exit();
}

// If user is logged in, get user information
$user = $_SESSION['user'];
?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>คณะพยาบาลศาสตร์ ม.ขอนแก่น</title>

  <!-- Custom fonts for this template-->
  <link rel="shortcut icon" href="./image/logo.png" type="image/x-icon">
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="./css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
 
<header>

        <!-- แสดงข้อมูลผู้ใช้หรือส่วนอื่น ๆ ตามต้องการ -->

    </header>
  <?php
    include "header/header.php";
    ?>
</body>