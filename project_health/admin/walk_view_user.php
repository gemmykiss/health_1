<?php
session_start(); // Start session

require_once '../config/db.php';

// Query to get distinct user_ids and their count from google_fit_steps table
$query = "SELECT user_id, COUNT(*) as count FROM google_fit_steps GROUP BY user_id";
$result = $conn->query($query);
$userCounts = $result->fetchAll(PDO::FETCH_ASSOC);
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

    <style>
        /* Add this style to highlight rows on hover */
        .highlight-row:hover {
            background-color: #f2f2f2; /* Change color as needed */
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
                        <h1 class="h3 mb-0 text-gray-800">การเดินของผู้ใช้งาน</h1>&nbsp; &nbsp;
                    </div>
                </nav>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">ข้อมูลการเดิน</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>รายละเอียด</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($userCounts as $userCount): ?>
                                        <tr class="highlight-row">
                                            <td><?php echo $userCount['user_id']; ?></td>
                                            <td class>
                                                <button class="btn btn-info" data-toggle="modal" data-target="#userDetailsModal" data-userid="<?php echo $userCount['user_id']; ?>">ดูข้อมูลเพิ่มเติม</button>
                                                

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript -->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages -->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- jQuery for fetching user details and displaying in modal -->
    <script>
    $(document).ready(function () {
        // When the "ดูข้อมูลเพิ่มเติม" button is clicked
        $('#userDetailsModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var userId = button.data('userid'); // Extract user_id from data-userid attribute

            // Make an AJAX request to fetch additional user details
            $.ajax({
                type: 'POST',
                url: 'add_data/fetch_user_details.php', // Adjust the URL to your PHP script
                data: { user_id: userId },
                success: function (response) {
                    // Update the modal content with the fetched data
                    $('#userDetailsModalContent').html(response);
                }
            });
        });

        // When the modal is closed
        $('#userDetailsModal').on('hidden.bs.modal', function () {
            // Reload the page using AJAX
            location.reload();
        });
    });
</script>













    <!-- Modal for displaying user details -->
    <div class="modal fade" id="userDetailsModal" tabindex="-1" role="dialog" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userDetailsModalLabel">ข้อมูลเพิ่มเติมของผู้ใช้ (User ID: <span id="modalUserId"></span>)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="userDetailsModalContent">
                    <!-- Content will be loaded here using AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
