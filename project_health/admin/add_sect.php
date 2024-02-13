<?php
require_once '../config/db.php';
session_start();

// Function to fetch unique sect values from set_test
function fetchUniqueSectValues()
{
    global $conn;

    $data = array();

    // Perform the SQL query to retrieve unique sect values from set_test
    $sql = "SELECT DISTINCT sect FROM set_test";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result) {
        // Fetch data from the result set
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row['sect'];
        }

        // Close the result set
        $result->closeCursor();
    }

    return $data;
}

// Function to fetch data for a specific sect
function fetchDataForSect($sect)
{
    global $conn;

    $data = array();

    // Perform the SQL query to retrieve data for a specific sect from set_test
    $sql = "SELECT id_test_set, topic_sect, checkup_subject, checkup_details FROM set_test WHERE sect = :sect";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':sect', $sect);
    $stmt->execute();

    // Check if the query was successful
    if ($stmt) {
        // Fetch data from the result set
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        // Close the result set
        $stmt->closeCursor();
    }

    return $data;
}

// Delete data for a specific id_test_set
function deleteDataForIdTestSet($id_test_set)
{
    global $conn;

    // Perform the SQL query to delete data for a specific id_test_set from set_test
    $sql = "DELETE FROM set_test WHERE id_test_set = :id_test_set";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_test_set', $id_test_set);

    // Execute the statement
    $stmt->execute();

    // Close the statement
    $stmt->closeCursor();
}

// Fetch unique sect values
$uniqueSectValues = fetchUniqueSectValues();

// Check if the form is submitted for deleting data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_id"])) {
    // Get the id_test_set to be deleted
    $id_test_set_to_delete = $_POST["delete_id"];

    // Call the function to delete data
    deleteDataForIdTestSet($id_test_set_to_delete);
}
?>

<!DOCTYPE html>
<html lang="th">

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
                <!-- ... (Your existing topbar content) ... -->
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">ข้อมูลทั่วไป</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form method="post">
                                <div class="form-row mb-3">
                                    <?php
                                    // Check if there are unique sect values
                                    if (!empty($uniqueSectValues)) {
                                        foreach ($uniqueSectValues as $sect) {
                                            echo "<div class='col-md-3 mb-2'>";
                                            $sectData = fetchDataForSect($sect);
                                            $topicSect = (!empty($sectData) && !empty($sectData[0]['topic_sect'])) ? $sectData[0]['topic_sect'] : "ไม่พบข้อมูล";
                                            echo "<button type='button' class='btn btn-primary btn-block' data-toggle='modal' data-target='#modal{$sect}'>ชุดตรวจที่: {$sect} - {$topicSect}</button>";

                                            echo "</div>";

                                            // Modal for each sect
                                            echo "<div class='modal fade' id='modal{$sect}' tabindex='-1' role='dialog' aria-labelledby='modal{$sect}Label' aria-hidden='true'>";
                                            echo "<div class='modal-dialog' role='document'>";
                                            echo "<div class='modal-content'>";
                                            echo "<div class='modal-header'>";
                                            echo "<h5 class='modal-title' id='modal{$sect}Label'>ข้อมูลชุดตรวจที่ {$sect}</h5>";
                                            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                                            echo "<span aria-hidden='true'>&times;</span>";
                                            echo "</button>";
                                            echo "</div>";
                                            echo "<div class='modal-body'>";

                                            // Fetch and display data for the sect
                                            if (!empty($sectData)) {
                                                echo "<form method='post'>";
                                                echo "<table class='table table-bordered'>";
                                                echo "<thead>";
                                                echo "<tr>";
                                                echo "<th>ชื่อชุดตรวจ</th>";
                                                echo "<th>หัวข้อสิ่งที่ตรวจ</th>";
                                                echo "<th>รายละเอียด</th>";
                                                echo "<th>ลบ</th>";
                                                echo "</tr>";
                                                echo "</thead>";
                                                echo "<tbody>";
                                                foreach ($sectData as $row) {
                                                    echo "<tr>";
                                                    echo "<td>{$row['topic_sect']}</td>";
                                                    echo "<td>{$row['checkup_subject']}</td>";
                                                    echo "<td>{$row['checkup_details']}</td>";
                                                    echo "<td><button type='submit' name='delete_id' value='{$row['id_test_set']}' class='btn btn-danger'>Delete</button></td>";
                                                    echo "</tr>";
                                                }
                                                echo "</tbody>";
                                                echo "</table>";
                                                echo "</form>";
                                            } else {
                                                echo "ไม่พบข้อมูลชุดตรวจสำหรับ {$sect}";
                                            }

                                            echo "</div>";
                                            echo "<div class='modal-footer'>";
                                            echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                    } else {
                                        echo "<div class='col-md-12'>ไม่พบข้อมูลชุดตรวจ</div>";
                                    }
                                    ?>
                                </div>
                            </form>
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
