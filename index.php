<?php

$timezone = 'Asia/Manila';
date_default_timezone_set($timezone);
?>
<!doctype html>
<html lang="en" dir="ltr">

<head>
	<?php require_once('admin/includes/script.php') ?>
	<title>Profiling and Payroll Management System</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon" />
	<!-- Dashboard Core -->
	<link href="./assets/css/dashboard.css" rel="stylesheet" />

</head>

<body class="">
	<div class="page">
		<div class="page-single">
			<div class="container">
				<div style="padding-bottom: 20px;" class="text-center">
					<img src="image/labavendologo.jpg" width="100" alt="">
				</div>
				<div style="padding-bottom: 20px;" class="text-center">
					<h1 id="date"></h1>
					<h1 class="text" id="time"></h1>

				</div>
				<div style="padding-bottom: 20px;" class="h-100 d-flex align-items-center justify-content-center ">
					<div class="col-lg-6 ">
						<div class="card">
							<div class="card-header ">
								<h3 class="card-title "><i class="fe fe-clock"></i> <b>Attendance Monitorng</b>
								</h3>
								<!-- <div class="card-title">
									<h6 class="card-text text-muted">&nbsp;&nbsp;6:00 am - 3:00 pm</h6>
								</div> -->
								<div class="card-options">
									<a href="time-in-attendance.php" class="btn btn-primary btn-sm">Time In</a>
									<a href="time-out-attendance.php" class="btn btn-warning btn-sm ml-2">Time Out</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- <div style="padding-bottom: 20px;" class="h-100 d-flex align-items-center justify-content-center">
					<div class="col-lg-6 ">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><b>Morning Attendance</b> <i class="fe fe-sunrise"></i>

								</h3>
								<div class="card-title">
									<h6 class="card-text text-muted">&nbsp;&nbsp;6:00 am - 3:00 pm</h6>
								</div>
								<div class="card-options">
									<a href="time-in-morning.php" class="btn btn-primary btn-sm">Time In</a>
									<a href="time-out-morning.php" class="btn btn-warning btn-sm ml-2">Time Out</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><b>Midshift Attendance</b> <i class="fe fe-sunset"></i></h3>
								<div class="card-title">
									<h6 class="card-text text-muted">&nbsp;&nbsp;2:00 pm - 11:00 pm</h6>
								</div>
								<div class="card-options">
									<a href="time-in-afternoon.php" class="btn btn-primary btn-sm">Time In</a>
									<a href="time-out-afternoon.php" class="btn btn-warning btn-sm ml-2">Time Out</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><b>Graveyard Attendance</b> <i class="fe fe-moon"></i></h3>
								<div class="card-title">
									<h6 class="card-text text-muted">&nbsp;&nbsp;10:00 pm - 7:00 am</h6>
								</div>
								<div class="card-options">
									<a href="time-in-graveyard.php" class="btn btn-primary btn-sm">Time In</a>
									<a href="time-out-graveyard.php" class="btn btn-warning btn-sm ml-2">Time Out</a>
								</div>
							</div>
						</div>
					</div>
					</center>
				</div> -->
			</div>
		</div>
		<a href="employee" target="_blank" class="btn">
			<h4><span class="badge badge-primary">Employee Login</span></h4>
		</a>
		<a href="admin" target="_blank" class="btn">Go to Dashboard Panel</a>
	</div>


	<!-- jQuery 3 -->
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Moment JS -->
	<script src="bower_components/moment/moment.js"></script>
	<script type="text/javascript">
		$(function() {
			var interval = setInterval(function() {
				var momentNow = moment();
				$('#date').html(momentNow.format('dddd').substring(0, 3).toUpperCase() + ' - ' + momentNow.format('MMMM DD, YYYY'));
				$('#time').html(momentNow.format('hh:mm:ss A'));
			}, 100);

			$('#attendance').submit(function(e) {
				e.preventDefault();
				var attendance = $(this).serialize();
				$.ajax({
					type: 'POST',
					url: 'attendance.php',
					data: attendance,
					dataType: 'json',
					success: function(response) {
						if (response.error) {
							$('.alert').hide();
							$('.alert-danger').show();
							$('.message').html(response.message);
						} else {
							$('.alert').hide();
							$('.alert-success').show();
							$('.message').html(response.message);
							$('#employee').val('');
						}
					}
				});
			});
		});
	</script>
</body>

</html>