<?php

require_once('includes/script.php');
require_once('session/Login.php');

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

$generate = '';
$stat = '';
if (isset($_GET['status'])) {
  $generate = $_GET['status'];
}

if ($generate == '1') {
  $stat = '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert"></button>
      Overtime successfully deleted.
      </div>';
} else {
}
if (isset($_POST['approveOT'])) {
  $otID = $_POST['otID'];
  $query = "UPDATE overtime SET ot_status = 1 WHERE overtime_id = $otID";
  $approveQuer = mysqli_query($connection, $query);
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
            </div>
            <div class="col-lg order-lg-first">
              <?php require_once('includes/subheader.php') ?>
            </div>
          </div>
        </div>
      </div>
      <div class="my-3 my-md-5">
        <div class="container">
          <?php echo $stat ?>
          <div class="page-header">
            <h1 class="page-title">
              Overtime
            </h1>
          </div>
          <div class="row row-cards">
            <div style="padding-left: 12px; padding-bottom: 25px;">
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-add-overtime">
                <i class="fe fe-plus mr-2"></i> Add Overtime
              </button>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-header py-3">
                  <h3 class="card-title">Overtime Table</h3>
                </div>
                <?php require_once('modals/modal_add_overtime.php') ?>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover" id="otTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <!-- <th>No.</th> -->
                          <th>OT ID</th>
                          <th>Employee ID</th>
                          <th>Employee name</th>
                          <th width="50">No. of hours</th>
                          <th>Rate per day</th>
                          <th>Gross</th>
                          <th>DATE</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $count = 0;
                        while ($row = mysqli_fetch_assoc($queryResult)) {
                          $count++;
                          $otd = $row['overtime_id'];
                          $query = "SELECT * FROM overtime WHERE overtime_id = $otd ";
                          $otQuery = mysqli_query($connection, $query);
                          $rowot = mysqli_fetch_assoc($otQuery);

                        ?>
                          <tr>

                            <!-- <td><span class="text-muted"><?php echo $count ?></span></td> -->
                            <td><span class="text-muted"><?php echo $row['overtime_id'] ?></span></td>
                            <td><a class="text-primary"><?php echo $row['empid'] ?></a></td>
                            <td><a class="text-inherit"><?php echo $row['fullname'] ?></a></td>
                            <td><a class="text-inherit"><?php echo round($row['hours'], 1) ?> Hours</a></td>

                            <td>
                              <?php echo number_format($row['rate_hour']) ?> PHP
                            </td>
                            <td><strong><?php

                                        $gross = number_format($row['rate_hour']) * 1.25 / 8;
                                        $gross = $gross * round($row['hours'], 1);

                                        echo number_format($gross)


                                        ?> PHP</strong></td>
                            <td><a class="text-inherit"><?php echo date('F d, Y', strtotime($row['date_overtime'])) ?></a></td>
                            <td>
                              <?php
                              if ($rowot['ot_status'] == 1) { ?>
                                <h5><span class="badge badge-sm badge-success">
                                    Approved
                                  </span></h5>
                              <?php  } else { ?>
                                <h5><span class="badge badge-sm badge-warning">
                                    Pending
                                  </span></h5>
                              <?php } ?>
                            </td>
                            <td>
                              <button class="btn btn-success btn-sm " data-toggle="modal" data-target="#approve-<?php echo $row['overtime_id'] ?>">Approve</button>
                              <button class="btn btn-danger btn-sm " data-toggle="modal" data-target="#delete-<?php echo $row['overtime_id'] ?>">Decline</button>
                            </td>
                          </tr>

                          <!-- .modal -->
                          <div id="delete-<?php echo $row['overtime_id'] ?>" class="modal fade animate" data-backdrop="true">
                            <div class="modal-dialog" id="animate">
                              <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                  <h5 class="modal-title">Decline Overtime</h5>
                                </div>
                                <div class="modal-body text-center p-lg">
                                  <p>Are you sure you want to decline ?</p>
                                  <p style="font-size: 25px;"><b>Overtime Number <?php echo $row['overtime_id'] ?></b></p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">No</button>
                                  <a href="delete/overtime.php?id=<?php echo $row['overtime_id'] ?>"><button type="button" class="btn danger p-x-md">Yes</button></a>
                                </div>
                              </div><!-- /.modal-content -->
                            </div>
                          </div>
                          <!-- / .modal -->

                          <!-- .modal -->
                          <div id="approve-<?php echo $row['overtime_id'] ?>" class="modal fade animate" data-backdrop="true">
                            <div class="modal-dialog" id="animate">
                              <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                  <h5 class="modal-title">Approve Overtime</h5>
                                </div>
                                <div class="modal-body text-center p-lg">
                                  <p>Are you sure you want to approve?</p>
                                  <p style="font-size: 25px;"><b>Overtime Number <?php echo $row['overtime_id'] ?></b></p>
                                </div>
                                <div class="modal-footer">
                                  <form action="" method="POST">
                                    <input type="hidden" name="otID" value="<?php echo $row['overtime_id'] ?>">
                                    <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">No</button>
                                    <button type="submit" name="approveOT" class="btn dark-white p-x-md">Yes</button>

                                  </form>

                                </div>
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
    </div>
    <?php require_once('includes/footer.php') ?>
  </div>
  <?php require_once('includes/datatables.php') ?>
</body>
<script>
  $(document).ready(function() {
    $('#otTable').DataTable({
      responsive: true,
      "order": [
        [6, "desc"]
      ]
    })
  });
</script>

</html>