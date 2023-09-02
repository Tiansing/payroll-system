<?php

include "/session/Login.php";
session_start();
$_SESSION['employee_id'] = null;
$_SESSION['employee_password'] = null;
$_SESSION['employee_username'] = null;
header("location:index.php?utm_campaign=logout");
