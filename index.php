<?php
ob_start();
session_start();


include 'inc/config.php';

if(!isset($_SESSION['itnustd'])){
    header('location:login.php');
}

include("connectdb.php");
      $today = date("Y-m-d");

      $year_now = date("Y")+543;
      if($date_shows=='')
      {
      $date_shows=$today;
    }else{

      $date_shows=$date_shows;
    }
  

   $thaiweek=array("วันอาทิตย์","วันจันทร์","วันอังคาร","วันพุธ","วันพฤหัส","วันศุกร์","วันเสาร์");

     $thaimonth=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

     
      


 
  
     
    $strSQL10_klang = "select * from idstudent where room = 'เด็กกลาง' and yearSemester='2566'";
    $objQuery10_klang = mysql_query($strSQL10_klang) or die ("Error Query [".$strSQL10_klang."]");
    $rows_klang=mysql_num_rows($objQuery10_klang);

    
    $strSQL10_toe = "select * from idstudent where room = 'เด็กโต' and yearSemester='2566'";
    $objQuery10_toe = mysql_query($strSQL10_toe) or die ("Error Query [".$strSQL10_toe."]");
    $rows_toe=mysql_num_rows($objQuery10_toe); 


     $strSQL10_tream = "select * from idstudent where room = 'เด็กเตรียม' and yearSemester='2566'";
    $objQuery10_tream = mysql_query($strSQL10_tream) or die ("Error Query [".$strSQL10_tream."]");
    $rows_tream=mysql_num_rows($objQuery10_tream);

    $strSQL10_year_now = "select * from idstudent where yearSemester='2566'";
    $objQuery10_year_now = mysql_query($strSQL10_year_now) or die ("Error Query [".$strSQL10_year_now."]");
    $rows_year_now=mysql_num_rows($objQuery10_year_now);

 

//รวมเด็กเตรียมมาเรียน today
 
$strSQL12_tream = "SELECT count(idstudent.studentID) FROM `ccdCheckFever` 
            inner JOIN `idstudent` on idstudent.studentID = ccdCheckFever.studentID 
            WHERE idstudent.yearSemester = '2566' and idstudent.room = 'เด็กเตรียม' and ccdCheckFever.ccdCheckDate='$date_shows'and ccdCheckFever.ccdCheckTime<'11.00.00'and ccdCheckFever.ccdCheckStatus='1';";
$objQuery12_tream = mysql_query($strSQL12_tream) or die ("Error Query [".$strSQL12_tream."]");
$objQuery12_tream= mysql_fetch_array($objQuery12_tream);



//รวมเด็กโตมาเรียน today
$strSQL12 = "SELECT count(idstudent.studentID) FROM `ccdCheckFever` 
            inner JOIN `idstudent` on idstudent.studentID = ccdCheckFever.studentID 
            WHERE idstudent.yearSemester = '2566' and idstudent.room = 'เด็กโต' and ccdCheckFever.ccdCheckDate='$date_shows'and ccdCheckFever.ccdCheckTime<'11.00.00'and ccdCheckFever.ccdCheckStatus='1';";
$objQuery12 = mysql_query($strSQL12) or die ("Error Query [".$strSQL12."]");
$objQuery12= mysql_fetch_array($objQuery12);



//รวมเด็กกลางมาเรียน today
$strSQL13 = "SELECT count(idstudent.studentID) FROM `ccdCheckFever` 
            inner JOIN `idstudent` on idstudent.studentID = ccdCheckFever.studentID 
            WHERE idstudent.yearSemester = '2566' and idstudent.room = 'เด็กกลาง' and ccdCheckFever.ccdCheckDate='$date_shows'and ccdCheckFever.ccdCheckTime<'11.00.00'and ccdCheckFever.ccdCheckStatus='1';";
$objQuery13 = mysql_query($strSQL13) or die ("Error Query [".$strSQL13."]");
$objQuery13= mysql_fetch_array($objQuery13);




//รวมเด็กมาเรียน today
$strSQL14 = "SELECT count(idstudent.studentID) FROM `ccdCheckFever` 
            inner JOIN `idstudent` on idstudent.studentID = ccdCheckFever.studentID 
            WHERE idstudent.yearSemester = '2566' and ccdCheckFever.ccdCheckDate='$date_shows'and ccdCheckFever.ccdCheckTime<'11.00.00'and ccdCheckFever.ccdCheckStatus='1';";
$objQuery14 = mysql_query($strSQL14) or die ("Error Query [".$strSQL14."]");
$objQuery14= mysql_fetch_array($objQuery14);
    
    
     
// อาการที่ปรากฎ

// อุณหภูมิมากว่า 37.5
    $strSQL_t_temp = "select * from ccdCheckFever where ccdCheckDate='$today' AND ccdCheckTemp >='37.5'";
    $objQuery_t_temp = mysql_query($strSQL_t_temp) or die ("Error Query [".$strSQL_t_temp."]");
    $rows_t_temp_date_now=mysql_num_rows($objQuery_t_temp);


// มีน้ำมูก
    $strSQL_t1 = "select * from ccdCheckFever where ccdCheckDate='$today' AND value11='1'";
    $objQuery_t1 = mysql_query($strSQL_t1) or die ("Error Query [".$strSQL_t1."]");
    $rows_t1_date_now=mysql_num_rows($objQuery_t1);
// แผลร้อนใน
    $strSQL_t2 = "select * from ccdCheckFever where ccdCheckDate='$today' AND value12='1'";
    $objQuery_t2 = mysql_query($strSQL_t2) or die ("Error Query [".$strSQL_t2."]");
    $rows_t2_date_now=mysql_num_rows($objQuery_t2);
// คอแดง
    $strSQL_t3 = "select * from ccdCheckFever where ccdCheckDate='$today' AND value13='1'";
    $objQuery_t3 = mysql_query($strSQL_t3) or die ("Error Query [".$strSQL_t3."]");
    $rows_t3_date_now=mysql_num_rows($objQuery_t3);
// ไอ
    $strSQL_t4 = "select * from ccdCheckFever where ccdCheckDate='$today' AND value14='1'";
    $objQuery_t4 = mysql_query($strSQL_t4) or die ("Error Query [".$strSQL_t4."]");
    $rows_t4_date_now=mysql_num_rows($objQuery_t4);
// จุดแดงฝ่ามือ/ฝ่าเท้า
    $strSQL_t5 = "select * from ccdCheckFever where ccdCheckDate='$today' AND value15='1'";
    $objQuery_t5 = mysql_query($strSQL_t5) or die ("Error Query [".$strSQL_t5."]");
    $rows_t5_date_now=mysql_num_rows($objQuery_t5);
// ผื่นตามร่างกาย
    $strSQL_t6 = "select * from ccdCheckFever where ccdCheckDate='$today' AND value16='1'";
    $objQuery_t6 = mysql_query($strSQL_t6) or die ("Error Query [".$strSQL_t6."]");
    $rows_t6_date_now=mysql_num_rows($objQuery_t6);
// ตาแดง/ตาแฉะ
    $strSQL_t7 = "select * from ccdCheckFever where ccdCheckDate='$today' AND value17='1'";
    $objQuery_t7 = mysql_query($strSQL_t7) or die ("Error Query [".$strSQL_t7."]");
    $rows_t7_date_now=mysql_num_rows($objQuery_t7);

// อุจจาระร่วง
    $strSQL_t8 = "select * from ccdCheckFever where ccdCheckDate='$today' AND value18='1'";
    $objQuery_t8 = mysql_query($strSQL_t8) or die ("Error Query [".$strSQL_t8."]");
    $rows_t8_date_now=mysql_num_rows($objQuery_t8);

// อุจจาระร่วง
    $strSQL_t21 = "select * from ccdCheckFever where ccdCheckDate='$today' AND value21='1'";
    $objQuery_t21 = mysql_query($strSQL_t21) or die ("Error Query [".$strSQL_t21."]");
    $rows_t21_date_now=mysql_num_rows($objQuery_t21);

// อุจจาระร่วง
    $strSQL_t22 = "select * from ccdCheckFever where ccdCheckDate='$today' AND value22='1'";
    $objQuery_t22 = mysql_query($strSQL_t22) or die ("Error Query [".$strSQL_t22."]");
    $rows_t22_date_now=mysql_num_rows($objQuery_t22);

// อุจจาระร่วง
    $strSQL_t23 = "select * from ccdCheckFever where ccdCheckDate='$today' AND value23='1'";
    $objQuery_t23 = mysql_query($strSQL_t23) or die ("Error Query [".$strSQL_t23."]");
    $rows_t23_date_now=mysql_num_rows($objQuery_t23);


// อุจจาระร่วง
    $strSQL_t24 = "select * from ccdCheckFever where ccdCheckDate='$today' AND value24='1'";
    $objQuery_t24 = mysql_query($strSQL_t24) or die ("Error Query [".$strSQL_t24."]");
    $rows_t24_date_now=mysql_num_rows($objQuery_t24);

// รวมทั้งหมด
    $strSQL_t9 = "select * from ccdCheckFever where ccdCheckDate='$today'";
    $objQuery_t9 = mysql_query($strSQL_t9) or die ("Error Query [".$strSQL_t9."]");
    $rows_t9_date_now=mysql_num_rows($objQuery_t9);


 
  

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?echo $title;?></title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Daycare Admin <sup>1.2</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

    
<? include 'sidebar.php'?>
    

      <!-- Nav Item - Utilities Collapse Menu -->
      <!---
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Utilities:</h6>
            <a class="collapse-item" href="utilities-color.html">Colors</a>
            <a class="collapse-item" href="utilities-border.html">Borders</a>
            <a class="collapse-item" href="utilities-animation.html">Animations</a>
            <a class="collapse-item" href="utilities-other.html">Other</a>
          </div>
        </div>
      </li>
-->
      <!-- Divider -->
<!-- Heading -->
      <!--
      <hr class="sidebar-divider">

      
      <div class="sidebar-heading">
        Addons
      </div>
    -->

      <!-- Nav Item - Pages Collapse Menu -->
      <!--
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Login Screens:</h6>
            <a class="collapse-item" href="login.html">Login</a>
            <a class="collapse-item" href="register.html">Register</a>
            <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Pages:</h6>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>
          </div>
        </div>
      </li>
    -->

      <!-- Nav Item - Charts -->
      <!--
      <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>
    -->

      <!-- Nav Item - Tables -->
      <!--
      <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li>
    -->

      <!-- Divider -->
     <!--  <hr class="sidebar-divider d-none d-md-block"> -->

      <!-- Sidebar Toggler (Sidebar) -->

      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

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

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><? echo $_SESSION['fullname']."&nbsp;:&nbsp;".$_SESSION['loginUsername']; ?></span>
                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">ผลการตรวจคัดกรอง <?echo $room;?> ประจำวันที่ <?echo $thaiweek[date("w")] ,"ที่",date(" j "), $thaimonth[date(" m ")-1] , " พ.ศ. ",date(" Y ")+543;?> </h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div>
 
 

 

  <!-- Content Row -->
  <!--        
          <div class="row">





 
  <div class="col-xl-4 col-md-4 mb-4">
   
            </div>






            
            <div class="col-xl-4 col-md-4 mb-4">
             
            </div>

           
            <div class="col-xl-4 col-md-4 mb-4">
            
            </div>


          </div>
-->




          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">เด็กกลาง</div>
                     <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $objQuery13[0];?> / <?=$rows_klang;?> คน</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?=($objQuery13[0]/$rows_klang)*100;?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-child fa-2x text-gray-300"></i>


                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">


                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">เด็กโต</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $objQuery12[0];?> / <?=$rows_toe;?> คน</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?=($objQuery12[0]/$rows_toe)*100;?>%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="0"></div>
                          </div>
                        </div>
                      </div>






                    </div>
                    <div class="col-auto">
                      <i class="fas fa-child fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">


                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">เด็กเตรียม</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$objQuery12_tream[0];?> / <?=$rows_tream;?> คน</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?=($objQuery12_tream[0]/$rows_tream)*100;?>%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-child fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">รวมทั้งหมด</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $objQuery14[0];?> / <?=$rows_year_now;?> คน</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?=($objQuery14[0]/$rows_year_now)*100;?>%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>





                    </div>
                    <div class="col-auto">
                      <i class="fas fa-child fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

 











          <!-- Content Row -->
          <div class="row">

            <!-- Content Column -->
            <div class="col-lg-6 mb-4">

              <!-- Project Card Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">อาการที่ปรากฎ คัดกรองทั้งหมด <?=$rows_t9_date_now;?>  คน</h6>
                </div>
                <div class="card-body">




                  <h4 class="small font-weight-bold">อุณหภูมิมากว่า 37.5 <?=$rows_t_temp_date_now;?><span class="float-right"><?=number_format ((($rows_t_temp_date_now/$objQuery14[0])*100),2);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?=number_format ((($rows_t_temp_date_now/$objQuery14[0])*100),2);?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>

                  <h4 class="small font-weight-bold">ความเสี่ยงผู้ปกครอง (ต่ำ) <?=$rows_t1_date_now;?><span class="float-right"><?=number_format ((($rows_t1_date_now/$objQuery14[0])*100),2);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?=number_format ((($rows_t1_date_now/$objQuery14[0])*100),2);?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>

                  <h4 class="small font-weight-bold">ความเสี่ยงผู้ปกครอง (ปานกลาง) <?=$rows_t2_date_now;?><span class="float-right"><?=number_format ((($rows_t2_date_now/$objQuery14[0])*100),2);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?=number_format ((($rows_t2_date_now/$objQuery14[0])*100),2);?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>

                  <h4 class="small font-weight-bold">ความเสี่ยงผู้ปกครอง (สูง) <?=$rows_t3_date_now;?><span class="float-right"><?=number_format ((($rows_t3_date_now/$objQuery14[0])*100),2);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?=number_format ((($rows_t3_date_now/$objQuery14[0])*100),2);?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>



  
                  <h4 class="small font-weight-bold">คอแดง <?=$rows_t4_date_now;?><span class="float-right"><?=number_format ((($rows_t4_date_now/$objQuery14[0])*100),2);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?=number_format ((($rows_t4_date_now/$objQuery14[0])*100),2);?>%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>


                  <h4 class="small font-weight-bold">มีแผลร้อนใน <?=$rows_t5_date_now;?><span class="float-right"><?=number_format ((($rows_t5_date_now/$objQuery14[0])*100),2);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?=number_format ((($rows_t5_date_now/$objQuery14[0])*100),2);?>%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>




                  <h4 class="small font-weight-bold">มีน้ำมูก <?=$rows_t7_date_now;?><span class="float-right"><?=number_format ((($rows_t7_date_now/$objQuery14[0])*100),2);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: <?=number_format ((($rows_t7_date_now/$objQuery14[0])*100),2);?>%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">ไอ <?=$rows_t8_date_now;?><span class="float-right"><?=number_format ((($rows_t8_date_now/$objQuery14[0])*100),2);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?=number_format ((($rows_t8_date_now/$objQuery14[0])*100),2);?>%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">ตาแดง / ตาแฉะ <?=$rows_t21_date_now;?><span class="float-right"><?=number_format ((($rows_t21_date_now/$objQuery14[0])*100),2);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?=number_format ((($rows_t21_date_now/$objQuery14[0])*100),2);?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">มีจุดแดงที่ฝ่ามือหรือฝ่าเท้า <?=$rows_t22_date_now;?><span class="float-right"><?=number_format ((($rows_t22_date_now/$objQuery14[0])*100),2);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?=number_format ((($rows_t22_date_now/$objQuery14[0])*100),2);?>%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">มีผื่นตามร่างกายคล้ายโรคหัดหรือสุกใส <?=$rows_t23_date_now;?><span class="float-right"><?=number_format ((($rows_t23_date_now/$objQuery14[0])*100),2);?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: <?=number_format ((($rows_t23_date_now/$objQuery14[0])*100),2);?>%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                   

                   
                </div>
              </div>

              
        </div>





            <div class="col-lg-6 mb-4">





                
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">อาการที่ปรากฎแยกเป็นชั้นเรียน เด็กกลาง</h6>
                </div>
                <div class="card-body">
                  <div class="text-center">
                   <div class="row">


<div class="col-lg-6 mb-4">
                  <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                      



 

 







                    </div>
                  </div>
                </div>






                <div class="col-lg-6 mb-4">
                  <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                      เด็กกลาง
                      <div class="text-white-50 small">
<?php
$strSQL_klang1_today = "SELECT count(idstudent.studentID) FROM `ccdCheckValue` 
            inner JOIN `idstudent` on idstudent.studentID = ccdCheckValue.studentID 
            WHERE idstudent.room LIKE '%เด็กกลาง%' and ccdCheckValue.ccdCheckDate='$date_shows'and (value1='1' or value2='1' or value3='1' or value4='1' or value5='1' or value6='1' or value7='1' or value8='1');";
$objQuery_klang1_today = mysql_query($strSQL_klang1_today) or die ("Error Query [".$strSQL_klang1_today."]");
$objQuery_klang1_today= mysql_fetch_array($objQuery_klang1_today);


echo $objQuery_klang1_today[0];
?>
                      </div>
                    </div>
                  </div>
                </div>
                 
                 
 

               
              
            </div>
        </div>




      </div>
   </div>





              <!-- เด็กโต  -->
               
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">อาการที่ปรากฎแยกเป็นชั้นเรียน เด็กโต</h6>
                </div>
                <div class="card-body">
                  
                 
                  <div class="text-center">
                   <div class="row">
                <div class="col-lg-6 mb-4">
                  <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                      เด็กโต 1
                      <div class="text-white-50 small">
<?php
$strSQL_toe1_today = "SELECT count(idstudent.studentID) FROM `ccdCheckValue` 
            inner JOIN `idstudent` on idstudent.studentID = ccdCheckValue.studentID 
            WHERE idstudent.room LIKE '%โต1%' and ccdCheckValue.ccdCheckDate='$date_shows'and ccdCheckValue.ccdCheckTime<'11.00.00' and (value1='1' or value2='1' or value3='1' or value4='1' or value5='1' or value6='1' or value7='1' or value8='1');";
$objQuery_toe1_today = mysql_query($strSQL_toe1_today) or die ("Error Query [".$strSQL_toe1_today."]");
$objQuery_toe1_today= mysql_fetch_array($objQuery_toe1_today);


echo $objQuery_toe1_today[0];
?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-4">
                  <div class="card bg-success text-white shadow">
                    <div class="card-body">
                      เด็กโต 2
                      <div class="text-white-50 small">
<?php
$strSQL_toe2_today = "SELECT count(idstudent.studentID) FROM `ccdCheckValue` 
            inner JOIN `idstudent` on idstudent.studentID = ccdCheckValue.studentID 
            WHERE idstudent.room LIKE '%โต2%' and ccdCheckValue.ccdCheckDate='$date_shows'and ccdCheckValue.ccdCheckTime<'11.00.00' and (value1='1' or value2='1' or value3='1' or value4='1' or value5='1' or value6='1' or value7='1' or value8='1');";
$objQuery_toe2_today = mysql_query($strSQL_toe2_today) or die ("Error Query [".$strSQL_toe2_today."]");
$objQuery_toe2_today= mysql_fetch_array($objQuery_toe2_today);


echo $objQuery_toe2_today[0];
?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-4">
                  <div class="card bg-info text-white shadow">
                    <div class="card-body">
                      เด็กโต 3
                      <div class="text-white-50 small">
<?php
$strSQL_toe3_today = "SELECT count(idstudent.studentID) FROM `ccdCheckValue` 
            inner JOIN `idstudent` on idstudent.studentID = ccdCheckValue.studentID 
            WHERE idstudent.room LIKE '%โต3%' and ccdCheckValue.ccdCheckDate='$date_shows'and ccdCheckValue.ccdCheckTime<'11.00.00' and (value1='1' or value2='1' or value3='1' or value4='1' or value5='1' or value6='1' or value7='1' or value8='1');";
$objQuery_toe3_today = mysql_query($strSQL_toe3_today) or die ("Error Query [".$strSQL_toe3_today."]");
$objQuery_toe3_today= mysql_fetch_array($objQuery_toe3_today);


echo $objQuery_toe3_today[0];
?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-4">
                  <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                      เด็กโต 4
                      <div class="text-white-50 small">
<?php
$strSQL_toe4_today = "SELECT count(idstudent.studentID) FROM `ccdCheckValue` 
            inner JOIN `idstudent` on idstudent.studentID = ccdCheckValue.studentID 
            WHERE idstudent.room LIKE '%โต4%' and ccdCheckValue.ccdCheckDate='$date_shows'and ccdCheckValue.ccdCheckTime<'11.00.00' and (value1='1' or value2='1' or value3='1' or value4='1' or value5='1' or value6='1' or value7='1' or value8='1');";
$objQuery_toe4_today = mysql_query($strSQL_toe4_today) or die ("Error Query [".$strSQL_toe4_today."]");
$objQuery_toe4_today= mysql_fetch_array($objQuery_toe4_today);


echo $objQuery_toe4_today[0];
?>
                      </div>
                    </div>
                  </div>
                </div>
                 <div class="col-lg-6 mb-4">
                  <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                      เด็กโต 5
                      <div class="text-white-50 small">
<?php
$strSQL_toe5_today = "SELECT count(idstudent.studentID) FROM `ccdCheckValue` 
            inner JOIN `idstudent` on idstudent.studentID = ccdCheckValue.studentID 
            WHERE idstudent.room LIKE '%โต5%' and ccdCheckValue.ccdCheckDate='$date_shows'and ccdCheckValue.ccdCheckTime<'11.00.00' and (value1='1' or value2='1' or value3='1' or value4='1' or value5='1' or value6='1' or value7='1' or value8='1');";
$objQuery_toe5_today = mysql_query($strSQL_toe5_today) or die ("Error Query [".$strSQL_toe5_today."]");
$objQuery_toe5_today= mysql_fetch_array($objQuery_toe5_today);


echo $objQuery_toe5_today[0];
?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-4">
                  <div class="card bg-secondary text-white shadow">
                    <div class="card-body">
                      เด็กโต 6
                      <div class="text-white-50 small">
<?php
$strSQL_toe6_today = "SELECT count(idstudent.studentID) FROM `ccdCheckValue` 
            inner JOIN `idstudent` on idstudent.studentID = ccdCheckValue.studentID 
            WHERE idstudent.room LIKE '%โต6%' and ccdCheckValue.ccdCheckDate='$date_shows'and ccdCheckValue.ccdCheckTime<'11.00.00' and (value1='1' or value2='1' or value3='1' or value4='1' or value5='1' or value6='1' or value7='1' or value8='1');";
$objQuery_toe6_today = mysql_query($strSQL_toe6_today) or die ("Error Query [".$strSQL_toe6_today."]");
$objQuery_toe6_today= mysql_fetch_array($objQuery_toe6_today);
echo $objQuery_toe6_today[0];
?>
                      </div>
                    </div>
                  </div>
                </div>
                 </div>
              </div>
            
         </div>
       </div>
             

              <!-- เด็กเตรียม  -->
               
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">อาการที่ปรากฎแยกเป็นชั้นเรียน เด็กเตรียม</h6>
                </div>
                
                  
                <div class="card-body">
                  <div class="text-center">
                   <div class="row">
                <div class="col-lg-6 mb-4">
                  <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                      เด็กเตรียม 1
                      <div class="text-white-50 small">
<?php
$strSQL_tream1_today = "SELECT count(idstudent.studentID) FROM `ccdCheckValue` 
            inner JOIN `idstudent` on idstudent.studentID = ccdCheckValue.studentID 
            WHERE idstudent.room LIKE '%เตรียม1%' and ccdCheckValue.ccdCheckDate='$date_shows'and ccdCheckValue.ccdCheckTime<'11.00.00' and (value1='1' or value2='1' or value3='1' or value4='1' or value5='1' or value6='1' or value7='1' or value8='1');";
$objQuery_tream1_today = mysql_query($strSQL_tream1_today) or die ("Error Query [".$strSQL_tream1_today."]");
$objQuery_tream1_today= mysql_fetch_array($objQuery_tream1_today);


echo $objQuery_tream1_today[0];
?>






                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-4">
                  <div class="card bg-success text-white shadow">
                    <div class="card-body">
                      เด็กเตรียม 2
                      <div class="text-white-50 small">
<?php
$strSQL_tream2_today = "SELECT count(idstudent.studentID) FROM `ccdCheckValue` 
            inner JOIN `idstudent` on idstudent.studentID = ccdCheckValue.studentID 
            WHERE idstudent.room LIKE '%เตรียม2%' and ccdCheckValue.ccdCheckDate='$date_shows'and ccdCheckValue.ccdCheckTime<'11.00.00' and (value1='1' or value2='1' or value3='1' or value4='1' or value5='1' or value6='1' or value7='1' or value8='1');";
$objQuery_tream2_today = mysql_query($strSQL_tream2_today) or die ("Error Query [".$strSQL_tream2_today."]");
$objQuery_tream2_today= mysql_fetch_array($objQuery_tream2_today);


echo $objQuery_tream2_today[0];
?>
                      </div>
                    </div>
                  </div>
                </div>

               <div class="col-lg-6 mb-4">
                  <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                      เด็กเตรียม 3
                      <div class="text-white-50 small">
<?php
$strSQL_tream3_today = "SELECT count(idstudent.studentID) FROM `ccdCheckValue` 
            inner JOIN `idstudent` on idstudent.studentID = ccdCheckValue.studentID 
            WHERE idstudent.room LIKE '%เตรียม3%' and ccdCheckValue.ccdCheckDate='$date_shows'and ccdCheckValue.ccdCheckTime<'11.00.00' and (value1='1' or value2='1' or value3='1' or value4='1' or value5='1' or value6='1' or value7='1' or value8='1');";
$objQuery_tream3_today = mysql_query($strSQL_tream3_today) or die ("Error Query [".$strSQL_tream3_today."]");
$objQuery_tream3_today= mysql_fetch_array($objQuery_tream3_today);


echo $objQuery_tream3_today[0];
?>
                      </div>
                    </div>
                  </div>
                </div>

                 </div>
          
            </div>
         </div>
       </div>




            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Infomation Technology Faculty of Nursing KKU 2020.</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
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
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>
  <script src="https://code.iconify.design/1/1.0.6/iconify.min.js"></script>

</body>

</html>
<?php
ob_end_flush();
?>