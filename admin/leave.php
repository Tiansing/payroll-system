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
$lstat = '';
$stat = '';
if (isset($_GET['status'])) {
  $Attendance = $_GET['status'];
}

if (isset($_GET['filter'])) {
  $lstat = $_GET['filter'];
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
              <?php require_once('modals/modal_filter_leave.php') ?>

            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript">
        function printPage() {
          var divElements = document.getElementById('printDataHolder').innerHTML;
          var oldPage = document.body.innerHTML;
          document.body.innerHTML = "<link rel='stylesheet' href='css/common.css' type='text/css' /><body class='bodytext'><div class='padding'><b style='font-size: 16px;'><p class=''>Attendance generated on <?php echo date("m/d/Y") ?> <?php echo date("G:i A") ?> by <?php echo $firstname ?> <?php echo $lastname ?></p></b></div>" + divElements + "</body>";
          window.print();
          document.body.innerHTML = oldPage;
        }
      </script>
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
                    <button type="button" onclick="clearStatus()" class="btn btn-success">
                      <i style="padding-top: 10px;" class="fe fe-x mr-2"></i> Approved</button>

                  <?php
                    break;
                  case "Pending":
                  ?>
                    <button type="button" onclick="clearStatus()" class="btn btn-warning">
                      <i style="padding-top: 10px;" class="fe fe-x mr-2"></i> Pending</button>
                  <?php break;
                  case "Declined": ?>
                    <button type="button" onclick="clearStatus()" class="btn btn-danger">
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
                              <?php echo "Sick Leave"; ?>

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
                              <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#approvemodal<?php echo $id; ?>">
                                Approve
                              </button>
                              <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#declineLeave<?php echo $id; ?>">
                                Decline
                              </button>
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
  function clearStatus() {
    window.location.href = "leave.php";
  }
</script>

</html>