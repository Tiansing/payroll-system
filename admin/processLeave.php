<?php

function approveLeave()
{

    global $connection;
    if (isset($_POST['approveLeave'])) {
        $leaveid = $_POST['leaveid'];

        $query = "UPDATE `employee_leave` SET `leave_status`='Approved' WHERE `id`='$leaveid';
        ";
        $query = mysqli_query($connection, $query) or die('Could not insert');
        echo '<script>window.location.href="leave.php"</script>';
    }
}
function declineLeave()
{

    global $connection;
    if (isset($_POST['declineLeave'])) {
        $leaveid = $_POST['leaveid'];

        $query = "UPDATE `employee_leave` SET `leave_status`='Declined' WHERE `id`='$leaveid';
        ";
        $query = mysqli_query($connection, $query) or die('Could not insert');
        echo '<script>window.location.href="leave.php"</script>';
    }
}
