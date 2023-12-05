<?php
date_default_timezone_set('Asia/Manila');
if (!isset($_SESSION['official_username']) && !isset($_SESSION['official_password']) && !isset($_SESSION['official_id'])) {
  header("location:index.php?utm_campaign=expired");
}


if (isset($_GET['lfilter'])) {
  $lstat = $_GET['lfilter'];
  $query = "SELECT * FROM employee_leave WHERE leave_status = '$lstat' ";
  $emp_leave_req = mysqli_query($connection, $query);
} else {
  $query = "SELECT * FROM employee_leave ";
  $emp_leave_req = mysqli_query($connection, $query);
}
