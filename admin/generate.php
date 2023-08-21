<?php


include('phpqrcode/qrlib.php');

require_once('includes/script.php');
require_once('session/Login.php');

$model = new Dashboard();
$session = new AdministratorSession();
$session->LoginSession();

if (!isset($_SESSION['official_username']) && !isset($_SESSION['official_password']) && !isset($_SESSION['official_id'])) {
   header("location:index.php?utm_campaign=expired");
}

$employee_id = $_GET['id'];

$model = new Dashboard();
$password = $_SESSION['official_password'];
$username = $_SESSION['official_username'];
$uid = $_SESSION['official_id'];

$connection = $model->TemporaryConnection();


$date = date('Y-m-d');
$path = 'employee_barcode/' . $employee_id . '.png';

QRcode::png($employee_id, $path, QR_ECLEVEL_H, 4);

$insert = "INSERT INTO `barcode` (`employee_id`, `generated_on`, `path`, `bool_gen`) VALUES ('$employee_id', '$date', '$path', '1');";
$q = mysqli_query($connection, $insert);

header("location: view.php?id=$employee_id&generate=1");
