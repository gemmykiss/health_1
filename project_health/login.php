<?php
require_once 'config/db.php';

session_start(); // เริ่ม session

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    // Validate inputs (เพิ่มการตรวจสอบข้อมูลตามความเหมาะสม)
    // ...

    // Query สำหรับตรวจสอบข้อมูลผู้ใช้และบทบาท
    $query = "SELECT * FROM user WHERE id=:id AND name=:name AND phone=:phone";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':phone', $phone);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // เก็บข้อมูลผู้ใช้ใน $_SESSION
        $_SESSION['user'] = $user;

        // ตรวจสอบบทบาทของผู้ใช้
        $role = $user['role'];

        if ($role == 'admin') {
            // เก็บ SESSION สำหรับบทบาท "admin"
            $_SESSION['admin'] = true;


            // ผู้ดูแลระบบล็อกอินสำเร็จ
            header("Location: admin/admin_dashboard.php");
            exit();

            
        } elseif ($role == 'user') {
            // ผู้ใช้ทั่วไปล็อกอินสำเร็จ
            header("Location: user/user_dashboard.php");
            exit();
        }
    } else {
        // การล็อกอินล้มเหลว
        header("Location: login.php?error=1");
        exit();
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn = null;
?>

