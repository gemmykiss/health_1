<?php
require_once '../../config/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $targetDirectory = '../uploads/';
    $targetFile = $targetDirectory . basename($_FILES['profile_picture']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // ตรวจสอบว่าไฟล์ที่อัพโหลดเป็นรูปภาพจริงหรือไม่
    $check = getimagesize($_FILES['profile_picture']['tmp_name']);
    if ($check === false) {
        $uploadOk = 0;
    }

    // ตรวจสอบขนาดของไฟล์
    if ($_FILES['profile_picture']['size'] > 500000) {
        $uploadOk = 0;
    }

    // อนุญาตเฉพาะรูปภาพ certain รูปแบบเท่านั้น
    if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg') {
        $uploadOk = 0;
    }

    // ตรวจสอบว่า $uploadOk ถูกตั้งค่าเป็น 0 โดยข้อผิดพลาด
    if ($uploadOk == 0) {
        // ถ้าไม่สามารถอัพโหลดไฟล์ได้
        echo '<div class="alert alert-danger" role="alert">';
        echo 'ขออภัย ไม่สามารถอัพโหลดไฟล์ของคุณได้';
        echo '</div>';
    } else {
        // ถ้าทุกอย่างถูกต้อง ลองอัพโหลดไฟล์
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
            // อัพเดทตารางผู้ใช้ด้วยที่อยู่ของไฟล์
            $profilePicturePath = 'uploads/' . basename($_FILES['profile_picture']['name']);
            $updateQuery = $conn->prepare("UPDATE user SET profile_picture = :profile_picture WHERE id = :user_id");
            $updateQuery->bindParam(':profile_picture', $profilePicturePath);
            $updateQuery->bindParam(':user_id', $user['id']);
            $updateQuery->execute();

            // กลับไปที่หน้าโปรไฟล์
            header("Location: ../user_dashboard.php");
            exit();
        } else {
            // ถ้าเกิดข้อผิดพลาดในการอัพโหลดไฟล์
            echo '<div class="alert alert-danger" role="alert">';
            echo 'ขออภัย เกิดข้อผิดพลาดในการอัพโหลดไฟล์ของคุณ';
            echo '</div>';
        }
    }
} else {
    // ถ้าไม่ได้ส่งคำขอ POST หรือไม่มีไฟล์ที่อัพโหลด
    header("Location: ../user_dashboard.php");
    exit();
}
?>
