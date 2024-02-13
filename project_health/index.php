<?php
require './popup/popup.php';

if (isset($_REQUEST['error'])) {
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'เข้าสู่ระบบ ไม่สำเร็จ',
                icon: 'error',
                confirmButtonText: 'ตกลง',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "./index.php";
                }
            });
        });
    </script>
<?php
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

    <title>login</title>
    <!-- Custom fonts for this template-->
    <link href="./css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="./css/bg.css">
    <!-- animation -->
    <link rel="stylesheet" href="../css/animation.css">
    <!-- Custom styles for this template-->
    <link href="./css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="./image/logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>

</head>

<body class="bg">
    
    <div id="overlay"></div>
    <div class="w3-container w3-center w3-animate-top" style="animation-duration: 500ms;">
        <div class="container">
            <!-- Outer Row -->
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <center>
                                                <img class=" d-none d-lg-block" src="./image/logo.png" width="150px" height="145px"><br>
                                            </center>
                                            <h1 class="h4 text-gray-900 mb-4 t1"><strong>ระบบบันทึกสุภาพประจำปี</strong></h1>
                                            <h1 class="h4 text-gray-900 mb-4 t1"><strong>คณะพยาบาลศาสตร์ มข. </strong></h1>
                                        </div>
                                        <form action="login.php" method="post">
                                            <div class="form-group row">
                                                <div class="col-sm-8 mb-3 mb-sm-0 mx-auto">
                                                    <input type="text" class="form-control t1" name="id" placeholder="รหัสประจำตัว">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-8 mb-3 mb-sm-0 mx-auto">
                                                    <input type="text" class="form-control t1" name="name" placeholder="ชื่อนามสกุล">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-8 mb-3 mb-sm-0 mx-auto">
                                                    <input type="text" class="form-control t1" name="phone" placeholder="เบอร์ติดต่อ">
                                                </div>
                                            </div>

                                            
                                            <center>
                                                <button type="submit" name="submit" class="btn btn-success t1 wider-btn">เข้าสู่ระบบ</button>
                                            </center>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
</body>

</html>