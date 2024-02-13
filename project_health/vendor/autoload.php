<?php
require_once '../config/db.php';
require_once('../TCPDF-main/tcpdf.php');

// ตรวจสอบว่ามีการส่งค่า user_id มาจากหน้าที่ก่อนหน้านี้หรือไม่
if (isset($_GET['user_id']) && isset($_GET['sect'])) {
    $user_id = $_GET['user_id'];
    $sect = $_GET['sect'];

      // Fetch information about the checkup set
      $sqlCheckupSet = "SELECT id_topic, topic_sect, checkup_subject, checkup_details FROM set_test WHERE sect = :sect";
      $stmtCheckupSet = $conn->prepare($sqlCheckupSet);
      $stmtCheckupSet->bindParam(':sect', $sect);
      $stmtCheckupSet->execute();
      $checkupSetData = $stmtCheckupSet->fetch(PDO::FETCH_ASSOC);
      $stmtCheckupSet->closeCursor();

          // Fetch details about the user
    $sqlUserDetails = "SELECT uc.*, st.checkup_subject, st.checkup_details
    FROM user_checkup uc
    INNER JOIN set_test st ON uc.id_topic = st.id_topic
    WHERE uc.user_id = :user_id AND uc.check_up_times = :sect";
    $stmtUserDetails = $conn->prepare($sqlUserDetails);
    $stmtUserDetails->bindParam(':user_id', $user_id);
    $stmtUserDetails->bindParam(':sect', $sect);
    $stmtUserDetails->execute();
    $userDetails = $stmtUserDetails->fetchAll(PDO::FETCH_ASSOC);
    $stmtUserDetails->closeCursor();

    // Fetch additional details about the user from general_info table
    $sqlGeneralInfo = "SELECT * FROM general_info WHERE user_id = :user_id ORDER BY id DESC LIMIT 1";
    $stmtGeneralInfo = $conn->prepare($sqlGeneralInfo);
    $stmtGeneralInfo->bindParam(':user_id', $user_id);
    $stmtGeneralInfo->execute();
    $generalInfo = $stmtGeneralInfo->fetch(PDO::FETCH_ASSOC);
    $stmtGeneralInfo->closeCursor();

    // Fetch all checkup sets related to the selected sect
    $sqlAllCheckupSets = "SELECT * FROM set_test WHERE sect = :sect";
    $stmtAllCheckupSets = $conn->prepare($sqlAllCheckupSets);
    $stmtAllCheckupSets->bindParam(':sect', $sect);
    $stmtAllCheckupSets->execute();
    $allCheckupSets = $stmtAllCheckupSets->fetchAll(PDO::FETCH_ASSOC);
    $stmtAllCheckupSets->closeCursor();

        // ตรวจสอบข้อมูลในตาราง user_checkup สำหรับ user_id ที่ระบุ
        $sql = "SELECT * FROM user_checkup WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // ตรวจสอบว่าคิวรีเสร็จสมบูรณ์หรือไม่
        if ($stmt) {
            // ดึงข้อมูลจากผลลัพธ์
            $userCheckupData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // ปิด statement
            $stmt->closeCursor();

            // ตรวจสอบว่า $userCheckupData ไม่ว่างเปล่า
            if (!empty($userCheckupData)) {
                // สร้างเอกสาร PDF ใหม่
                $pdf = new TCPDF();
                $pdf->SetAutoPageBreak(true, 10);

                // เพิ่มหน้าใหม่
                $pdf->AddPage();

                // ตั้งค่าแบบอักษร
                $pdf->SetFont('freeserif', '', 12);  // เปลี่ยนเป็นฟอนต์ที่รองรับภาษาไทย

                // ตั้งค่าภาษา
                $pdf->setLanguageArray(array('tha'));

                // เพิ่มหัวเรื่อง
                $pdf->Cell(0, 10, 'รายละเอียดการตรวจของผู้ใช้', 0, 1, 'C');

                // เพิ่ม ID ผู้ใช้
                $pdf->Cell(0, 10, 'ID ผู้ใช้: ' . $user_id, 0, 1, 'L');

                // เพิ่มรายละเอียดการตรวจ
                $pdf->Cell(0, 10, 'ชุดตรวจที่ ' . $check_up_times . ' ' . $topic_sect, 0, 1, 'L');

                // เพิ่มข้อมูลเพศ
                $pdf->Cell(0, 10, 'เพศ: ' . $gender, 0, 1, 'L');

                // เพิ่มตารางพร้อมข้อมูลการตรวจ
                $pdf->SetFillColor(200, 220, 255);
                $pdf->SetTextColor(0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetLineWidth(0.3);

                // ตั้งหัวตาราง
                $pdf->SetFont('', 'B');
                $pdf->Cell(30, 10, 'ลำดับที่', 1, 0, 'C', 1);
                $pdf->Cell(70, 10, 'สิ่งที่ตรวจ', 1, 0, 'C', 1);
                $pdf->Cell(90, 10, 'รายละเอียดที่ตรวจ', 1, 1, 'C', 1);
                
                // ตั้งแถวข้อมูล
                $pdf->SetFont('');
                foreach ($userCheckupData as $index => $row) {
                    $pdf->Cell(30, 10, $index + 1, 1, 0, 'C');
                    $pdf->Cell(70, 10, (string)$row['checkup_subject'], 1, 0, 'L');
                    $pdf->Cell(90, 10, (string)$row['checkup_details'], 1, 1, 'L');
                }
            } else {
                // ส่งเอกสาร PDF ให้ดาวน์โหลด (โดยใช้ข้อความแจ้งเตือน)
                $pdf = new TCPDF();
                $pdf->AddPage();
                $pdf->SetFont('freeserif', '', 12);  // เปลี่ยนเป็นฟอนต์ที่รองรับภาษาไทย
                $pdf->setLanguageArray(array('tha'));
                $pdf->Cell(0, 10, 'ไม่พบข้อมูลการตรวจสำหรับผู้ใช้ ID: ' . $user_id, 0, 1, 'C');
            }

            // ส่งเอกสาร PDF ให้ดาวน์โหลด
            $pdf->Output('user_checkup_details.pdf', 'D');
        } else {
            // กรณีไม่มีการส่งค่า check_up_times, topic_sect, และ gender มา
            echo 'ข้อมูลไม่ถูกต้อง';
        }
    } else {
        // กรณีไม่มีการส่ง user_id จะแสดงข้อความแจ้งเตือน
        echo 'ไม่พบข้อมูลผู้ใช้';
    }
} else {
    // กรณีไม่มีการส่งค่า user_id จะแสดงข้อความแจ้งเตือน
    echo 'ไม่พบข้อมูลผู้ใช้';
}
?>
