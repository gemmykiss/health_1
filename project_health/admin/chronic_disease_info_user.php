<?php
require_once '../config/db.php';
session_start(); // Start session
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
  <link rel="shortcut icon" href="../image/logo.png" type="image/x-icon">
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Add Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <!-- Add Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Include Header -->
        <?php include "header/header.php"; ?>

        <!-- Content Section -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">

                    <!-- Your Content Goes Here -->

                    <h1 class="h3 mb-4 text-gray-800">โปรไฟล์ผู้มีโรคประจำตัว</h1>

                    <?php
                    try {
                        // Query to select distinct user_id and corresponding name with the latest data
                        $sql = "SELECT user_id, name, chronic_disease, procedures, treatment_history, MAX(date) as max_date
                                FROM chronic_disease_info 
                                GROUP BY user_id 
                                ORDER BY max_date DESC";

                        $stmt = $conn->query($sql);

                        echo '<table class="table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>User ID</th>';
                        echo '<th>ชื่อ</th>';
                        echo '<th>ดูรายละเอียด</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td>' . $row['user_id'] . '</td>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td><button class="btn btn-primary" data-toggle="modal" data-target="#myModal' . $row['user_id'] . '">View</button></td>';
                            echo '</tr>';

                            // Modal for each user
                            echo '<div class="modal fade" id="myModal' . $row['user_id'] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">';
                            echo '<div class="modal-dialog" role="document">';
                            echo '<div class="modal-content">';
                            echo '<div class="modal-header">';
                            echo '<h5 class="modal-title" id="myModalLabel">User ID: ' . $row['user_id'] . '</h5>';
                            echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                            echo '<span aria-hidden="true">&times;</span>';
                            echo '</button>';
                            echo '</div>';
                            echo '<div class="modal-body">';
                           

                            // Display additional details for the specific user
                            $additionalDetailsSql = "SELECT * FROM chronic_disease_info WHERE user_id = :user_id ORDER BY date DESC";
                            $additionalDetailsStmt = $conn->prepare($additionalDetailsSql);
                            $additionalDetailsStmt->bindParam(':user_id', $row['user_id']);
                            $additionalDetailsStmt->execute();

                            echo '<h6>โรคประจำตัวที่มี:</h6>';
                            echo '<ul>';
                            while ($additionalDetailsRow = $additionalDetailsStmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<li>';
                                
                                echo '<p>โรคประจำตัว: ' . $additionalDetailsRow['chronic_disease'] . ' ';
                                echo '<p>ระยะเวลาที่่เป็น: ' . $additionalDetailsRow['procedures'] . ' ';
                                echo '<p>ประวติการรักษา: ' . $additionalDetailsRow['treatment_history'];
                                echo '<p>วันที่ Update: ' . $additionalDetailsRow['date'] . ' ';
                                echo '</li>';
                            }
                            echo '</ul>';

                            echo '</div>';
                            echo '<div class="modal-footer">';
                            echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                    } catch (PDOException $e) {
                        echo 'Error: ' . $e->getMessage();
                    }
                    ?>

                </div>
            </div>
        </div>
        </div>
    


    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
</body>
</html>
