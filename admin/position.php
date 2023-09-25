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

if (isset($_POST['delete_pos'])) {
  $posid = $_POST['pid'];


  $query = "DELETE FROM position WHERE id = $posid";
  $del_query = mysqli_query($connection, $query);
}
?>
<!doctype html>

<html lang="en" dir="ltr">

<head>
  <title>Profiling and Payroll Management System</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
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
          <div class="page-header">
            <h1 class="page-title">
              Position
            </h1>
          </div>
          <div class="row row-cards">
            <div style="padding-left: 12px; padding-bottom: 25px;">
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-add-position">
                <i class="fe fe-plus mr-2"></i> Add Position
              </button>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-header py-3">
                  <h3 class="card-title">Company Positions</h3>
                </div>
                <?php require_once('modals/modal_add_posistion.php') ?>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Position ID</th>
                          <th>Position Title</th>
                          <th>Rate Per Day</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($row = mysqli_fetch_assoc($queryResult)) { ?>
                          <div id="modal-deletes-employee<?php echo $row['id'] ?>" class="modal fade animate" data-backdrop="true">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                  <h5 class="modal-title">Delete Position </h5>
                                </div>
                                <div class="modal-body p-lg">
                                  <div class="col-md-12">
                                    <form action="" method="post" enctype="multipart/form-data">

                                      <div class="modal-body">

                                        <input type="hidden" name="pid" value="<?php echo $row['id'] ?>">

                                        <h6>
                                          <p>Do you want to Delete <mark><?php echo $row['description'] ?></mark> Postion ?</p>
                                        </h6>
                                      </div>


                                  </div>
                                  <div class="modal-footer">
                                    <div style="padding-right: 12px;">
                                      <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">No</button>
                                      <button type="submit" name="delete_pos" class="btn danger p-x-md">Yes</button>
                                    </div>
                                  </div>
                                  </form>
                                </div><!-- /.modal-content -->
                              </div>
                            </div>
                          </div>
                          <tr>

                            <td><span class="text-muted"><?php echo $row['id'] ?></span></td>
                            <td><span class="text-muted"><?php echo $row['position_id'] ?></span></td>
                            <td><a class="text-inherit"><?php echo $row['description'] ?></a></td>
                            <td>
                              <?php echo number_format($row['rate']) ?> PHP/Day
                            </td>
                            <td>
                              <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit-time-<?php echo $row['id'] ?>"><i class='bi bi-pencil-square'></i></button>
                              <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-deletes-employee<?php echo $row['id'] ?>"><i class='bi bi-trash3-fill'></i></button>

                            </td>

                          </tr>
                          <!-- .modal -->
                          <div id="edit-time-<?php echo $row['id'] ?>" class="modal fade animate" data-backdrop="true">
                            <div class="modal-dialog" id="animate">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Edit Position</h5>
                                </div>
                                <form method="post" action="edit_position.php?id=<?php echo $row['position_id'] ?>">
                                  <div class="col modal-body text p-lg">

                                    <div style="padding-top: 0px;" class="form-group">
                                      <label class="form-label">Position Title</label>
                                      <div class="bootstrap-timepiker">
                                        <input required="true" type="text" value="<?php echo $row['description'] ?>" autofocus="true" class="form-control timepickr" name="position">
                                      </div>
                                    </div>
                                    <div style="padding-top: 0px;" class="form-group">
                                      <label class="form-label">Rate Per Day</label>
                                      <div class="bootstr-timepicker">
                                        <input required="true" type="text" value="<?php echo $row['rate'] ?>" class="form-control timeicker" name="rate_per_hour">
                                      </div>
                                    </div>

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
    </div>
    <?php require_once('includes/footer.php') ?>
  </div>
  <?php require_once('includes/datatables.php') ?>
</body>

</html>