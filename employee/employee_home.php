<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="../favicon.ico" type="image/x-icon" />
    <title>Document</title>
    <title>Leave Application Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .header {
            background-color: #666666;
            color: white;
            padding: 20px;
        }

        .profile-picture {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }

        .employee-info {
            margin-left: 15px;
        }

        .logout-button {
            color: white;
            border: 1px solid white;
            padding: 5px 10px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }

        .logout-button:hover {
            background-color: white;
            color: #007bff;
        }
    </style>
</head>
<?php

include "session/ModelController.php";
$dash = new Dashboard;
$connection = $dash->TemporaryConnection();
session_start();



$userid = $_SESSION['employee_id'];

$query = "SELECT * FROM `employees` WHERE `id`=$userid";
$employee_query = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($employee_query)) {
    $employee_id = $row['employee_id'];
    $fullname = $row['fullname'];
    $photo = $row['photo'];
}

if (isset($_POST['submit'])) {
    $date_of_leave = $_POST['date_of_leave'];
    $days_of_leave = $_POST['days_of_leave'];
    $reason = $_POST['reason'];
    $reason = stripslashes(mysqli_real_escape_string($connection, $reason));
    $query = "INSERT INTO employee_leave (employee_id, date_of_leave, days_of_leave, reason_for_leave, leave_status, date_filed) VALUES ('$employee_id', '$date_of_leave', '$days_of_leave', '$reason', 'Pending', now());";
    mysqli_query($connection, $query);

    echo "<script>window.location.href='employee_home.php'</script>";
}
?>

<body>
    <div class="header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <img src="../image/<?php echo $photo; ?>" alt="Profile Picture" class="profile-picture">
            <div class="employee-info">
                <p class="mb-0">ID: <span id="employeeID"><?php echo $employee_id; ?></span></p>
                <p class="mb-0">Name: <span id="employeeName"><?php echo $fullname; ?></span></p>
            </div>
        </div>
        <a href="signout.php" class="logout-button">Logout</a>
    </div>
    <div class="container mt-5">

        <button class="btn btn-primary" id="showModalBtn" data-toggle="modal" data-target="#leaveModal">Apply for Leave</button>

        <!-- Leave Application Modal -->
        <div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="leaveModalLabel" aria-hidden="true">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="leaveModalLabel">Submit New Leave Request</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="employeeName">Employee Name</label>
                                <input type="text" name="employee_name" class="form-control" id="employeeName" disabled value="<?php echo $fullname; ?>" placeholder="Enter your name">
                                <input type="hidden" name="emp_id" value="<?php echo $employee_id ?>">
                            </div>
                            <div class="form-group">
                                <label for="dateOfLeave">Date of Leave</label>
                                <input type="date" name="date_of_leave" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="daysOfLeave">Days of Leave</label>
                                <input type="number" name="days_of_leave" class="form-control" placeholder="Enter number of days">
                            </div>
                            <div class="form-group">
                                <label for="reasonForLeave">Reason for Leave</label>
                                <textarea class="form-control" name="reason" rows="8" placeholder="Enter reason"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="table-responsive mt-5">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Date of Leave</th>
                        <th width="150">Days of Leave</th>
                        <th width="150">View Reason</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = "SELECT * FROM employee_leave WHERE employee_id= $employee_id ORDER BY id DESC";
                    $emp_leave_req = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($emp_leave_req)) {
                        $id  = $row['id'];
                        $leave_stat  = $row['leave_status'];
                        $dtleave  = $row['date_of_leave'];
                        $dateformat = strtotime($dtleave);
                        $longdate = date('F j, Y', $dateformat);
                        $dyleave  = $row['days_of_leave'];
                        $reason  = $row['reason_for_leave'];

                    ?>
                        <tr>
                            <td>
                                <?php echo $id; ?>
                            </td>
                            <td>

                                <h5><span <?php switch ($leave_stat) {
                                                case "Pending":
                                                    echo "class='badge badge-warning text-white'";
                                                case "Approved":
                                                    echo "class='badge badge-success text-white'";
                                                case "Declined":
                                                    echo "class='badge badge-danger text-white'";
                                            } ?>><?php echo $leave_stat; ?></span></h5>
                            </td>
                            <td>
                                <?php echo $longdate; ?>

                            </td>
                            <td>
                                <?php echo $dyleave; ?>

                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reasonModal<?php echo $id; ?>">
                                    <ion-icon name="eye"></ion-icon>
                                </button>

                            </td>

                            <!-- Modal -->
                            <div class="modal fade" id="reasonModal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="reasonModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="reasonModalLabel">Reason for Leave Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
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


                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>

</html>