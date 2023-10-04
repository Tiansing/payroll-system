<?php
// Your database connection code here

require_once('../admin/includes/script.php');
require_once('../admin/session/Login.php');

$set_timezone = date_default_timezone_set("Asia/Manila");
$today = date('Y-m-d');
$model = new Dashboard();
$session = new AdministratorSession();
$session->LoginSession();
$connection = $model->TemporaryConnection();

$queryPosition = "SELECT *, employees.employee_id AS empid, attendance.id AS attid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id  WHERE  attendance.date='$today' ORDER BY attendance.id DESC ;";
$queryResult = mysqli_query($connection, $queryPosition);

$output = '';

while ($row = mysqli_fetch_assoc($queryResult)) {

    if (isset($row['time_in_morning'])) {
        $timeAtt = $row['time_in_morning'];
        $statusAtt = ($row['status_morning']) ? '&nbsp&nbsp<span class="badge badge-info">Ontime</span>' : '&nbsp&nbsp<span class="badge badge-warning">Late</span>';
    } elseif (isset($row['time_in_afternoon'])) {
        $timeAtt = $row['time_in_afternoon'];
        $statusAtt = ($row['status_afternoon']) ? '&nbsp&nbsp<span class="badge badge-info">Ontime</span>' : '&nbsp&nbsp<span class="badge badge-warning">Late</span>';
    } elseif (isset($row['time_in_graveyard'])) {
        $timeAtt = $row['time_in_graveyard'];
        $statusAtt = ($row['status_graveyard']) ? '&nbsp&nbsp<span class="badge badge-info">Ontime</span>' : '&nbsp&nbsp<span class="badge badge-warning">Late</span>';
    }

    $output .= '<tr >';
    $output .= '<td>' . $row['employee_id'] . '</td>';
    $output .= '<td>' . $row['fullname'] . '</td>';
    $output .= '<td>' . date('h:i A', strtotime($timeAtt)) . $statusAtt . '</td>';
    $output .= '</tr>';
}

// Close database connection
mysqli_close($connection);

// Output the updated table rows as HTML
echo
'<table class="table table-scroll table-striped ">
<thead>
    <tr >
        <th> ID</th>
        <th> Employee Name</th>
        <th style="padding-left:40px;"> Time In</th>
    </tr>
</thead>

' . $output
    . '</table>';
