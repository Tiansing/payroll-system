
<?php

require_once('includes/script.php');
require_once('session/Login.php');
date_default_timezone_set('Asia/Manila');
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

if (isset($_POST['time_in_am']) && isset($_POST['time_out_am'])) {
    $newtimein_am = date('H:i:s', strtotime($_POST['time_in_am']));
    $newtimeout_am = date('H:i:s', strtotime($_POST['time_out_am']));
} elseif (isset($_POST['time_in_pm']) && isset($_POST['time_out_pm'])) {
    $newtimein_pm = date('H:i:s', strtotime($_POST['time_in_pm']));
    $newtimeout_pm = date('H:i:s', strtotime($_POST['time_out_pm']));
} elseif (isset($_POST['time_in_grvyrd']) && isset($_POST['time_out_grvyrd'])) {
    $newtimein_grvyrd = date('H:i:s', strtotime($_POST['time_in_grvyrd']));
    $newtimeout_grvyrd = date('H:i:s', strtotime($_POST['time_out_grvyrd']));
}



/* Interval Morning */

$start = $newtimein_am;

$time_start = new DateTime($start);
$time_end = new DateTime($newtimeout_am);
$interval = $time_start->diff($time_end);
$hrs = $interval->format('%h');
$mins = $interval->format('%i');
$mins = $mins / 60;
$intMorn = $hrs + $mins;
if ($intMorn > 4.5) {
    $intMorn = $intMorn - 1;
}

/* Interval Afternoon */

$startPm = $newtimein_pm;

$time_startPm = new DateTime($startPm);
$time_endPm = new DateTime($newtimeout_pm);
$intervalPm = $time_startPm->diff($time_endPm);
$hrsPm = $intervalPm->format('%h');
$minsPm = $intervalPm->format('%i');
$minsPm = $minsPm / 60;
$intMid = $hrsPm + $minsPm;
if ($intMid > 4.5) {
    $intMid = $intMid - 1;
}


/* Interval Graveyard */

/* $startGrvyrd = $newtimein_grvyrd;

$time_startGrvyrd = new DateTime($startGrvyrd);
$time_endGrvyrd = new DateTime($newtimeout_grvyrd);
$intervalGrvyrd = $time_startGrvyrd->diff($time_endGrvyrd);
$hrsGrvyrd = $intervalGrvyrd->format('%h');
$minsGrvyrd = $intervalGrvyrd->format('%i');
$minsGrvyrd = $minsGrvyrd / 60;
$intGrvyrd = $hrsGrvyrd + $minsGrvyrd; */
$employee_id = $_GET['eid'];
$date = date("Y-m-d");
$sql2 = "SELECT * FROM `attendance` WHERE `employee_id` = '$employee_id' AND `date` = '$date'";
$query2 = mysqli_query($connection, $sql2);
$row2 = mysqli_fetch_assoc($query2);

if ($newtimein_grvyrd < $newtimeout_grvyrd) {

    $sql3 = "SELECT * FROM `attendance` WHERE `employee_id` = '$employee_id' ORDER BY id DESC LIMIT 1";
    $query3 = mysqli_query($connection, $sql3);
    $row3 = mysqli_fetch_assoc($query3);



    $startGrvyrd = $newtimein_grvyrd;

    $time_startGrvyrd = new DateTime($startGrvyrd);
    $time_endGrvyrd = new DateTime($newtimeout_grvyrd);
    $intervalGrvyrd = $time_startGrvyrd->diff($time_endGrvyrd);
    $hrsGrvyrd = $intervalGrvyrd->format('%h');
    $minsGrvyrd = $intervalGrvyrd->format('%i');
    $minsGrvyrd = $minsGrvyrd / 60;
    $intGrvyrd = $hrsGrvyrd + $minsGrvyrd;

    if ($intGrvyrd > 4.5) {
        $intGrvyrd = $intGrvyrd - 1;
    }
} else {

    $sql4 = "SELECT * FROM `attendance` WHERE `employee_id` = '$employee_id' AND `date` = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
    $query4 = mysqli_query($connection, $sql4);
    $row4 = mysqli_fetch_assoc($query4);
    $datey = $row4['date'];
    if ($newtimein_grvyrd > $newtimeout_grvyrd) {

        $time_start = $newtimein_grvyrd;
        $to_time = $newtimeout_grvyrd;

        if ($time_start > $to_time) {
            $intGrvyrd = ((strtotime($to_time) + 86400) - strtotime($time_start)) / 3600;
        } else {
            $intGrvyrd = (strtotime($time_start) - strtotime($to_time)) / 3600;
        }
        if ($intGrvyrd > 4.5) {
            $intGrvyrd = $intGrvyrd - 1;
        }

        echo '<div style="margin-top: 10px;" class="alert alert-success"><strong><u>' . $empName . '</u></strong> successfully logged out!  </div>';
    }
}

if (isset($_GET['id'])) {
    $idEm = $_GET['id'];

    if (isset($newtimein_am) && isset($newtimeout_am)) {
        $delete = "UPDATE `attendance` SET `time_in_morning`='$newtimein_am', `time_out_morning`='$newtimeout_am',`num_hr_morning`='$intMorn' WHERE `attendance_id`='$idEm';";
        $query = mysqli_query($connection, $delete) or die('Could not insert');
        $date = date("Y-m-d");
        header("location: ../admin/attendance.php?filter=$date&id=$idEm");
    }
    if (isset($newtimein_pm) && isset($newtimeout_pm)) {
        $delete = "UPDATE `attendance` SET `time_in_afternoon`='$newtimein_pm', `time_out_afternoon`='$newtimeout_pm',`num_hr_afternoon`='$intMid' WHERE `attendance_id`='$idEm';";
        $query = mysqli_query($connection, $delete) or die('Could not insert');
        $date = date("Y-m-d");
        header("location: ../admin/attendance.php?filter=$date&id=$idEm");
    }
    if (isset($newtimein_grvyrd) && isset($newtimeout_grvyrd)) {
        $delete = "UPDATE `attendance` SET `time_in_graveyard`='$newtimein_grvyrd', `time_out_graveyard`='$newtimeout_grvyrd',`num_hr_graveyard`='$intGrvyrd' WHERE `attendance_id`='$idEm';";
        $query = mysqli_query($connection, $delete) or die('Could not insert');
        $date = date("Y-m-d");
        header("location: ../admin/attendance.php?filter=$date&id=$idEm");
    }
}

if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
}

if (isset($_POST['edit'])) {

    $amount = $_POST['amount'];

    $delete = "UPDATE `cashadvance` SET `amount` = '$amount' WHERE `cash_id` = '$uid';";
    $query = mysqli_query($connection, $delete);

    header("location: ../advance.php?status=1");
}

?>