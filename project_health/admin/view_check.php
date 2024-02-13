<?php
require_once '../config/db.php';
session_start();


// Function to fetch data from the database
function fetchDataFromDatabase()
{
    global $conn; // Assuming $conn is your PDO database connection object

    $data = array();

    // Perform the SQL query to retrieve data from the health_checkup table
    $sql = "SELECT * FROM health_checkup";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result) {
        // Fetch data from the result set
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        // Close the result set
        $result->closeCursor();
    }

    return $data;
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
                            <form method="post" action="add_data/add_test_set.php">
                                <div class="form-row mb-3">
                                    <div class="col-md-4">
                                        <label for="testSetNumber">เลขชุดตรวจ:</label>
                                        <input type="text" class="form-control" id="testSetNumber" name="testSetNumber">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="testSetName">ชื่อชุดตรวจ:</label>
                                        <input type="text" class="form-control" id="testSetName" name="testSetName">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table my-0" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th class="text-dark">ลำดับ</th>
                                                <th class="text-dark">การตรวจ</th>
                                                <th class="text-dark">รายละเอียดการตรวจ</th>
                                                <th class="text-dark">เช็ค</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // เรียกใช้ฟังก์ชัน fetchDataFromDatabase() เพื่อดึงข้อมูล
                                            $data = fetchDataFromDatabase();
                                            $counter = 1;

                                            foreach ($data as $row) {
                                                echo "<tr>";
                                                echo "<td>{$counter}</td>";
                                                echo "<td>" . $row['checkup_subject'] . "</td>";
                                                echo "<td>" . $row['checkup_details'] . "</td>";
                                                echo "<td><input type='checkbox' name='selected_rows[]' value='" . $row['id_topic'] . "'></td>";
                                                echo "</tr>";

                                                $counter++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="submit" class="btn btn-primary">เพิ่มชุดตรวจ</button>
                            </form>
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
