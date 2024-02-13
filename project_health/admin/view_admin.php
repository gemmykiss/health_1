<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

function fetchDataFromDatabase()
{
    global $conn;

    try {
        $sql = "SELECT * FROM health_checkup";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function updateRecord($id, $subject, $details, $cost)
{
    global $conn;

    try {
        $sql = "UPDATE health_checkup SET checkup_subject = :subject, checkup_details = :details, checkup_cost = :cost WHERE id_topic = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindParam(':details', $details, PDO::PARAM_STR);
        $stmt->bindParam(':cost', $cost, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function deleteRecord($id)
{
    global $conn;

    try {
        $sql = "DELETE FROM health_checkup WHERE id_topic = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_id'])) {
        $id_to_update = $_POST['update_id'];
        $subject = $_POST['update_subject'];
        $details = $_POST['update_details'];
        $cost = $_POST['update_cost'];

        if (updateRecord($id_to_update, $subject, $details, $cost)) {
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        }
    } elseif (isset($_POST['delete_id'])) {
        $id_to_delete = $_POST['delete_id'];

        if (deleteRecord($id_to_delete)) {
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        }
    }
}
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
    <link rel="shortcut icon" href="../image/logo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        .modal-body .alert {
            margin-bottom: 15px;
        }

        /* Styles for the success message */
        .success-message {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Include Header -->
        <?php include "header/header.php"; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="input-group">
                        <h1 class="h3 mb-0 text-gray-800">เพิ่มหัวข้อการตรวจ</h1>&nbsp; &nbsp;
                    </div>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">ข้อมูลทั่วไป</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>การตรวจ</th>
                                            <th>รายละเอียดการตรวจ</th>
                                            <th>ค่าใช้จ่าย</th>
                                            <th>ควบคุม</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $data = fetchDataFromDatabase();
                                        $counter = 1; // เพิ่มตัวแปรนับลำดับ
                                        foreach ($data as $row) {
                                            echo "<tr>";
                                            echo "<td>{$counter}</td>";
                                            echo "<td>" . $row['checkup_subject'] . "</td>";
                                            echo "<td>" . $row['checkup_details'] . "</td>";
                                            echo "<td>" . $row['checkup_cost'] . "</td>";
                                            echo "<td>
                                                      <button class='btn btn-primary btn-sm' data-toggle='modal' data-target='#editModal{$row['id_topic']}'>แก้ไข</button>
                                                      <button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#deleteModal{$row['id_topic']}'>ลบ</button>
                                                  </td>";
                                            echo "</tr>";

                                            // Edit Modal for each row
                                            echo "<div class='modal fade' id='editModal{$row['id_topic']}' tabindex='-1' role='dialog' aria-labelledby='editModalLabel{$row['id_topic']}' aria-hidden='true'>
                                                    <!-- ... (ตัวอย่างโค้ดที่ไม่เปลี่ยนแปลง) ... -->
                                                </div>";

                                            // Delete Modal for each row
                                            echo "<div class='modal fade' id='deleteModal{$row['id_topic']}' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel{$row['id_topic']}' aria-hidden='true'>
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <h5 class='modal-title' id='deleteModalLabel{$row['id_topic']}'>ลบข้อมูลการตรวจ</h5>
                                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                    <span aria-hidden='true'>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <!-- Delete confirmation goes here -->
                                                                <p>คุณแน่ใจหรือไม่ที่จะลบข้อมูลนี้?</p>
                                                                <form method='post' action='{$_SERVER['PHP_SELF']}'>
                                                                    <input type='hidden' name='delete_id' value='{$row['id_topic']}'>
                                                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>ยกเลิก</button>
                                                                    <button type='submit' class='btn btn-danger'>ลบ</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";

                                            $counter++; // เพิ่มค่าลำดับ
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
