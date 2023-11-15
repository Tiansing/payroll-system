<?php

require_once('includes/script.php');
require_once('session/Login.php');

$model = new Dashboard();
$session = new AdministratorSession();
$session->LoginSession();
date_default_timezone_set('Asia/Manila');
date_default_timezone_get();

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
$to = date('Y-m-d');
$from = date('Y-m-d', strtotime('-14 day', strtotime($to)));

$id = $_GET['id'];

$select = "SELECT `id` FROM `employees` WHERE `employee_id` = '$id';";
$thisQuery = mysqli_query($connection, $select);
$row = mysqli_fetch_assoc($thisQuery);


$number = '';
for ($i = 0; $i < 10; $i++) {
  $number .= $i;
}

$number = substr(str_shuffle($number), 0, 9);

$myId = $row['id'];
$taxDed = 0; // Initialize the PHP variable

if (isset($_POST["isChecked"])) {
  $isChecked = $_POST["isChecked"];

  // Update a PHP session variable (you can also update a database variable here)
  $_SESSION["taxDeduct"] = $isChecked;
}
?>
<!doctype html>
<html lang="en" dir="ltr">

<head>
  <title>Profiling and Payroll Management System</title>
  <style>
    .toggle {
      --width: 120px;
      --height: calc(var(--width) / 4);

      position: relative;
      display: inline-block;
      width: var(--width);
      height: var(--height);
      box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
      border-radius: var(--height);
      cursor: pointer;
    }

    .toggle input {
      display: none;
    }

    .toggle .slider {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border-radius: var(--height);
      background-color: #ccc;
      transition: all 0.4s ease-in-out;
    }

    .toggle .slider::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: calc(var(--height));
      height: calc(var(--height));
      border-radius: calc(var(--height) / 2);
      background-color: #fff;
      box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
      transition: all 0.4s ease-in-out;
    }

    .toggle input:checked+.slider {
      background-color: #2196F3;
    }

    .toggle input:checked+.slider::before {
      transform: translateX(calc(var(--width) - var(--height)));
    }

    .toggle .labels {
      position: absolute;
      top: 8px;
      left: 0;
      width: 100%;
      height: 100%;
      font-size: 12px;
      font-family: sans-serif;
      transition: all 0.4s ease-in-out;
    }

    .toggle .labels::after {
      content: attr(data-off);
      position: absolute;
      right: 5px;
      color: #4d4d4d;
      opacity: 1;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);
      transition: all 0.4s ease-in-out;
    }

    .toggle .labels::before {
      content: attr(data-on);
      position: absolute;
      left: 5px;
      color: #ffffff;
      opacity: 0;
      text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.4);
      transition: all 0.4s ease-in-out;
    }

    .toggle input:checked~.labels::after {
      opacity: 0;
    }

    .toggle input:checked~.labels::before {
      opacity: 1;
    }

    @media print {
      #printLabel {
        display: none;
      }
    }
  </style>
</head>

<body class="">
  <div class="page" id="app">
    <div class="page-main">
      <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
        <div class="container">
          <div class="row align-items-center">
            <div class="d-flex">
              <?php require_once('includes/header.php') ?>
            </div>
            <div class="col-lg order-lg-first">
              <?php require_once('includes/subheader.php') ?>
            </div>
          </div>
        </div>
      </div>
      <div class="my-3 my-md-5">
        <div class="container">
          <div class="page-header">
            <h1 class="page-title">
              <a href="home.php" class="text-primary">Dashboard</a> <i style="font-size: 20px;" class="fe fe-chevron-right"></i> Payslip
            </h1>
          </div>

          <div style="padding-left: 0; padding-bottom: 25px;" class="dropdown">
            <button type="button" class="btn btn-secondary  " onclick="printPage()">
              <i class="fe fe-printer mr-2"></i> Print Payslip
            </button>

            <div class="dropdown-menu">
            </div>

          </div>

          <div class="row row-cards">

            <?php require_once('modals/modal_filter_date.php') ?>

            <script type="text/javascript">
              function printPage() {
                var printLabel = document.getElementById("printLabel");
                printLabel.classList.add("hide-for-print");
                var divElements = document.getElementById('printDataHolder').innerHTML;
                var oldPage = document.body.innerHTML;
                document.body.innerHTML = "<link rel='stylesheet' href='css/common.css' type='text/css' /><body class='bodytext'><div class='padding'><b style='font-size: 16px;'><p class=''>Payslip generated on <?php echo date("m/d/Y") ?> <?php echo date("G:i A") ?> by <?php echo $firstname ?> <?php echo $lastname ?></p></b></div>" + divElements + "</body>";
                window.print();


                // Remove the CSS class after printing
                printLabel.classList.remove("hide-for-print");
                document.body.innerHTML = oldPage;

                // Get the checkbox element
                var checkbox = document.getElementById("toggleDeduct");

                // Get the table row element
                var deductionRow = document.getElementById("taxDeductions");

                // Try to load the checkbox state from local storage
                var isChecked = localStorage.getItem("isChecked");

                // If a previous state was stored, update the checkbox state
                if (isChecked === "true") {
                  checkbox.checked = true;
                  deductionRow.style.display = "table-row";
                } else {
                  deductionRow.style.display = "none";
                }
                // Add a change event listener to the checkbox
                checkbox.addEventListener("change", function() {
                  var isChecked = checkbox.checked;
                  // Check if the checkbox is checked



                  if (checkbox.checked) {
                    // Show the row

                    // Update the state in local storage
                    localStorage.setItem("isChecked", isChecked);
                    // Send an AJAX request to the server to update the PHP variable
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "payslip.php", true);

                    // Set the request header
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    // Define the data to send to the server
                    var data = "isChecked=" + isChecked;

                    // Define the callback function when the request is complete
                    xhr.onreadystatechange = function() {
                      if (xhr.readyState === 4 && xhr.status === 200) {
                        // Request is complete
                        // Reload the page to reflect the updated PHP variable
                        location.reload();
                      }
                    };

                    // Send the request with the data
                    xhr.send(data);

                  } else {

                    // Hide the row

                    // Update the state in local storage
                    localStorage.setItem("isChecked", isChecked);
                    // Send an AJAX request to the server to update the PHP variable
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "payslip.php", true);

                    // Set the request header
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    // Define the data to send to the server
                    var data = "isChecked=" + isChecked;

                    // Define the callback function when the request is complete
                    xhr.onreadystatechange = function() {
                      if (xhr.readyState === 4 && xhr.status === 200) {
                        // Request is complete
                        // Reload the page to reflect the updated PHP variable
                        location.reload();
                      }
                    };

                    // Send the request with the data
                    xhr.send(data);
                  }


                });

              }
            </script>
            <div class="col-12" id="printDataHolder">

              <label class="toggle" id="printLabel">
                <input type="checkbox" id="toggleDeduct">
                <span class="slider"></span>
                <span class="labels" data-on="Deduction ON" data-off="Deduction OFF"></span>
              </label>
              <div class="card">
                <?php
                // Calculating the payroll from SAT - FRI (7 Days)
                $leave_query = "SELECT SUM(days_of_leave) AS total_days_leave FROM employee_leave WHERE eid = $myId  AND date_of_leave BETWEEN '$from' AND '$to' AND leave_status = 'Approved' AND type_of_leave= 'vacation'";
                $emp_leave_query = mysqli_query($connection, $leave_query);
                while ($lrow = mysqli_fetch_assoc($emp_leave_query)) {

                  if ($lrow['total_days_leave'] > 5) {
                    $daysOfLeave = 5;
                  } else {
                    $daysOfLeave = $lrow['total_days_leave'];
                  }
                }

                $sql = "SELECT *, SUM(num_hr_morning) AS morning, SUM(num_hr_afternoon) AS afternoon, SUM(num_hr_graveyard) AS graveyard, attendance.employee_id AS empid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id WHERE attendance.employee_id='$myId' AND date BETWEEN '$from' AND '$to' GROUP BY attendance.employee_id ORDER BY employees.fullname ASC";

                $overtime = "SELECT *, SUM(hours) AS hour, SUM(rate_hour) AS rate_h, COUNT(employee_id) AS tot  FROM overtime WHERE overtime.employee_id='$myId' AND ot_status = 1 AND date_overtime BETWEEN '$from' AND '$to';";
                $otresult = mysqli_query($connection, $overtime);

                while ($otrow = mysqli_fetch_assoc($otresult)) {

                  $ot = 0;
                  //$total = ($otrow['tot']) * 8;

                  $total_ot = $otrow['tot'];
                  if ($total_ot == 0) {
                    $total_ot = 1;
                  }

                  if ($otrow['tot'] == 0) {
                    $total = 8;
                  } else {
                    $total = ($otrow['tot']) * 8;
                  }
                  $gross = number_format($otrow['rate_h']) * 1.25 / 8;
                  $gross = $gross * round($otrow['hour'], 1);

                  $ot = $gross;
                  // echo $ot." ";

                }



                $sqlPayroll = mysqli_query($connection, $sql);
                $total = 0;

                $numbers = 0;

                while ($row = mysqli_fetch_assoc($sqlPayroll)) {

                  $numbers++;

                  $employee_id = $row['empid'];
                  $libtotal = $daysOfLeave * 8;
                  $libtotal1 = $row['rate'] * $daysOfLeave;

                  //LATE ATTENDANCE
                  $lateAtt = "SELECT *, SUM(late_duration) AS attLate FROM attendance WHERE employee_id='$employee_id' AND date BETWEEN '$from' AND '$to'";

                  $lateAttquery = mysqli_query($connection, $lateAtt);
                  $attrow = mysqli_fetch_assoc($lateAttquery);

                  $lates = $attrow['attLate'];
                  $decimalValue = $lates; // Replace with your desired decimal value
                  $hours = floor($decimalValue); // Extract the whole hours
                  $minutes = ($decimalValue - $hours) * 60; // Calculate the remaining minutes
                  $totHrsMins = $hours + $minutes;
                  $hoursLate = ($row['rate'] / 8) * $hours;
                  $minutesLate = ($row['rate'] / 8) / 60 * $minutes;

                  $totalMinsHrsLate =  $hoursLate + $minutesLate;


                  $total_hr = round($row['morning'] + $row['afternoon'] + $row['graveyard'])  + $libtotal + $totHrsMins; // total hour

                  $casql = "SELECT *, SUM(amount) AS cashamount FROM cashadvance WHERE employee_id='$employee_id' AND date_advance BETWEEN '$from' AND '$to'";

                  $caquery = mysqli_query($connection, $casql);
                  $carow = mysqli_fetch_assoc($caquery);

                  $cashadvance = $carow['cashamount'];

                  //CASH LOAN
                  $lasql = "SELECT *, SUM(amount) AS lashamount FROM loan WHERE employee_id='$employee_id' AND date_loan BETWEEN '$from' AND '$to'";

                  $loanquery = mysqli_query($connection, $lasql);
                  $larow = mysqli_fetch_assoc($loanquery);

                  $loan = $larow['lashamount'];




                  $gross = (($row['rate'] / 8) * $total_hr);



                  if ($_SESSION["taxDeduct"] == "true") {
                    $totalTaxDeduct = 566.82 + 200.00 + 337.50;
                    $net_pay = $gross - $cashadvance - $loan - $totalMinsHrsLate;
                    $net_pay = $net_pay - $totalTaxDeduct;
                  } else {
                    $net_pay = $gross - $cashadvance - $loan - $totalMinsHrsLate;
                  }

                ?>

                  <div class="table-responsive push">

                    <table class="table table-bordered table-hover">

                      <tr>
                        <th colspan="8">LABAVENDO Payslip #<?php echo $number ?></th>
                      </tr>

                      <tr>
                        <td colspan="4">
                          <p class="font-w600 mb-1">Pay Period</p>
                        </td>
                        <td colspan="4" class="text-right"><b><?php echo date('F d, Y', strtotime($from)) ?> <b>-</b> <?php echo date('F d, Y', strtotime($to)) ?></b></td>
                      </tr>

                      <tr>
                        <td colspan="4">
                          <p class="font-w600 mb-1">Employee Name</p>
                        </td>
                        <td colspan="4" class="text-right"><b><?php echo $row['fullname'] ?></b></td>
                      </tr>

                      <tr>
                        <td colspan="4">
                          <p class="font-w600 mb-1">Employee Number</p>
                        </td>
                        <td colspan="4" class="text-right"><b>ID <?php echo $row['employee_id'] ?></b></td>
                      </tr>

                      <tr>
                        <td colspan="4" class="font-w600 text-right">Rate</td>
                        <td class="text-right"><?php echo $row['rate'] ?>.00 PHP</td>
                      </tr>

                      <?php if ($libtotal != 0) { ?>
                        <tr>
                          <td colspan="4" class="font-w600 text-right">Days of Vacation Leave Paid</td>
                          <td class="text-right"><?php echo  $daysOfLeave . " days (+" . $libtotal . " Hours)"; ?></td>
                        </tr>
                      <?php } ?>

                      <tr>
                        <td colspan="4" class="font-w600 text-right">Total Hours</td>
                        <td class="text-right"><?php echo  round($total_hr, 2) ?> Hours</td>
                      </tr>

                      <tr>
                        <td colspan="4" class="font-w600 text-right">Gross Income</td>
                        <td class="text-right"><?php echo  number_format($gross) ?> PHP</td>
                      </tr>

                      <tr id="taxDeductions">
                        <td colspan="4" class="font-w600 text-right" style="line-height: 40px;">SSS<br>
                          PHIL HEALTH<br>
                          PAG IBIG</td>
                        <td class="text-right" style="line-height: 40px;">-337.50 PHP <br>-200.00 PHP <br> -566.82 PHP</td>
                      </tr>

                      <?php if ($ot != 0) { ?>

                        <tr>
                          <td colspan="4" class="font-w600 text-right">Overtime</td>
                          <td class="text-right"><?php echo  number_format($ot) ?> PHP</td>
                        </tr>

                      <?php }
                      if ($totalMinsHrsLate != 0) {  ?>

                        <tr>
                          <td colspan="4" class="font-w600 text-right">Total Late</td>
                          <td class="text-right">-<?php echo  " (" . $totHrsMins . " hrs) " . number_format($totalMinsHrsLate) ?> PHP</td>
                        </tr>

                      <?php  }
                      if ($cashadvance != 0) { ?>
                        <tr>
                          <td colspan="4" class="font-w600 text-right">Cash Advance</td>
                          <td class="text-right">-<?php echo  number_format($cashadvance) ?> PHP</td>
                        </tr>

                      <?php }
                      if ($loan != 0) { ?>

                        <tr>
                          <td colspan="4" class="font-w600 text-right">Cash Loan</td>
                          <td class="text-right">-<?php echo  number_format($loan) ?> PHP</td>
                        </tr>
                      <?php } ?>
                      <tr>
                        <td colspan="4" class="font-w600 text-right">Net Income (Gross Income
                          <?php if ($loan != 0) { ?>
                            - Cash Loan
                          <?php }
                          if ($cashadvance != 0) { ?>
                            - Cash Advance
                          <?php  }
                          if ($_SESSION["taxDeduct"] == "true") { ?>
                            - Health Insurance
                          <?php  } ?>
                          )</td>
                        <td class="text-right"><b><?php echo  number_format($net_pay) ?> PHP</b> </td>
                      </tr>
                      <tr color="dark">
                        <td colspan="4" class="font-weight-bold text-uppercase text-right">NET PAY (Net Income + Overtime)</td>
                        <td class="text-right"><strong><?php echo  number_format($net_pay + $ot); ?> PHP </strong></td>
                      </tr>
                    </table>
                  </div>
                  <p class="text-muted text-center">Payslip generated on <?php echo date("m/d/Y") ?> <?php echo date("H:i A") ?> by <?php echo $firstname ?> <?php echo $lastname ?></p>
              </div>

            <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <?php require_once('includes/footer.php') ?>
  </div>
  <?php require_once('includes/datatables.php') ?>
</body>
<script>
  $(document).ready(function() {

    // Get the checkbox element
    var checkbox = document.getElementById("toggleDeduct");

    // Get the table row element
    var deductionRow = document.getElementById("taxDeductions");

    // Try to load the checkbox state from local storage
    var isChecked = localStorage.getItem("isChecked");

    // If a previous state was stored, update the checkbox state
    if (isChecked === "true") {
      checkbox.checked = true;
      deductionRow.style.display = "table-row";
    } else {
      deductionRow.style.display = "none";
    }
    // Add a change event listener to the checkbox
    checkbox.addEventListener("change", function() {
      var isChecked = checkbox.checked;
      // Check if the checkbox is checked



      if (checkbox.checked) {
        // Show the row


        // Update the state in local storage
        localStorage.setItem("isChecked", isChecked);
        // Send an AJAX request to the server to update the PHP variable
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "payslip.php", true);

        // Set the request header
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Define the data to send to the server
        var data = "isChecked=" + isChecked;

        // Define the callback function when the request is complete
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            // Request is complete
            // Reload the page to reflect the updated PHP variable
            location.reload();
          }
        };

        // Send the request with the data
        xhr.send(data);


      } else {


        // Hide the row


        // Update the state in local storage
        localStorage.setItem("isChecked", isChecked);
        // Send an AJAX request to the server to update the PHP variable
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "payslip.php", true);

        // Set the request header
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Define the data to send to the server
        var data = "isChecked=" + isChecked;

        // Define the callback function when the request is complete
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            // Request is complete
            // Reload the page to reflect the updated PHP variable
            location.reload();
          }
        };

        // Send the request with the data
        xhr.send(data);
      }


    });


  });
</script>

</html>