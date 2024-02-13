<?php
require_once '../../config/db.php';
session_start();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่าฟอร์มถูกส่งมาหรือไม่

    // ดึงข้อมูลเลขชุดตรวจจากฟอร์ม
    $testSetNumber = isset($_POST['testSetNumber']) ? $_POST['testSetNumber'] : '';
    $testSetName = isset($_POST['testSetName']) ? $_POST['testSetName'] : '';

    // ดึงข้อมูล checkbox ที่ถูกเลือกจากฟอร์ม
    $selectedRows = isset($_POST['selected_rows']) ? $_POST['selected_rows'] : [];

    // ตรวจสอบและทำความสะอาดข้อมูลตามต้องการ

    try {
        // เตรียมและทำคำสั่ง SQL เพื่อแทรกข้อมูลลงในฐานข้อมูล
        $stmt = $conn->prepare("INSERT INTO set_test (sect, topic_sect, checkup_subject, checkup_details, id_topic) 
                                SELECT :testSetNumber, :testSetName, checkup_subject, checkup_details, id_topic
                                FROM health_checkup
                                WHERE id_topic = :checkupId");

        // วนลูปผ่าน checkbox ที่ถูกเลือกและแทรกข้อมูลลงในฐานข้อมูล
        foreach ($selectedRows as $checkupId) {
            $stmt->bindParam(':testSetNumber', $testSetNumber);
            $stmt->bindParam(':testSetName', $testSetName);
            $stmt->bindParam(':checkupId', $checkupId);
            $stmt->execute();
        }

        // ปิดการเชื่อมต่อฐานข้อมูล
        $conn = null;

        // โอนที่ไปยังหน้าสำเร็จหรือดำเนินการอื่น ๆ
        header("Location: success.php");
        exit();
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาดของฐานข้อมูล
        echo "Error: " . $e->getMessage();
    }
}
?>
