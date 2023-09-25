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
    <title>Employee Portal</title>
    <title>Leave Application Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
<script type="text/javascript">
    $(function() {
        $("#date").datepicker({
            beforeShowDay: $.datepicker.noWeekends,
            minDate: 'now'
        });
    });
</script>
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
    <div class="header d-flex align-items-center ">
        <div class="d-flex align-items-left p-2">
            <img src="../image/<?php echo $photo; ?>" alt="Profile Picture" class="profile-picture">
            <div class="employee-info">
                <p class="mb-0">ID: <b><span id="employeeID"><?php echo $employee_id; ?></span></b></p>
                <p class="mb-0">Name: <b><span id="employeeName"><?php echo $fullname; ?></span></b></p>
            </div>
        </div>
        <div class="p-2">
            <table class="table table-sm text-white table-bordered text-center">
                Available Leave Credits:
                <thead>
                    <tr>
                        <th>Sick Leave</th>
                        <th>Emergency Leave</th>
                        <th>Vacation Leave</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>10 days</td>
                        <td>5 days</td>
                        <td>15 days</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <a href="signout.php" class="logout-button ml-auto p-2">Logout</a>
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
                                <label for="dateOfLeave">Type of Leave:</label>
                                <select id="dateDropdown" class="form-control">
                                    <option value="normal">Sick Leave</option>
                                    <option value="emergency">Emergency Leave</option>
                                    <option value="vacation">Vacation Leave</option>
                                </select>
                            </div>

                            <!-- <div class="form-group" id="dt1" style="display: none;">
                                <label for="dateOfLeave" id="dt1">Date of Leaves</label>
                                <input type="input" id="dateID" name="date_of_leave" class="">
                            </div> -->

                            <div class="form-group ">
                                <label for="dateOfLeave">Date of Leave</label>
                                <div id="dt1">
                                    <select id="selectedDatesDropdown" class="form-control"></select>
                                </div>
                                <div id="dt2">
                                    <input type="input" id="dateID" name="date_of_leave" class="form-control">
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="daysOfLeave">Days of Leave</label>
                                <input type="number" name="days_of_leave" class="form-control" id="daysOfLeave" placeholder="Enter number of days">
                            </div>
                            <div class="form-group">
                                <label for="reasonForLeave">Reason for Leave</label>
                                <textarea class="form-control" name="reason" rows="2" placeholder="Enter reason"></textarea>
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
                        <th width="80">ID</th>
                        <th width="120">Status</th>
                        <th width="150">Date of Leave</th>
                        <th width="100">Days of Leave</th>
                        <th width="150">Reason</th>
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
                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reasonModal">
                                    <ion-icon name="eye"></ion-icon>
                                </button> -->
                                <?php echo $reason; ?>
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
    <script type="text/javascript">
        $(document).ready(function() {

            // Function to calculate end dates for vacation leave
            function calculateVacationEndDates() {
                var currentDate = new Date();
                var endDates = [];

                for (var i = 0; i < 12; i++) {
                    var endDate = new Date(currentDate);
                    var daysToAdd = 30; // 30 days (1 Month) interval for vacation leave

                    // Loop to add days while excluding weekends (Saturdays and Sundays)
                    while (daysToAdd > 0) {
                        endDate.setDate(endDate.getDate() + 1); // Add one day
                        var dayOfWeek = endDate.getDay();

                        // Check if it's a weekend (0 for Sunday, 6 for Saturday)
                        if (dayOfWeek !== 0 && dayOfWeek !== 6) {
                            daysToAdd--;
                        }
                    }

                    endDates.push(endDate);
                    currentDate.setMonth(currentDate.getMonth() + 1); // Move to the next month
                }

                return endDates;
            }

            // Function to update the selected dates dropdown
            function updateSelectedDates() {
                var selectedValue = $("#dateDropdown").val();
                var selectedDatesDropdown = $("#selectedDatesDropdown");
                var numOfDaysLeave = $("#daysOfLeave");
                selectedDatesDropdown.empty();

                // if (selectedValue === "normal") {
                //     // Calculate the end date for normal leave (5 days from the current date)
                //     var currentDate = new Date();
                //     var endDate = new Date(currentDate);
                //     endDate.setDate(currentDate.getDate() + 4); // 4 because the current date is included

                //     var startDateOption = $("<option></option>");
                //     startDateOption.val(currentDate.toISOString().slice(0, 10));
                //     startDateOption.text(currentDate.toDateString());

                //     var endDateOption = $("<option></option>");
                //     endDateOption.val(endDate.toISOString().slice(0, 10));
                //     endDateOption.text(endDate.toDateString());

                //     selectedDatesDropdown.append(startDateOption);
                //     selectedDatesDropdown.append(endDateOption);
                // } else 

                if (selectedValue === "vacation") {
                    // Calculate and populate end dates for vacation leave (next 12 months)
                    var vacationEndDates = calculateVacationEndDates();


                    vacationEndDates.forEach(function(endDate) {
                        var endDateOption = $("<option></option>");
                        endDateOption.val(endDate.toISOString().slice(0, 10));
                        endDateOption.text(endDate.toDateString());
                        selectedDatesDropdown.append(endDateOption);

                    });
                    numOfDaysLeave.val("15");
                    numOfDaysLeave.prop("disabled", true);

                } else {
                    numOfDaysLeave.val("");
                    numOfDaysLeave.prop("disabled", false);
                }

            }

            // Initialize the selected dates dropdown
            updateSelectedDates();

            // Event handler to update the selected dates when the dropdown selection changes
            $("#dateDropdown").on("change", function() {
                updateSelectedDates();
            });


            function toggleDivHide() {
                var selectDateValue = $("#dateDropdown").val();
                var hideCalendaInp = $("#dt1");
                var hideCalendaSel = $("#dt2");

                if (selectDateValue === "normal" || selectDateValue === "emergency") {
                    hideCalendaInp.hide();
                    hideCalendaSel.show();

                } else {

                    hideCalendaInp.show();
                    hideCalendaSel.hide();
                }
            }
            toggleDivHide();
            $("#dateDropdown").on("change", function() {
                toggleDivHide();
            });

        });
        $("#dateID").datepicker({

            beforeShowDay: function(date) {
                var dateString = $.datepicker.formatDate('dd-mm-yy', date);
                var isVacationLeave = $("#leaveType").val() === "vacation";

                // Disable Saturdays and Sundays by default
                var dayOfWeek = date.getDay();
                var isWeekend = (dayOfWeek === 0 || dayOfWeek === 6);

                // Disable past dates and dates not in the array
                var isDisabled = (date < new Date());



                // Enable if it's a vacation leave and within the next 15 days
                if (isVacationLeave) {
                    var maxDate = new Date();
                    maxDate.setDate(maxDate.getDate() + 15);
                    isDisabled = isDisabled || date > maxDate;
                }

                return [!isWeekend && !isDisabled];
            }
        });

        // Handle leave type change
        $("#dateDropdown").on("change", function() {
            $("#dateID").datepicker("refresh");
        });
    </script>

    <!-- Include Bootstrap JS and jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>


</html>

</html>