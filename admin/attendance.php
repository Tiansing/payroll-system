<?php

require_once('includes/script.php');
require_once('session/Login.php');

include "processLeave.php";

$model = new Dashboard();
$session = new AdministratorSession();
$session->LoginSession();

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

$Attendance = '';
$today = '';
$attFrom = '';
$attTo = '';
$stat = '';
$lstat = '';
if (isset($_GET['lfilter'])) {
  $lstat = $_GET['lfilter'];
}
if (isset($_GET['status'])) {
  $Attendance = $_GET['status'];
}

if (isset($_GET['filter'])) {
  $today = $_GET['filter'];
}
if (isset($_GET['attf'])) {
  $attFrom = $_GET['attf'];
}
if (isset($_GET['attt'])) {
  $attTo = $_GET['attt'];
}

$employeeID = '';
if (isset($_GET['emid'])) {
  $employeeID = $_GET['emid'];
}

if ($Attendance == '1') {
  $stat = '<div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert"></button>
  Attendance for the day already exist.
</div>';
} else {
}

?>
<!doctype html>

<html lang="en" dir="ltr">

<head>
  <title>Profiling and Payroll Management System</title>
  <style>
    @media print {
      #hideComponent {
        display: none;
      }
    }
  </style>
</head>

<body>
  <div class="page" id="app">
    <div class="page-main">
      <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
        <div class="container">
          <div class="row align-items-center">
            <div class="d-flex">
              <?php require_once('includes/header.php') ?>

              <?php require_once('includes/bower_css.php') ?>
            </div>
            <div class="col-lg order-lg-first">
              <?php require_once('includes/subheader.php') ?>
              <?php require_once('modals/modal_filter_attendance.php') ?>
              <?php require_once('modals/modal_show_attendance.php') ?>
              <?php require_once('modals/modal_filter_leave.php') ?>
            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript">
        function printPage() {
          var printLabel = document.getElementById("hideComponent");
          printLabel.classList.add("hide-for-print");

          // Store the current page content
          var oldPage = document.body.innerHTML;

          // Set up a function to handle the afterprint event
          function afterPrintHandler() {
            // Remove the CSS class after printing
            printLabel.classList.remove("hide-for-print");

            // Remove the afterprint event listener
            window.removeEventListener('afterprint', afterPrintHandler);

            // Reload the page after printing is canceled
            location.reload();
          }

          // Add the afterprint event listener
          window.addEventListener('afterprint', afterPrintHandler);

          // Customize the content for printing
          var divElements = document.getElementById('printDataHolder').innerHTML;
          document.body.innerHTML = "<link rel='stylesheet' href='css/common.css' type='text/css' /><body class='bodytext'><div class='padding'><b style='font-size: 16px;'><p class=''>Attendance generated on <?php echo date("m/d/Y") ?> <?php echo date("G:i A") ?> by <?php echo $firstname ?> <?php echo $lastname ?></p></b></div>" + divElements + "</body>";

          // Initiate the print operation
          window.print();
        }
      </script>
      <div class="my-3 my-md-5">
        <div class="container">
          <?php echo $stat ?>
          <div class="page-header">

            <h1 class="page-title">
              Attendance
            </h1>
          </div>

          <div class="row row-cards">
            <div style="padding-left: 12px; padding-bottom: 25px;">
              <div class="dropdown  ">
                <!-- <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                  <i style="padding-top: 10px;" class="fe fe-clock mr-2"></i> Add Attendance</button> -->

                <div style="padding-top: 10px;" class="dropdown-menu">
                  <button data-toggle="modal" data-target="#modal-add-attendance-in" class="dropdown-item ">Add Time In</button>
                  <button data-toggle="modal" data-target="#modal-add-attendance-out" class="dropdown-item ">Add Time Out</button>
                </div>

              </div>
              <div style="padding-left: 12px;" class="dropdown  ">
                <button type="button" data-toggle="modal" data-target="#modal-filter-attendance" class="btn btn-secondary">
                  <i style="padding-top: 10px;" class="fe fe-filter mr-2"></i> Filter Date</button>


              </div>
              <div style="padding-left: 12px;" class="dropdown  ">
                <button type="button" class="btn btn-secondary" onclick="printPage()">
                  <i style="padding-top: 10px;" class="fe fe-printer mr-2"></i> Print Attendance</button>


              </div>
              <div style="padding-left: 12px;" class="dropdown  ">
                <a target="_blank" href="../index.php"><button type="button" class="btn btn-secondary">
                    <i style="padding-top: 10px;" class="fe fe-grid mr-2"></i> Use QR code</button></a>


              </div>
              <div style="padding-left: 420px; float: right" class="dropdown ">
                <button data-toggle="modal" data-target="#modal-show-attendance" type="button" class="btn btn-secondary ">
                  <i style="padding-top: 10px;" class="fe fe-eye mr-2"></i> Show All</button>


              </div>
            </div>


            <div class="col-12" id="printDataHolder">
              <div class="card">
                <div class="card-header py-3">
                  <h3 class="card-title">Attendance Table for <b>
                      <?php

                      if (!empty($attFrom) && !empty($attTo)) {

                        echo date('F d, Y', strtotime($attFrom)) . " - " . date('F d, Y', strtotime($attTo));
                      } else  if (!empty($today)) {

                        echo date('F d, Y', strtotime($today));
                      } else  if (!empty($employeeID)) {

                        $query = "SELECT * FROM employees WHERE id = $employeeID";

                        $empname_query = mysqli_query($connection, $query);

                        if (!$empname_query) {
                          $fname = "";
                        } else {
                          while ($raws = mysqli_fetch_assoc($empname_query)) {
                            $fname = $raws['fullname'];
                          }
                          echo  $fname;
                        }
                      }



                      ?></b></h3>
                </div>
                <?php require_once('modals/modal_add_attendance.php') ?>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover" id="example2" cellspacing="5">
                      <thead>
                        <tr>

                          <th>Employee name</th>
                          <th>Timein</th>
                          <th>Timeout</th>
                          <th>Total Time</th>
                          <th>Schedule</th>
                          <th>Timein date</th>
                          <th id="hideComponent">action</th>

                        </tr>
                      </thead>
                      <tbody>

                        <?php


                        while ($row = mysqli_fetch_assoc($queryResult)) {

                          $sched_id = $row['schedule_id'];

                          $att_id = $row['attendance_id'];

                          $lates = $row['late_duration'];
                          $decimalValue = $lates; // Replace with your desired decimal value
                          $hours = floor($decimalValue); // Extract the whole hours
                          $minutes = round(($decimalValue - $hours) * 60); // Calculate the remaining minutes        

                          $lateDuration = (($hours == 0 && $minutes == 0) ? NULL : (($hours == 0) ? "$minutes mins" : "$hours" . ($hours > 1 ? "hrs" : "hr") . " and $minutes mins"));

                          $statusMorning = ($row['status_morning']) ? '&nbsp&nbsp<span class="badge badge-info">Ontime</span>' : '&nbsp&nbsp<span class="badge badge-warning">Late ' . $lateDuration . '</span>';

                          $statusAfternoon = ($row['status_afternoon']) ? '&nbsp&nbsp<span class="badge badge-info">Ontime</span>' : '&nbsp&nbsp<span class="badge badge-warning">Late ' . $lateDuration . '</span>';

                          $statusGraveyard = ($row['status_graveyard']) ? '&nbsp&nbsp<span class="badge badge-info">Ontime</span>' : '&nbsp&nbsp<span class="badge badge-warning">Late ' . $lateDuration . '</span>';

                        ?>


                          <tr>



                            <td><a class="text-inherit"><?php echo $row['fullname'] ?></a></td>
                            <td class=""><?php
                                          if (isset($row['time_in_morning'])) {
                                            echo date('h:i A', strtotime($row['time_in_morning']));
                                            echo $statusMorning;
                                          } else if (isset($row['time_in_afternoon'])) {
                                            echo date('h:i A', strtotime($row['time_in_afternoon']));
                                            echo $statusAfternoon;
                                          } else if (isset($row['time_in_graveyard'])) {
                                            echo date('h:i A', strtotime($row['time_in_graveyard']));
                                            echo $statusGraveyard;
                                          } else {
                                            echo "";
                                          } ?>
                            </td>
                            <td><a class="text-inherit"><?php
                                                        if (isset($row['time_out_morning'])) {
                                                          echo  date('h:i A', strtotime($row['time_out_morning']));
                                                        } else if (isset($row['time_out_afternoon'])) {
                                                          echo date('h:i A', strtotime($row['time_out_afternoon']));
                                                        } else if (isset($row['time_out_graveyard'])) {
                                                          echo date('h:i A', strtotime($row['time_out_graveyard']));
                                                        } else {
                                                          echo "";
                                                        }

                                                        ?></a></td>



                            <td class="text"><?php
                                              if (isset($row['num_hr_morning'])) {
                                                echo round($row['num_hr_morning'], 2);
                                              } else if (isset($row['num_hr_afternoon'])) {
                                                echo round($row['num_hr_afternoon'], 2);
                                              } else if (isset($row['num_hr_graveyard'])) {
                                                echo round($row['num_hr_graveyard'], 2);
                                              } else {
                                                echo "";
                                              }
                                              ?> HRS</td>

                            <td class="text"><?php

                                              $queryPosition1 = "SELECT * FROM schedules WHERE id = $sched_id";
                                              $queryResult1 = mysqli_query($connection, $queryPosition1);
                                              while ($row3 = mysqli_fetch_assoc($queryResult1)) {
                                                if (isset($row3['time_in_morning'])) {
                                                  echo "Morning " . date('H:i A', strtotime($row3['time_in_morning'])) . " - " . date("h:i A", strtotime($row3['time_out_morning']));
                                                } else if (isset($row3['time_in_afternoon'])) {
                                                  echo "Midshift " . date("h:i A", strtotime($row3['time_in_afternoon'])) . " - " . date("h:i A", strtotime($row3['time_out_afternoon']));
                                                } else if (isset($row3['time_in_graveyard'])) {
                                                  echo "Graveyard " . date("h:i A", strtotime($row3['time_in_graveyard']))  . " - " . date("h:i A", strtotime($row3['time_out_graveyard']));
                                                }
                                              }

                                              ?> </td>


                            <td><a class="text-inherit"><?php echo date('M d, Y', strtotime($row['date'])) ?></a></td>
                            <td id="hideComponent">
                              <!--    <button class="btn btn-success btn-sm">Edit</button> -->
                              <button class="btn btn-success btn-sm " data-toggle="modal" data-target="#edit-time-<?php echo $row['attendance_id'] ?>">Edit</i></button>

                            </td>

                          </tr>

                          <!-- .modal -->
                          <div id="edit-time-<?php echo $row['attendance_id'] ?>" class="modal fade animate" data-backdrop="true">
                            <div class="modal-dialog" id="animate">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Edit Time <?php echo $row['id'] ?></h5>
                                </div>
                                <form method="post" action="time.php?id=<?php echo $row['attendance_id'] ?>&eid=<?php echo $row['employee_id'] ?>">
                                  <div class="modal-body text p-lg">
                                    <?php

                                    $queryPosition1 = "SELECT * FROM attendance WHERE attendance_id = $att_id";
                                    $queryResult1 = mysqli_query($connection, $queryPosition1);
                                    while ($row3 = mysqli_fetch_assoc($queryResult1)) {

                                      if (isset($row3['time_in_morning'])) { ?>

                                        <div style="padding-top: 12px;" class="form-group">
                                          <label class="form-label">Timein Morning</label>
                                          <div class="bootstrap-timepicker">
                                            <input required="true" type="text" value="<?php
                                                                                      if (isset($row3['time_in_morning'])) {
                                                                                        echo date('h:i A', strtotime($row3['time_in_morning']));
                                                                                      } else {
                                                                                        echo "";
                                                                                      }
                                                                                      ?>" class="form-control timepicker" name="time_in_am">
                                          </div>
                                        </div>

                                        <div style="padding-top: 12px;" class="form-group">
                                          <label class="form-label">Timeout Morning</label>
                                          <div class="bootstrap-timepicker">
                                            <input required="true" type="text" value="<?php
                                                                                      if (isset($row3['time_out_morning'])) {
                                                                                        echo date('h:i A', strtotime($row3['time_out_morning']));
                                                                                      } else {
                                                                                        echo "";
                                                                                      }
                                                                                      ?>" class="form-control timepicker" name="time_out_am">
                                          </div>
                                        </div>

                                      <?php  } else if (isset($row3['time_in_afternoon'])) {

                                      ?>
                                        <div style="padding-top: 12px;" class="form-group">
                                          <label class="form-label">Timein Midshift</label>
                                          <div class="bootstrap-timepicker">
                                            <input required="true" type="text" value="<?php
                                                                                      if (isset($row3['time_in_afternoon'])) {
                                                                                        echo date('h:i A', strtotime($row3['time_in_afternoon']));
                                                                                      } else {
                                                                                        echo "";
                                                                                      }
                                                                                      ?>" class="form-control timepicker" name="time_in_pm">
                                          </div>
                                        </div>

                                        <div style="padding-top: 12px;" class="form-group">
                                          <label class="form-label">Timeout Midshift</label>
                                          <div class="bootstrap-timepicker">
                                            <input required="true" type="text" value="<?php
                                                                                      if (isset($row3['time_out_afternoon'])) {
                                                                                        echo date('h:i A', strtotime($row3['time_out_afternoon']));
                                                                                      } else {
                                                                                        echo "";
                                                                                      }

                                                                                      ?>" class="form-control timepicker" name="time_out_pm">
                                          </div>
                                        </div>
                                      <?php  } else if (isset($row3['time_in_graveyard'])) {

                                      ?>
                                        <div style="padding-top: 12px;" class="form-group">
                                          <label class="form-label">Timein Graveyard</label>
                                          <div class="bootstrap-timepicker">
                                            <input required="true" type="text" class="form-control timepicker" value="<?php
                                                                                                                      if (isset($row3['time_in_graveyard'])) {
                                                                                                                        echo date('h:i A', strtotime($row3['time_in_graveyard']));
                                                                                                                      } else {
                                                                                                                        echo "";
                                                                                                                      }
                                                                                                                      ?>" name="time_in_grvyrd">
                                          </div>
                                        </div>

                                        <div style="padding-top: 12px;" class="form-group">
                                          <label class="form-label">Timeout Graveyard</label>
                                          <div class="bootstrap-timepicker">
                                            <input required="true" type="text" class="form-control timepicker" value="<?php
                                                                                                                      if (isset($row3['time_out_graveyard'])) {
                                                                                                                        echo date('h:i A', strtotime($row3['time_out_graveyard']));
                                                                                                                      } else {
                                                                                                                        echo "";
                                                                                                                      }
                                                                                                                      ?>" name="time_out_grvyrd">
                                          </div>
                                        </div>
                                    <?php      }
                                    } ?>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="edit_time" class="btn danger p-x-md">Update</button>
                                  </div>
                                </form>
                              </div><!-- /.modal-content -->
                            </div>
                          </div>
                          <!-- / .modal -->
                        <?php } ?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
      <!-- ---------LEAVE REQRUEST------------->
      <div class="my-3 my-md-5">
        <div class="container">
          <?php echo $stat ?>
          <div class="page-header">

            <h1 class="page-title">
              Leave Requests
            </h1>
          </div>

          <div class="row row-cards">
            <div style="padding-left: 12px; padding-bottom: 25px;">
              <div class="dropdown  ">


                <div style="padding-top: 10px;" class="dropdown-menu">
                  <button data-toggle="modal" data-target="#modal-add-attendance-in" class="dropdown-item ">Add Time In</button>
                  <button data-toggle="modal" data-target="#modal-add-attendance-out" class="dropdown-item ">Add Time Out</button>
                </div>

              </div>


              <div style="padding-left: 12px;" class="dropdown  ">
                <button type="button" data-toggle="modal" data-target="#modal-filter-leave" class="btn btn-secondary">
                  <i style="padding-top: 10px;" class="fe fe-filter mr-2"></i> Filter Status</button>

                <?php
                switch ($lstat) {

                  case "Approved":

                ?>
                    <button type="button" id="clearID" onclick="clearStatus()" class="btn btn-success">
                      <i style="padding-top: 10px;" class="fe fe-x mr-2"></i> Approved</button>

                  <?php
                    break;
                  case "Pending":
                  ?>
                    <button type="button" id="clearID" onclick="clearStatus()" class="btn btn-warning">
                      <i style="padding-top: 10px;" class="fe fe-x mr-2"></i> Pending</button>
                  <?php break;
                  case "Declined": ?>
                    <button type="button" id="clearID" onclick="clearStatus()" class="btn btn-danger">
                      <i style="padding-top: 10px;" class="fe fe-x mr-2"></i> Declined</button>
                <?php } ?>
              </div>
            </div>



            <div class="col-12">
              <div class="card">
                <div class="card-header py-3">
                  <h3 class="card-title">Leave Requests Table</h3>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover" id="example1" cellspacing="5">
                      <thead>
                        <tr>


                          <th>ID</th>
                          <th>Employee name</th>
                          <th>Status</th>
                          <th>Type of Leave</th>
                          <th>Date of Leave</th>
                          <th width="50">Days of Leave</th>
                          <th>Date Filed</th>
                          <th>Leave Reason</th>
                          <th>action</th>

                        </tr>
                      </thead>
                      <tbody>


                        <?php
                        include "modals/modal_all_leave.php";
                        while ($row = mysqli_fetch_assoc($emp_leave_req)) {
                          $id  = $row['id'];
                          $employee_id  = $row['employee_id'];
                          $leave_stat  = $row['leave_status'];
                          $dtleave  = $row['date_of_leave'];
                          $dateformat = strtotime($dtleave);
                          $longdate = date('F j, Y', $dateformat);
                          $dyleave  = $row['days_of_leave'];
                          $reason  = $row['reason_for_leave'];
                          $dtfiled  = $row['date_filed'];
                          $type_of_leave  = $row['type_of_leave'];
                          $dtfiled = strtotime($dtfiled);
                          $dtfiled = date("F j, Y", $dtfiled);
                          $query1 = "SELECT * FROM employees WHERE employee_id =  $employee_id";
                          $emp_leave_req1 = mysqli_query($connection, $query1);
                          while ($row1 = mysqli_fetch_assoc($emp_leave_req1)) {
                            $employee_name = $row1["fullname"];
                          }

                        ?>
                          <tr>
                            <td>
                              <?php echo $id; ?>
                            </td>

                            <td>
                              <?php echo $employee_name; ?>
                            </td>
                            <td>

                              <h4><span <?php switch ($leave_stat) {
                                          case "Pending":
                                            echo "class='badge badge-warning'";
                                          case "Approved":
                                            echo "class='badge badge-success'";
                                          case "Declined":
                                            echo "class='badge badge-danger'";
                                        } ?>><?php echo $leave_stat; ?></span></h4>
                            </td>
                            <td>
                              <?php echo $type_of_leave; ?>

                            </td>
                            <td>
                              <?php echo $longdate; ?>

                            </td>
                            <td>
                              <h3> <span class="badge badge-dark"><?php echo $dyleave; ?></span></h3>


                            </td>
                            <td>
                              <?php echo $dtfiled; ?>

                            </td>
                            <td>
                              <?php echo $reason; ?>

                            </td>

                            <td>
                              <!-- <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#reasonModal">
                                View Reason
                              </button> -->
                              <?php if ($leave_stat == "Pending") { ?>
                                <button type="button" class="btn btn-sm btn-success" id="btnApproved" data-toggle="modal" data-target="#approvemodal<?php echo $id; ?>">
                                  Approve
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" id="btnDeclined" data-toggle="modal" data-target="#declineLeave<?php echo $id; ?>">
                                  Decline
                                </button>
                              <?php } ?>



                            </td>
                            <?php approveLeave(); ?>
                            <?php declineLeave(); ?>
                            <!-- Modal -->
                            <div class="modal fade" id="reasonModal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="reasonModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="reasonModalLabel">Reason for Leave Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <!-- Scrollable content -->
                                    <div style="max-height: 350px; overflow-y: auto;">
                                      <!-- Leave reason content goes here -->

                                      <p id="leaveReason"> <?php echo $reason; ?></p>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Approve Leave modal -->
                            <div class="modal fade" id="approvemodal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header bg-success">
                                    <h5 class="modal-title text-white" id="exampleModalLabel"> Approve Leave Request </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                  </div>
                                  <form method="POST" action="">
                                    <div class="modal-body">
                                      <input type="hidden" name="leaveid" value="<?php echo $id; ?>">
                                      <h4> Do you want to Approve <mark><?php echo $employee_name; ?></mark> Leave Request ?</h4>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal"> NO </button>
                                      <button type="submit" name="approveLeave" class="btn btn-primary"> Yes </butron>
                                    </div>
                                  </form>

                                </div>
                              </div>
                            </div>
                            <!-- Decline Leave modal -->
                            <div class="modal fade" id="declineLeave<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header bg-danger">
                                    <h5 class="modal-title text-white" id="exampleModalLabel"> Decline Leave Request </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                  </div>
                                  <form method="POST" action="">
                                    <div class="modal-body">
                                      <input type="hidden" name="leaveid" value="<?php echo $id; ?>">
                                      <h4> Do you want to Decline <mark><?php echo $employee_name; ?></mark> Leave Request ?</h4>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal"> NO </button>
                                      <button type="submit" name="declineLeave" class="btn btn-primary"> Yes </butron>
                                    </div>
                                  </form>

                                </div>
                              </div>
                            </div>

                          </tr>
                        <?php } ?>
                      </tbody>


                    </table>
                  </div>
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
  <?php require_once('includes/bower.php') ?>
</body>
<script>
  $(document).ready(function() {

    function clearStatus() {
      window.location.href = "attendance.php?filter=<?php echo $date; ?>";
    }
    document.getElementById("clearID").addEventListener("click", clearStatus);
    $('#attTable1').DataTable({
      responsive: true,
      "order": [
        [, "desc"]
      ]
    })
    $('#leaveTable1').DataTable({
      responsive: true,
      "order": [
        [6, "desc"]
      ]
    })
  });
</script>


</html>