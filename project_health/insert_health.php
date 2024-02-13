<?php
session_start(); // เริ่ม session

if (!isset($_SESSION['user'])) {
    // ถ้าไม่มี session user แสดงว่าผู้ใช้ไม่ได้ทำการล็อกอิน
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user']; // ถ้ามี session user ให้นำข้อมูลมาใช้
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
  <link  rel="shortcut icon" href="./image/logo.png" type="image/x-icon">
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="./css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

  <?php
  include "header/header.php";
    
    ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <div class="input-group">
            <h1 class="h3 mb-0 text-gray-800">แบบฟอร์มบันทึกข้อมูลสุภาพ</h1>&nbsp; &nbsp;
            <h1 class="h3 mb-0 text-gray-800">สวัสดี <?php echo $user['name']; ?>!</h1>
            
            
            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">ข้อมูลทั่วไป</h1>

          <!-- Health Checkup Modal Trigger Button -->
          <div class="row">
            <div class="col-md-4">
              <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#healthCheckupModal">ตรวจร่างกายประจำปี</button>
            </div>
          </div>

          <!-- Health Checkup Modal -->
          <div class="modal fade" id="healthCheckupModal" tabindex="-1" role="dialog" aria-labelledby="healthCheckupModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="healthCheckupModalLabel">กรอกข้อมูลตรวจร่างกายประจำปี</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <!-- Health Checkup Form -->
                  <form action='insert_data/save_health_checkup.php' method="post">
                    

                     <!-- เพิ่ม input field สำหรับ user_id -->
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

                    <!-- เพิ่ม input field สำหรับ name -->
                    <input type="hidden" name="name" value="<?php echo $user['name']; ?>">


                    <div class="form-group">
                      <label for="weight">น้ำหนัก (kg)</label>
                      <input type="text" class="form-control" id="weight" name="weight">
                    </div>
                    <div class="form-group">
                      <label for="height">ส่วนสูง (cm)</label>
                      <input type="text" class="form-control" id="height" name="height">
                    </div>
                    <div class="form-group">
                      <label for="age">อายุ</label>
                      <input type="text" class="form-control" id="age" name="age">
                    </div>
                    <div class="form-group form-check">
                      <input type="checkbox" class="form-check-input" id="chronic_disease" name="chronic_disease">
                      <label class="form-check-label" for="chronic_disease">โรคประจำตัว</label>
                    </div>
                    <div class="form-group">
                      <label for="medical_history">ประวัติการรักษา</label>
                      <textarea class="form-control" id="medical_history" name="medical_history" rows="3"></textarea>
                    </div>
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                  <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
                </form>
              </div>
            </div>
          </div>





          <!-- Cholesterol Check Modal Trigger Button -->
          <div class="row mt-3">
            <div class="col-md-4">
              <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#cholesterolCheckModal">ตรวจระดับคอเลสเตอรอล</button>
            </div>
          </div>

          <!-- Cholesterol Check Modal -->
          <div class="modal fade" id="cholesterolCheckModal" tabindex="-1" role="dialog" aria-labelledby="cholesterolCheckModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="cholesterolCheckModalLabel">กรอกข้อมูลระดับคอเลสเตอรอล</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <!-- Cholesterol Check Form -->
                  <form>
                    <div class="form-group">
                      <label for="total_cholesterol">ระดับคอเลสเตอรอลทั้งหมด (mg/dL)</label>
                      <input type="text" class="form-control" id="total_cholesterol">
                    </div>
                    <div class="form-group">
                      <label for="ldl_cholesterol">ระดับไจไทร (mg/dL)</label>
                      <input type="text" class="form-control" id="ldl_cholesterol">
                    </div>
                    <div class="form-group">
                      <label for="hdl_cholesterol">ระดับไฮไดรนี (mg/dL)</label>
                      <input type="text" class="form-control" id="hdl_cholesterol">
                    </div>
                    <div class="form-group">
                      <label for="triglycerides">ระดับไตรกลีเซรีด (mg/dL)</label>
                      <input type="text" class="form-control" id="triglycerides">
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                  <button type="button" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
              </div>
            </div>
          </div>




           <div class="row mt-3">
            <div class="col-md-4">
              <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#bloodSugarCheckModal">ตรวจระดับน้ำตาลในเลือด</button>
            </div>
          </div>

          <!-- Blood Sugar Check Modal -->
          <div class="modal fade" id="bloodSugarCheckModal" tabindex="-1" role="dialog" aria-labelledby="bloodSugarCheckModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="bloodSugarCheckModalLabel">กรอกข้อมูลระดับน้ำตาลในเลือด</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <!-- Blood Sugar Check Form -->
                  <form id="bloodSugarCheckForm">
                    <div class="form-group">
                      <label for="total_blood_sugar">ระดับน้ำตาลในเลือดทั้งหมด (mg/dL)</label>
                      <input type="text" class="form-control" id="total_blood_sugar">
                    </div>
                    <div class="form-group">
                      <label for="morning_blood_sugar">ระดับน้ำตาลในเลือดตอนเช้า (mg/dL)</label>
                      <input type="text" class="form-control" id="morning_blood_sugar">
                    </div>
                    <div class="form-group">
                      <label for="aftermeal_blood_sugar">ระดับน้ำตาลในเลือดหลังทานอาหาร (mg/dL)</label>
                      <input type="text" class="form-control" id="aftermeal_blood_sugar">
                    </div>
                    <div class="form-group form-check">
                      <input type="checkbox" class="form-check-input" id="diabetes_condition">
                      <label class="form-check-label" for="diabetes_condition">มีภาวะโรคเบาหวาน</label>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                  <button type="button" class="btn btn-primary" onclick="saveBloodSugarCheck()">บันทึกข้อมูล</button>
                </div>
              </div>
            </div>
          </div>







                    <!-- Eye Health Check Modal Trigger Button -->
          <div class="row mt-3">
            <div class="col-md-4">
              <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#eyeHealthCheckModal">ตรวจสุขภาพทางสายตาประจำปี</button>
            </div>
          </div>

          <!-- Eye Health Check Modal -->
          <div class="modal fade" id="eyeHealthCheckModal" tabindex="-1" role="dialog" aria-labelledby="eyeHealthCheckModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="eyeHealthCheckModalLabel">กรอกข้อมูลสุขภาพทางสายตาประจำปี</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <!-- Eye Health Check Form -->
                  <form id="eyeHealthCheckForm">
                    <div class="form-group">
                      <label for="last_eye_exam">ค่าสายตาที่วัดครั้งล่าสุด (diopters)</label>
                      <input type="text" class="form-control" id="last_eye_exam">
                    </div>
                    <div class="form-group">
                      <label for="recent_eye_exam_date">วันที่ทำการตรวจสายตาล่าสุด</label>
                      <input type="date" class="form-control" id="recent_eye_exam_date">
                    </div>
                    <div class="form-group">
                      <label for="current_eye_exam">ค่าสายตาปัจจุบัน (diopters)</label>
                      <input type="text" class="form-control" id="current_eye_exam">
                    </div>
                    <div class="form-group form-check">
                      <input type="checkbox" class="form-check-input" id="wearing_glasses">
                      <label class="form-check-label" for="wearing_glasses">ใส่แว่นสายตาเป็นประจำ</label>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                  <button type="button" class="btn btn-primary" onclick="saveEyeHealthCheck()">บันทึกข้อมูล</button>
                </div>
              </div>
            </div>
          </div>






        <!-- Dental Health Check Modal Trigger Button -->
        <div class="row mt-3">
          <div class="col-md-4">
            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#dentalHealthCheckModal">ตรวจสุขภาพทางทันตกรรมประจำปี</button>
          </div>
        </div>

        <!-- Dental Health Check Modal -->
        <div class="modal fade" id="dentalHealthCheckModal" tabindex="-1" role="dialog" aria-labelledby="dentalHealthCheckModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="dentalHealthCheckModalLabel">กรอกข้อมูลสุขภาพทางทันตกรรมประจำปี</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <!-- Dental Health Check Form -->
                <form id="dentalHealthCheckForm">
                  <div class="form-group">
                    <label for="last_dental_exam_date">ตรวจช่องปากล่าสุดวันที่เท่าไหร่</label>
                    <input type="date" class="form-control" id="last_dental_exam_date">
                  </div>
                  <div class="form-group">
                    <label for="dental_treatment">การรักษาโรคทันตกรรมล(ไม่มีกรอกไม่มี)</label>
                    <input type="text" class="form-control" id="dental_treatment">
                  </div>
                  <div class="form-group">
                    <label for="last_scaling_date">ขูดหินปูนครั้งล่าสุด (วันเดือนปี)</label>
                    <input type="date" class="form-control" id="last_scaling_date">
                  </div>
                  <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="regular_dental_checkup">
                    <label class="form-check-label" for="regular_dental_checkup">มีการตรวจสุขภาพช่องปากทุกๆ 6 เดือน</label>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="saveDentalHealthCheck()">บันทึกข้อมูล</button>
              </div>
            </div>
          </div>
        </div>







          <!-- ... โค้ดอื่น ๆ ... -->

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php
      include './footer.php'
      ?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
