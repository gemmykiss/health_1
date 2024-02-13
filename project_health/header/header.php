<?php
require_once '../config/db.php';
session_start(); // Start session

if (!isset($_SESSION['user'])) {
    // If no user session, redirect to login
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user']; // Use user session data

?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->

  <br>
  </br>
  
    <div ALIGN = "center" class="sidebar-brand-icon rotate-n-0">
      <img class="sidebar-brand-icon rotate-n-0" src="./image/logo.png" width="65">
    </div>
  </a>
  <!-- Nav Item - Dashboard -->
  <li  ALIGN = "center" class="nav-item">
  
    
      <i class="fas fa-warehouse"></i>
      <span>หน้าหลัก</span>
    </a>
  </li>

  

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Interface
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item active">
    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="far fa-list-alt"></i>
      <span>รายละเอียด</span>
    </a>
    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Menu</h6>
        <a class="collapse-item" href="insert_health.php">
          <i class="far fa-plus-square"></i>
          <span>กรอกข้อมูล</span></a>
        <a class="collapse-item" href="insert_health.php">
        <i class="far fa-file-alt"></i>
          <span>รายละเอียด</span></a>
        <a class="collapse-item" href="sum_health.php">
          <i class="fas fa-heart"></i>
          <span>ผลข้อมูลสุขภาพ</span></a>
      </div>
    </div>
  </li>

  <!-- Nav Item - Tables -->
  <li class="nav-item">
    <a class="nav-link" href="./logout.php">
      <i class="fas fa-sign-out-alt"></i>
      <span>Log out</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->