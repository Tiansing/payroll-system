<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<?php


require_once('../admin/includes/script.php');
require_once('../admin/session/Login.php');

$set_timezone = date_default_timezone_set("Asia/Manila");

$model = new Dashboard();
$session = new AdministratorSession();
$session->LoginSession();
$today = date('Y-m-d');
// get the q parameter from URL
$q = $_REQUEST["q"];



if (isset($q)) {

  // lookup all hints from array if $q is different from ""
  if ($q != "") {
    /*$q = strtolower($q);
  $len=strlen($q);
  foreach($a as $name) {
    if (stristr($q, substr($name, 0, $len))) {
      if ($hint === "") {
        $hint = $name;
      } else {
        $hint .= ", $name";
      }
    }
  }*/
    // $result = mysqli_query($con, "SELECT * FROM attendance WHERE name='$q'");

    // $rowcount = mysqli_num_rows($result);

    $model = new Dashboard();

    $content = $q;

    if (!is_string($content) || is_numeric($content)) {
      $connection = $model->TemporaryConnection();



      $numbers = '';
      for ($i = 0; $i < 7; $i++) {
        $numbers .= $i;
      }
      $id = substr(str_shuffle($numbers), 0, 9);

      $date = date("Y-m-d");
      $time_in = date('H:i');
      $month = date("F");
      $year = date("Y");

      $queryEmployeeId = "SELECT * FROM `employees` WHERE `employee_id` = '$content';";
      $queryResult = mysqli_query($connection, $queryEmployeeId);
      $rowQuery = mysqli_fetch_assoc($queryResult);



      if ($rowQuery) {
        $employee_id = $rowQuery['id'];
        $empName = $rowQuery['fullname'];
        $empImg = $rowQuery['photo'];

        $sql2 = "SELECT * FROM attendance WHERE employee_id = '$employee_id' AND `date` = '$date'";
        $query2 = mysqli_query($connection, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
      } else {
        $employee_id = "";
      }


      if ($employee_id != 0) {


        if (mysqli_affected_rows($connection) > 0) {
          // Generate your image URL here

          // Set appropriate headers for image content

          $imageUrl = '<img height="100" width="100" src="image/' . $empImg . '" alt="" > ';

          echo $imageUrl;
          echo '<div style="margin-top: 10px;" class="alert alert-success"><strong>' . $empName . '</strong> successfully logged in</div>';
        } else {

          $queryEmployeeId = "SELECT * FROM `employees` WHERE `employee_id` = '$content';";
          $queryResult = mysqli_query($connection, $queryEmployeeId);
          $rowQuery = mysqli_fetch_assoc($queryResult);

          $employee_id = $rowQuery['id'];
          $schedule_id = $rowQuery['schedule_id'];

          switch ($schedule_id) {
            case 27: { //Morning Shift
                $sched = "SELECT * FROM `schedules` WHERE `id` = '$schedule_id';";
                $querySched = mysqli_query($connection, $sched);
                $schedRow = mysqli_fetch_assoc($querySched);

                $logstatus = ($time_in >= $schedRow['time_in_morning']) ? 0 : 1;

                if ($time_in >= $schedRow['time_in_morning']) {
                  $start = $schedRow['time_in_morning'];

                  $time_start = new DateTime($start);
                  $time_end = new DateTime($time_in);
                  $interval = $time_start->diff($time_end);
                  $hrs = $interval->format('%h');
                  $mins = $interval->format('%i');
                  $mins = $mins / 60;
                  $lateDur = $hrs + $mins;
                } else {
                  $lateDur = 0;
                }

                // $decimalValue = $lateDur; // Replace with your desired decimal value
                // $hours = floor($decimalValue); // Extract the whole hours
                // $minutes = ($decimalValue - $hours) * 60; // Calculate the remaining minutes
                // $lateDuration = (($hours == 0 && $minutes == 0) ? NULL : (($hours == 0) ? "$minutes mins" : "$hours" . ($hours > 1 ? "hrs" : "hr") . " and $minutes mins"));

                $insertAttendance = "INSERT INTO `attendance` (`employee_id`, `attendance_id`, `date`, `time_in_morning`, `time_out_morning`, `time_in_afternoon`, `time_out_afternoon`, `status_morning`, `status_afternoon`, `num_hr_morning`, `num_hr_afternoon`, `month`, `year`, `late_duration`) VALUES ('$employee_id', '$id', '$date', '$time_in', null, null, null, '$logstatus', null, null, null, '$month', '$year','$lateDur');";

                $query = mysqli_query($connection, $insertAttendance) or die(mysqli_error($connection) . $insertAttendance);
                $imageUrl = '<img height="100" width="100" src="image/' . $empImg . '" alt="" > ';

                echo $imageUrl;
                echo '<div style="margin-top: 10px;" class="alert alert-success"><strong>' . $empName . '</strong> successfully logged in [Morning shift]</div>';
                break;
              }
            case 28: { //Midshift
                $queryEmployeeId = "SELECT * FROM `employees` WHERE `employee_id` = '$content';";
                $queryResult = mysqli_query($connection, $queryEmployeeId);
                $rowQuery = mysqli_fetch_assoc($queryResult);

                $employee_id = $rowQuery['id'];
                $schedule_id = $rowQuery['schedule_id'];

                $sched = "SELECT * FROM `schedules` WHERE `id` = '$schedule_id';";
                $querySched = mysqli_query($connection, $sched);
                $schedRow = mysqli_fetch_assoc($querySched);

                $logstatus = ($time_in >= $schedRow['time_in_afternoon']) ? 0 : 1;


                if ($time_in >= $schedRow['time_in_afternoon']) {
                  $start = $schedRow['time_in_afternoon'];

                  $time_start = new DateTime($start);
                  $time_end = new DateTime($time_in);
                  $interval = $time_start->diff($time_end);
                  $hrs = $interval->format('%h');
                  $mins = $interval->format('%i');
                  $mins = $mins / 60;
                  $lateDur = $hrs + $mins;
                } else {
                  $lateDur = 0;
                }
                // $decimalValue = $lateDur; // Replace with your desired decimal value
                // $hours = floor($decimalValue); // Extract the whole hours
                // $minutes = ($decimalValue - $hours) * 60; // Calculate the remaining minutes
                // $lateDuration = (($hours == 0 && $minutes == 0) ? NULL : (($hours == 0) ? $minutes : $hours . ($hours > 1 ? "hrs" : "hr") . " and $minutes mins"));

                $insertAttendance = "INSERT INTO `attendance` (`employee_id`, `attendance_id`, `date`, `time_in_morning`, `time_out_morning`, `time_in_afternoon`, `time_out_afternoon`, `status_morning`, `status_afternoon`, `num_hr_morning`, `num_hr_afternoon`, `month`, `year`, `late_duration`) VALUES ('$employee_id', '$id', '$date', null, null, '$time_in', null, null, '$logstatus', null, null, '$month', '$year','$lateDur');";

                $query = mysqli_query($connection, $insertAttendance) or die(mysqli_error($connection) . $insertAttendance);


                $imageUrl = '<img height="100" width="100" src="image/' . $empImg . '" alt="" > ';



                echo $imageUrl;
                echo '<div style="margin-top: 10px;" class="alert alert-success"><strong>' . $empName . '</strong> successfully logged in [Midshift]</div>';
                break;
              }
            case 29: { // Graveyard shift
                $queryEmployeeId = "SELECT * FROM `employees` WHERE `employee_id` = '$content';";
                $queryResult = mysqli_query($connection, $queryEmployeeId);
                $rowQuery = mysqli_fetch_assoc($queryResult);

                $employee_id = $rowQuery['id'];
                $schedule_id = $rowQuery['schedule_id'];

                $sched = "SELECT * FROM `schedules` WHERE `id` = '$schedule_id';";
                $querySched = mysqli_query($connection, $sched);
                $schedRow = mysqli_fetch_assoc($querySched);

                $logstatus = ($time_in >= $schedRow['time_in_graveyard']) ? 0 : 1;


                if ($time_in >=  $schedRow['time_in_graveyard']) {
                  $start = $schedRow['time_in_graveyard'];

                  $time_start = new DateTime($start);
                  $time_end = new DateTime($time_in);
                  $interval = $time_start->diff($time_end);
                  $hrs = $interval->format('%h');
                  $mins = $interval->format('%i');
                  $mins = $mins / 60;
                  $lateDur = $hrs + $mins;
                } else {
                  $lateDur = 0;
                }

                // $decimalValue = $lateDur; // Replace with your desired decimal value
                // $hours = floor($decimalValue); // Extract the whole hours
                // $minutes = ($decimalValue - $hours) * 60; // Calculate the remaining minutes
                // $lateDuration = (($hours == 0 && $minutes == 0) ? NULL : (($hours == 0) ? "$minutes mins" : "$hours" . ($hours > 1 ? "hrs" : "hr") . " and $minutes mins"));

                $insertAttendance = "INSERT INTO `attendance` (`employee_id`, `attendance_id`, `date`, `time_in_morning`, `time_out_morning`, `time_in_afternoon`, `time_out_afternoon`, `time_in_graveyard`, `time_out_graveyard`,`status_morning`, `status_afternoon`,`status_graveyard`, `num_hr_morning`, `num_hr_afternoon`,`num_hr_graveyard`, `month`, `year`, `late_duration`) VALUES ('$employee_id', '$id', '$date', null, null, null, null, '$time_in', null, null, null, '$logstatus', null, null, null, '$month', '$year','$lateDur');";

                $query = mysqli_query($connection, $insertAttendance) or die(mysqli_error($connection) . $insertAttendance);

                $imageUrl = '<img height="100" width="100" src="image/' . $empImg . '" alt="" > ';
                echo $imageUrl;
                echo '<div style="margin-top: 10px;" class="alert alert-success"><strong>' . $empName . '</strong> successfully logged in [Graveyard shift]</div>';
                break;
              }
          }
        }
      } else {
        echo '<div class="alert alert-danger"><strong>Failed!</strong> Employee is not Registered</div>';
      }
    } else {
      echo '<div class="alert alert-danger"><strong>Failed!</strong> Invalid QR code/ Employee is not Registered</div>';
    }
  }
}
// Output "no suggestion" if no hint was found or output correct values
//echo $hint === "" ? "no suggestion" : $hint;
?>