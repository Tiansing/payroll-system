<?php
$timezone = 'Asia/Manila';
date_default_timezone_set($timezone);

require_once('admin/includes/script.php');
require_once('admin/session/Login.php');

$model = new Dashboard();
$session = new AdministratorSession();
$session->LoginSession();
$model = new Dashboard();

$connection = $model->TemporaryConnection();


$Attendance = '';
$today = date('Y-m-d');
$stat = '';
if (isset($_GET['status'])) {
	$Attendance = $_GET['status'];
}

if (isset($_GET['filter'])) {
	$today = $_GET['filter'];
}

if ($Attendance == '1') {
	$stat = '<div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert"></button>
  Attendance for the day already exist.
</div>';
} else {
}
?>
<!doctype html>
<html lang="en" dir="ltr">

<head>
	<?php require_once('admin/includes/script.php') ?>
	<title>Profiling and Payroll Management System</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon" />
	<!-- Dashboard Core -->
	<link href="./assets/css/dashboard.css" rel="stylesheet" />

	<script src="phpqrscan/ht.js"></script>


	<style>
		.result {
			background-color: green;
			color: #fff;
			padding: 20px;
		}

		.row {
			display: flex;
		}


		/* table */
		.well {

			height: auto;

		}

		.table-scroll tbody {
			position: absolute;
			overflow-y: hidden;
			height: 200px;
		}

		.table-scroll tr {
			width: 100%;
			table-layout: fixed;
			display: inline-table;
		}

		.table-scroll thead>tr>th {
			border: none;
		}

		.custom-header {

			color: white;
			padding: 10px;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.back-button {
			padding: 5px 10px;
			border: none;

			color: white;
			cursor: pointer;
		}

		.title {
			font-size: 24px;
			margin: 0;
		}
	</style>
</head>

<body class="" onload="table()">
	<div class="page" id="app">
		<div class="page-single">
			<div class="container">



				<div style="padding-bottom: 5px;" class="text-center">
					<h3 id="date"></h3>
					<h3 class="text" id="time"></h3>
				</div>

				<div class="">
					<center>
						<div style="padding-bottom: 10px;" class="container-fluid">

							<div class="container bg-warning">
								<div class="row">
									<div class="col-12">
										<div class="custom-header">
											<a href="index.php" class="btn btn-info back-button">
												< Back</a>

													<h1 class="timein title text-center">Time Out Morning</h1>
													<div></div> <!-- Empty div for spacing on the right side -->

										</div>

									</div>
								</div>
							</div>

						</div>

						<!-- SCANNER -->
						<div class="row" style="padding-bottom: 40px;">
							<div class="col">
								<div style="width:500px;" id="reader"></div>

							</div>

							<!-- <audio id="myAudio1">
								<source src="phpqrscan/success.mp3" type="audio/ogg">
							</audio>
							<audio id="myAudio2">
								<source src="phpqrscan/failes.mp3" type="audio/ogg">
							</audio> -->

							<script>
								var x = document.getElementById("myAudio1");
								var x2 = document.getElementById("myAudio2");

								// function showHint(str) {
								// 	if (str.length == 0) {
								// 		document.getElementById("txtHint").innerHTML = "";
								// 		document.getElementById("imageOutput").src = ""; // Clear the image
								// 		return;
								// 	} else {
								// 		var xmlhttp = new XMLHttpRequest();
								// 		xmlhttp.onreadystatechange = function() {
								// 			if (this.readyState == 4 && this.status == 200) {
								// 				document.getElementById("txtHint").innerHTML = this.responseText;
								// 				document.getElementById("imageOutput").src = this.responseText;
								// 			}
								// 		};
								// 		xmlhttp.open("GET", "phpqrscan/ScanTimeInMorning.php?q=" + str, true);
								// 		xmlhttp.send();


								// 	}
								// }

								function showHint(str) {
									if (str.length == 0) {
										document.getElementById("txtHint").innerHTML = "";
										return;
									} else {
										var xmlhttp = new XMLHttpRequest();
										xmlhttp.onreadystatechange = function() {
											if (this.readyState == 4 && this.status == 200) {
												// Assuming the response is an image URL
												document.getElementById("txtHint").innerHTML = this.responseText;
											}
										};
										xmlhttp.open("GET", "phpqrscan/ScanTimeOutMorning.php?q=" + str, true);
										xmlhttp.send();
									}
								}

								function playAudio() {
									x.play();
								}
							</script>


							<div class="col" style="padding:30px;">

								<div>Employee ID</div>
								<form action="">


									<input type="text" required="true" v-model="time_in_morning" class="form-control" name="start" class="input" id="result" onkeyup="showHint(this.value)" placeholder="Employee Identification here" style="text-align: center;" disabled />

								</form>

								<div id="txtHint">

								</div>
								<!-- <p style="padding-top: 20px;" id="txtHint"> Status: <span id="txtHint"></span></p> -->

								<div id="table-body">


								</div>
								<!-- Include Bootstrap JS and jQuery -->
								<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
								<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
								<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

								<script>
									function fetchNewRecords() {
										$.ajax({
											url: 'phpqrscan/TimeOutMorning_new_records.php', // Your server-side script to fetch new records
											method: 'GET',
											dataType: 'html',
											success: function(data) {
												$('#table-body').html(data);
											},
											error: function(xhr, status, error) {
												console.log('Error:', error);
											}
										});
									}

									// Fetch new records every 5 seconds
									setInterval(function() {
										fetchNewRecords();
									}, 100);
								</script>
							</div>



						</div>
						<div>

						</div>
						<script type="text/javascript">
							function onScanSuccess(qrCodeMessage) {
								document.getElementById("result").value = qrCodeMessage;
								showHint(qrCodeMessage);
								playAudio();

							}

							function onScanError(errorMessage) {
								//handle scan error
							}
							var html5QrcodeScanner = new Html5QrcodeScanner(
								"reader", {
									fps: 10,
									qrbox: 250
								});
							html5QrcodeScanner.render(onScanSuccess, onScanError);
						</script>

						<!-- SCANNER -->
						<!-- <div class="col-md-4">
							<div class="form-group">
								<form v-on:submit.prevent="TimeInMorning">
									<input type="text" required="true" v-model="time_in_morning" class="form-control" id="employee-id" placeholder="Employee Identification" autofocus="true">
								</form>
							</div>
						</div> -->
					</center>
					</center>
				</div>
			</div>
		</div>
		<a href="admin" target="_blank" class="btn">Go to Dashboard Panel</a>
	</div>
	</div>
	</div>

	<!-- jQuery 3 -->
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Moment JS -->
	<script src="bower_components/moment/moment.js"></script>

	<script src="js/model.js"></script>



	<script type="text/javascript">
		$(function() {
			var interval = setInterval(function() {
				var momentNow = moment();
				$('#date').html(momentNow.format('dddd').substring(0, 3).toUpperCase() + ' - ' + momentNow.format('MMMM DD, YYYY'));
				$('#time').html(momentNow.format('hh:mm:ss A'));
			}, 100);
		});
	</script>
</body>

</html>