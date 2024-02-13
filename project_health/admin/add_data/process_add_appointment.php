<?php
session_start();

require_once '../../config/db.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีข้อมูลที่จำเป็นส่งมาจากฟอร์มหรือไม่
    if (isset($_POST['appointment_date']) && isset($_POST['appointment_number']) && isset($_POST['topic'])) {
        // รับค่าจากฟอร์ม
        $appointment_date = $_POST['appointment_date'];
        $appointment_number = $_POST['appointment_number'];
        $topic = $_POST['topic'];

        // สร้างคำสั่ง SQL สำหรับบันทึกข้อมูล
        $query = "INSERT INTO appointment (appointment_date, appointment_number, topic) VALUES (:appointment_date, :appointment_number, :topic)";
        $statement = $conn->prepare($query);

        // Bind parameters
        $statement->bindParam(':appointment_date', $appointment_date);
        $statement->bindParam(':appointment_number', $appointment_number);
        $statement->bindParam(':topic', $topic);

        // Execute the statement
        if ($statement->execute()) {
            $_SESSION['success_message'] = 'เพิ่มการนัดหมายและหัวข้อเรียบร้อยแล้ว';
        } else {
            $_SESSION['error_message'] = 'มีข้อผิดพลาดในการเพิ่มการนัดหมาย';
        }
        header('Location: ../appointment.php');
        exit();
    } else {
        $_SESSION['error_message'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
        header('Location: ../appointment.php');
        exit();
    }
} else {
    header('Location: ../appointment.php');
    exit();
}
?>
