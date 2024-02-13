<?php
require_once '../config/db.php';
require_once '../TCPDF-main/tcpdf.php';

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

    // Create a new PDF document
    $pdf = new TCPDF();
    $pdf->SetAutoPageBreak(true, 10);

    // Set font
    $pdf->SetFont('freeserif', '', 10); // ลดขนาดตัวอักษรเป็น 10 พิกเซล

    // Set language (optional)
    $pdf->setLanguageArray(array('tha'));

    // Set Thai language
    $pdf->setLanguageArray(array(
        'a_meta_charset' => 'UTF-8',
        'a_meta_dir' => 'ltr',
        'a_meta_language' => 'th',
        'w_page' => 'page',
    ));

    $pdf->SetAutoPageBreak(true, 10);
    $pdf->AddPage();

    // Display user information in PDF
    $pdf->SetFont('freeserif', 'B', 14); // ลดขนาดตัวอักษรเป็น 14 พิกเซล
    $pdf->Cell(0, 8, 'รายละเอียดผู้ใช้', 0, 1, 'C');

    $pdf->SetFont('freeserif', '', 10); // ลดขนาดตัวอักษรเป็น 10 พิกเซล
    $pdf->Cell(0, 8, "User ID: $user_id", 0, 1, 'L');
    $pdf->Cell(0, 8, "ชื่อ: {$userDetails[0]['name']}", 0, 1, 'L');
    $pdf->Cell(0, 8, "อายุ: {$generalInfo['age']}", 0, 1, 'L');
    $pdf->Cell(0, 8, "น้ำหนัก: {$generalInfo['weight']}", 0, 1, 'L');
    $pdf->Cell(0, 8, "ส่วนสูง: {$generalInfo['height']}", 0, 1, 'L');
    $pdf->Cell(0, 8, "BMI ประเภท: {$generalInfo['bmi_category']}", 0, 1, 'L');

    // Display checkup sets in PDF as a table
    $pdf->Ln(8);
    $pdf->SetFont('freeserif', 'B', 14); // ลดขนาดตัวอักษรเป็น 14 พิกเซล
    $pdf->Cell(0, 8, 'ชุดตรวจ ' . $sect . ' ชื่อชุดตรวจ: ' . $checkupSetData['topic_sect'], 0, 1, 'C');

    
    $pdf->SetFont('freeserif', '', 10); // ลดขนาดตัวอักษรเป็น 10 พิกเซล

    // Add table headers
    $pdf->SetFillColor(200, 220, 255);
    $pdf->Cell(10, 8, 'ลำดับ', 1, 0, 'C', 1);
    $pdf->Cell(80, 8, 'หัวข้อการตรวจ', 1, 0, 'C', 1);
    $pdf->Cell(80, 8, 'รายละเอียดการตรวจ', 1, 0, 'C', 1);
    $pdf->Cell(20, 8, 'การตรวจ', 1, 1, 'C', 1);

    // Add data rows to the table
    $counter = 1;
    foreach ($allCheckupSets as $checkupSet) {
        $pdf->Cell(10, 8, $counter, 1);
        $pdf->Cell(80, 8, $checkupSet['checkup_subject'], 1);
        $pdf->Cell(80, 8, $checkupSet['checkup_details'], 1);
        
        
        // Check if the user has done this checkup
        $isChecked = false;

        foreach ($userDetails as $userCheckup) {
            if ($checkupSet['id_topic'] == $userCheckup['id_topic'] &&
                $checkupSet['checkup_subject'] == $userCheckup['checkup_subject'] &&
                $checkupSet['checkup_details'] == $userCheckup['checkup_details']) {
                $isChecked = true;
                break;  // No need to continue checking once a match is found
            }
        }

        // Display checkmark based on the condition
        $pdf->Cell(20, 8, ($isChecked ? "ตรวจ" : ""), 1);

        $pdf->Ln();
        $counter++;
    }

    // Output the PDF
    $pdf->Output("user_details_$user_id.pdf", 'D'); // 'D' means download
} else {
    // Redirect to error page or handle the case where parameters are not set
    header("Location: error_page.php");
    exit();
}
?>
