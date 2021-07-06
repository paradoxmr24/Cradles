<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $title; ?></title>
  <link href="libs/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <?php if(isset($style)) { ?>
    <link href="css/<?php echo $style; ?>" rel="stylesheet">
  <?php } ?>
  <?php if(isset($useAngular) && $useAngular) { ?>
    <script src="libs/angularjs/angular.min.js"></script>
  <?php } ?>
  <?php if(isset($js)) { ?>
    <script src="js/<?php echo $js; ?>"></script>
  <?php } ?>  
</head>
<?php if(isset($useAngular) && $useAngular) { ?>
  <body ng-app="myApp" ng-controller="myController">
  <?php } else { ?>
<body id="page-top">
<?php } ?>
<div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Zapid Academy</div>
      </a>

      <hr class="sidebar-divider my-0">
    
      <li class="nav-item"> 
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-home"></i>
          <span>Home</span></a>
      </li>
      <?php if($_SESSION['role'] == 'Teacher') { ?>
      <hr class="sidebar-divider">

      <div class="sidebar-heading">
        Exams
      </div>

      <li class="nav-item">
        <a class="nav-link" href="addexam.php">
          <i class="fas fa-fw fa-folder-plus"></i>
          <span>Add Exam</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="exams.php">
          <i class="fas fa-fw fa-list"></i>
          <span>Exams' List</span></a>
      </li>


      <li class="nav-item">
        <a class="nav-link" href="result.php">
          <i class="fas fa-fw fa-chart-line"></i>
          <span>Result</span></a>
      </li>

      <hr class="sidebar-divider">

      <div class="sidebar-heading">
        Students
      </div>

      <li class="nav-item">
        <a class="nav-link" href="addstudent.php">
          <i class="fas fa-fw fa-user-plus"></i>
          <span>Add Students</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="students.php">
          <i class="fas fa-fw fa-user-graduate"></i>
          <span>Students' List</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="sendnotif.php">
          <i class="fas fa-fw fa-bell"></i>
          <span>Send Notification</span></a>
      </li>
    <?php } ?>
    <?php if($_SESSION['role'] == 'Student') { ?>
      <div class="sidebar-heading">
        Exams
      </div>

      <li class="nav-item">
        <a class="nav-link" href="apply.php">
          <i class="fas fa-fw fa-check-square"></i>
          <span>Apply</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="marks.php">
          <i class="fas fa-fw fa-chart-line"></i>
          <span>Result</span></a>
      </li>
    <?php } ?>
    <?php if($_SESSION['role'] == 'Admin') { ?>
      <div class="sidebar-heading">
        Add Account
      </div>

      <li class="nav-item">
        <a class="nav-link" href="mastersignup.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Sign Up</span></a>
      </li>
    <?php } ?>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>About</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Information Pages</h6>
            <a class="collapse-item" href="privacypolicy.php">Privacy Policy</a>
            <a class="collapse-item" href="disclaimer.php">Discalimer</a>
            <a class="collapse-item" href="termsofuse.php">Terms of Use</a>
          </div>
        </div>
    </li>
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
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
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
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
            <?php
              if($_SESSION['role'] == 'Student') {
              $connect = connectdb($_SESSION['d_name']);
              $cs = $_SESSION['class'] . '-' . $_SESSION['section'];
              $query9 = "SELECT * FROM notification WHERE Reciever = 'All' || Reciever = '$cs'";
              $result9 = mysqli_query($connect,$query9); ?>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter"><?php echo mysqli_num_rows($result9); ?></span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <?php while ($row = mysqli_fetch_assoc($result9)) { ?>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500"><?php echo $row['Sender']; ?></div>
                    <span class="font-weight-bold"><?php echo $row['Message']; ?></span>
                  </div>
                </a>
                <?php } ?>
              </div>
            </li>
                <?php unset($cs);unset($query9);unset($result9); }; ?>
                <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['name']; ?></span>
<i class="fa fa-user-circle" aria-hidden="true"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
              <a class="dropdown-item" href="changepassword.php">
                  <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                  Change Password
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