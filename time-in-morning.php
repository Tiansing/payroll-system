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
			overflow-y: scroll;
			height: 350px;
		}

		.table-scroll tr {
			width: 100%;
			table-layout: fixed;
			display: inline-table;
		}

		.table-scroll thead>tr>th {
			border: none;
		}
	</style>
</head>

<body class="">
	<div class="page" id="app">
		<div class="page-single">
			<div class="container">
				<div style="padding-bottom: 20px;" class="text-center">
					<h1 id="date"></h1>
					<h1 class="text" id="time"></h1>
				</div>

				<div class="">
					<center>
						<div>
							<h4 class="timein">Time In Morning</h4>
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

								function showHint(str) {
									if (str.length == 0) {
										document.getElementById("txtHint").innerHTML = "";
										return;
									} else {
										var xmlhttp = new XMLHttpRequest();
										xmlhttp.onreadystatechange = function() {
											if (this.readyState == 4 && this.status == 200) {
												document.getElementById("txtHint").innerHTML = this.responseText;
											}
										};
										xmlhttp.open("GET", "phpqrscan/gethint.php?q=" + str, true);
										xmlhttp.send();
									}
								}

								function playAudio() {
									x.play();
								}
							</script>
							<div class="col" style="padding:30px;">
								<h4>SCAN RESULTs</h4>
								<div>Employee name</div>
								<form action="">
									<input type="text" required="true" v-model="time_in_morning" class="form-control" name="start" class="input" id="result" onkeyup="showHint(this.value)" placeholder="Employee Identification here" readonly="" style="text-align: center;" />
								</form>
								<p style="padding-top: 20px;"> Status: <span id="txtHint"></span></p>


								<div>
									<div class=" well">
										<table class="table table-scroll table-striped">
											<thead>
												<tr>
													<th>#</th>
													<th>First Name</th>
													<th>Last Name</th>
													<th>County</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td>Andrew</td>
													<td>Jackson</td>
													<td>Washington</td>
												</tr>
												<tr>
													<td>2</td>
													<td>Thomas</td>
													<td>Marion</td>
													<td>Jackson</td>
												</tr>
												<tr>
													<td>3</td>
													<td>Benjamin</td>
													<td>Warren</td>
													<td>Lincoln</td>
												</tr>
												<tr>
													<td>4</td>
													<td>Grant</td>
													<td>Wayne</td>
													<td>Union</td>
												</tr>
												<tr>
													<td>5</td>
													<td>John</td>
													<td>Adams</td>
													<td>Marshall</td>
												</tr>
												<tr>
													<td>6</td>
													<td>Morgan</td>
													<td>Lee</td>
													<td>Lake</td>
												</tr>
												<tr>
													<td>7</td>
													<td>John</td>
													<td>Henry</td>
													<td>Brown</td>
												</tr>
												<tr>
													<td>8</td>
													<td>William</td>
													<td>Jacob</td>
													<td>Orange</td>
												</tr>
												<tr>
													<td>9</td>
													<td>Kelly</td>
													<td>Davidson</td>
													<td>Taylor</td>
												</tr>
												<tr>
													<td>10</td>
													<td>Colleen</td>
													<td>Hurst</td>
													<td>Randolph</td>
												</tr>
												<tr>
													<td>11</td>
													<td>Rhona</td>
													<td>Herrod</td>
													<td>Cumberland</td>
												</tr>
												<tr>
													<td>12</td>
													<td>Jane</td>
													<td>Paul</td>
													<td>Marshall</td>
												</tr>
												<tr>
													<td>13</td>
													<td>Ashton</td>
													<td>Fox</td>
													<td>Calhoun</td>
												</tr>
												<tr>
													<td>14</td>
													<td>Garrett</td>
													<td>John</td>
													<td>Madison</td>
												</tr>
												<tr>
													<td>15</td>
													<td>Fredie</td>
													<td>Winters</td>
													<td>Washington</td>
												</tr>
											</tbody>
										</table>
									</div>

								</div>
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