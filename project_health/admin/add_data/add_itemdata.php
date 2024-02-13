<?php
require_once '../../config/db.php';

// เริ่ม session
session_start();

// ตรวจสอบว่ามี session user หรือไม่
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

// ตรวจสอบว่ามีการส่งข้อมูลมาจากฟอร์มหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่าค่าที่รับมาไม่ใช่ค่าว่าง
    if (!empty($_POST['checkup_subject']) && !empty($_POST['checkup_details']) && !empty($_POST['check_up_times'])) {
        // รับค่าจากฟอร์ม
        $checkup_subject = $_POST['checkup_subject'];
        $checkup_details = $_POST['checkup_details'];
        

        try {
            // เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูล
            $sql = "INSERT INTO health_checkup (checkup_subject, checkup_details, ) VALUES (:checkup_subject, :checkup_details,)";

            // เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูล
            $stmt = $conn->prepare($sql);

            // ทำการ bind ค่า
            $stmt->bindParam(':checkup_subject', $checkup_subject);
            $stmt->bindParam(':checkup_details', $checkup_details);
            

            // ทำการ execute คำสั่ง SQL
            $stmt->execute();

            // สร้าง session success เพื่อให้แสดงข้อความบันทึกสำเร็จในหน้า add_item.php
            $_SESSION['success'] = true;

            // Redirect กลับไปที่หน้า add_item.php
            header("Location: ../add_item.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            // ปิดการเชื่อมต่อฐานข้อมูล
            $stmt = null;
            $conn = null;
        }
    } else {
        echo "กรุณากรอกข้อมูลให้ครบทุกช่อง";
    }
} else {
    echo "Invalid Request";
}
?>
