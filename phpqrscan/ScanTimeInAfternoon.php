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
      $time_in = date('H:i:s');
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



        // Generate your image URL here


        // Set appropriate headers for image content

        $imageUrl = '<img height="100" width="100" src="image/' . $empImg . '" alt="" > ';

        echo $imageUrl;

        echo '<div style="margin-top: 10px;" class="alert alert-success"><strong>' . $empName . '</strong> successfully logged in  </div>';


        $queryEmployeeId = "SELECT * FROM `employees` WHERE `employee_id` = '$content';";
        $queryResult = mysqli_query($connection, $queryEmployeeId);
        $rowQuery = mysqli_fetch_assoc($queryResult);

        $employee_id = $rowQuery['id'];
        $schedule_id = $rowQuery['schedule_id'];

        $sched = "SELECT * FROM `schedules` WHERE `id` = '$schedule_id';";
        $querySched = mysqli_query($connection, $sched);
        $schedRow = mysqli_fetch_assoc($querySched);

        $logstatus = ($time_in > $schedRow['time_in_afternoon']) ? 1 : 1;

        $insert = "UPDATE `attendance` SET `time_in_afternoon` = '$time_in', `status_afternoon` = '$logstatus' WHERE `employee_id` = '$employee_id' AND `date` = '$date';";

        $query = mysqli_query($connection, $insert) or die(mysqli_error($connection) . $insert);
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