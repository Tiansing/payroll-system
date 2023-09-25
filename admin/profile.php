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
if (isset($_GET['edit'])) {
  $generate = $_GET['edit'];
}

if ($generate == '1') {
  $stat = '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert"></button>
      Employee profile successfully edited.
      </div>';
} else {
}

if (isset($_POST['delete_emp'])) {
  $empid = $_POST['eid'];
  $employee_id = $_POST['employee_id'];

  $query = "DELETE FROM employees WHERE id = $empid";
  $del_query = mysqli_query($connection, $query);

  $filename = $_SERVER['DOCUMENT_ROOT'] . "/payroll-system/admin/employee_barcode/" . $employee_id . ".png";
  if ($del_query) {
    if (file_exists($filename)) {
      unlink($filename);
    }
  }
}


?>
<!doctype html>
<html lang="en" dir="ltr">

<head>
  <title>Profiling and Payroll Management System</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
</head>

<body class="" v-on:click="Reload">
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
              Profiling
            </h1>
          </div>
          <div class="row row-cards">
            <div style="padding-left: 12px; padding-bottom: 25px;">
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-add-employee">
                <i class="fe fe-plus mr-2"></i> Add Employee
              </button>
            </div>

            <!-- end of delete modal -->
            <?php include('modals/modal_delete.php') ?>
            <div class="col-12">
              <div class="card">
                <div class="card-header py-3">
                  <h3 class="card-title">Employee Profiling</h3>
                </div>
                <?php require_once('modals/modal_add_employee.php') ?>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th class="w-1">ID</th>
                          <th width="100">Name</th>
                          <th>Position</th>
                          <th>Address</th>
                          <!-- <th>Civil Status</th> -->
                          <th>Schedule</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $query = "SELECT *, employees.id AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                          <div id="modal-deletes-employee<?php echo $row['empid'] ?>" class="modal fade animate" data-backdrop="true">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                  <h5 class="modal-title">Delete Record </h5>
                                </div>
                                <div class="modal-body p-lg">
                                  <div class="col-md-12">
                                    <form action="" method="post" enctype="multipart/form-data">

                                      <div class="modal-body">

                                        <input type="hidden" name="eid" value="<?php echo $row['empid'] ?>">
                                        <input type="hidden" name="employee_id" value="<?php echo $row['employee_id'] ?>">

                                        <h6>
                                          <p>Do you want to Delete <mark><?php echo $row['fullname'] ?></mark> Data ?</p>
                                        </h6>
                                      </div>


                                  </div>
                                  <div class="modal-footer">
                                    <div style="padding-right: 12px;">
                                      <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">No</button>
                                      <button type="submit" name="delete_emp" class="btn danger p-x-md">Yes</button>
                                    </div>
                                  </div>
                                  </form>
                                </div><!-- /.modal-content -->
                              </div>
                            </div>
                          </div>

                          <tr>
                            <td><a><?php echo $row['employee_id'] ?></a></td>
                            <td><a class="text-inherit"><?php echo $row['fullname'] ?></a></td>
                            <td>
                              <?php echo $row['description'] ?>
                            </td>
                            <td>
                              <?php echo $row['address'] ?>
                            </td>
                            <!--  <td>
                              <?php echo $row['civil_status'] ?>
                            </td> -->
                            <td>
                              <?php
                              if (isset($row['time_in_morning'])) {
                                echo "Morning " . date("h:i A", strtotime($row['time_in_morning'])) . " - " . date("h:i A", strtotime($row['time_out_morning']));
                              } else if (isset($row['time_in_afternoon'])) {
                                echo "Midshift " . date("h:i A", strtotime($row['time_in_afternoon']))  . " - " . date("h:i A", strtotime($row['time_out_afternoon']));
                              } else if (isset($row['time_in_graveyard'])) {
                                echo "Graveyard " . date("h:i A", strtotime($row['time_in_graveyard']))  . " - " . date("h:i A", strtotime($row['time_out_graveyard']));
                              }

                              ?>
                            </td>
                            <td>
                              <a href="view.php?id=<?php echo $row['employee_id'] ?>"><button class="btn btn-success btn-sm"><i class='bi bi-eye-fill'></i></button></a>
                              <a href="edit.php?id=<?php echo $row['employee_id'] ?>"><button class="btn btn-primary btn-sm"><i class='bi bi-pencil-square'></i></button></a>
                              <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-deletes-employee<?php echo $row['empid'] ?>"><i class='bi bi-trash3-fill'></i></button>

                            </td>
                          <?php } ?>

                          </tr>

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
  <script>
    $(document).ready(function() {

      // DELETE FUNCTION
      $('.deletebtn').on('click', function() {

        $('#deletemodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
          return $(this).text();
        }).get();

        console.log(data);

        $('#delete_id').val(data[0]);

      });

    });
  </script>
  <?php require_once('includes/datatables.php') ?>
</body>

</html>