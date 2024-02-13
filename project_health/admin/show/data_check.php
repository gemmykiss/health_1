<?php
// ต่อกับฐานข้อมูล
require_once '../../config/db.php';

// SQL สำหรับนับจำนวนผู้ใช้
$userCountQuery = "SELECT COUNT(*) AS user_count FROM user";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCount = mysqli_fetch_assoc($userCountResult)['user_count'];

// SQL สำหรับนับจำนวนผู้ที่ตรวจแล้ว
$userCheckedCountQuery = "SELECT COUNT(*) AS user_checked_count FROM user WHERE checked = 1";
$userCheckedCountResult = mysqli_query($conn, $userCheckedCountQuery);
$userCheckedCount = mysqli_fetch_assoc($userCheckedCountResult)['user_checked_count'];

// สร้าง associative array เพื่อเก็บข้อมูล
$data = array(
    'total' => $userCount,
    'checked' => $userCheckedCount
);

// ส่งข้อมูลเป็น JSON
header('Content-Type: application/json');
echo json_encode($data);
?>