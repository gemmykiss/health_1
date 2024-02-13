<?php

require_once '../config/db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get data from the form
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $age = $_POST['age'];
    $chronic_disease = isset($_POST['chronic_disease']) ? 1 : 0;
    $medical_history = $_POST['medical_history'];

    try {
        // Insert data into health_checkup_data table
        $sql_insert = "INSERT INTO health_checkup_data (user_id, name, weight, height, age, chronic_disease, medical_history)
                       VALUES (:user_id, :name, :weight, :height, :age, :chronic_disease, :medical_history)";

        $stmt = $conn->prepare($sql_insert);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':weight', $weight);
        $stmt->bindParam(':height', $height);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':chronic_disease', $chronic_disease, PDO::PARAM_INT);
        $stmt->bindParam(':medical_history', $medical_history);

        $stmt->execute();

        // Insert successful
        echo "บันทึกข้อมูลสำเร็จ";

        header("Location: ../user_dashboard.php");
        exit(); // ตรวจสอบว่าหลังจาก header ไม่มีการรันโค้ดเพิ่มเติม
    } catch (PDOException $e) {
        // Insert failed
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $e->getMessage();
    }
}
?>
