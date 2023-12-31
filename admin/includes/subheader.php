<?php
date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['official_username']) && !isset($_SESSION['official_password']) && !isset($_SESSION['official_id'])) {
  header("location:index.php?utm_campaign=expired");
}

$model = new Dashboard();
$password = $_SESSION['official_password'];
$username = $_SESSION['official_username'];
$uid = $_SESSION['official_id'];

$connection = $model->TemporaryConnection();

$query = $model->GetAdministrator($username, $password);
$admin = mysqli_fetch_assoc($query);
$id = $admin['id'];
$firstname = $admin['firstname'];
$lastname = $admin['lastname'];
$photo = $admin['photo'];
$create = $admin['created_on'];
$type = $admin['type'];
?>


<?php


$date = date("Y-m-d");
if ($type == "Administrator") {
  /*  <li class="nav-item dropdown">
    <a href="scheduling.php" class="nav-link"><i class="fe fe-flag"></i> Employee Schedule</a>
  </li>
  
   <a href="schedule.php" class="dropdown-item ">Schedule</a>
   
     <li class="nav-item">
    <a href="attendance.php?filter=' . $date . '" class="nav-link"><i class="fe fe-calendar"></i> Attendance</a>
  </li>*/
  echo ('<ul class="nav nav-tabs border-0 flex-column flex-lg-row">
  <li class="nav-item">
    <a href="index.php" class="nav-link"><i class="fe fe-home"></i> Payroll</a>
  </li>

  <li class="nav-item">
  <a href="attendance.php?filter=' . $date . '" class="nav-link"><i class="fe fe-calendar"></i> Attendance</a>
</li>


  <li class="nav-item">
    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-users"></i> Employees</a>
    <div class="dropdown-menu dropdown-menu-arrow">
      <a href="overtime.php" class="dropdown-item ">Overtime</a>
      <a href="advance.php" class="dropdown-item ">Cash Advance</a>
      <a href="loan.php" class="dropdown-item ">Cash Loan</a>
     
    </div>
  </li>
  <li class="nav-item dropdown">
    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-user"></i> Profiling</a>
    <div class="dropdown-menu dropdown-menu-arrow">
      <a href="profile.php" class="dropdown-item ">Employee Profile</a>
    </div>
  <li class="nav-item">
    <a href="position.php" class="nav-link"><i class="fe fe-list"></i> Positions</a>
  </li>

 
</ul>');
} elseif ($type == "Human Resources") {

  echo ('<ul class="nav nav-tabs border-0 flex-column flex-lg-row">
  <li class="nav-item">
    <a href="index.php" class="nav-link"><i class="fe fe-home"></i> Payroll</a>
  </li>
  <li class="nav-item dropdown">
    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-user"></i> Profiling</a>
    <div class="dropdown-menu dropdown-menu-arrow">
      <a href="profile.php" class="dropdown-item ">Employee Profile</a>
    </div>
    <li class="nav-item dropdown">
    <a href="leave.php" class="nav-link"><i class="fa fa-calendar-minus-o"></i> Employee Leave</a>
  </li>

</ul>');
} elseif ($type == "Team Leader") {

  echo ('
  <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
  
  <li class="nav-item">
    <a href="attendance.php?filter=' . date("Y-m-d") . '" class="nav-link"><i class="fe fe-calendar"></i> Attendance</a>
  </li>

</ul>');
}

?>

