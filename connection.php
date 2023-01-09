<?php

$dbserver = "localhost";
$dbuname = "root";
$dbpass = "";
$dbDB = "csv_duplicate";

$con = mysqli_connect($dbserver, $dbuname, $dbpass, $dbDB);

if (!$con) {
	echo ("Error connecting " . mysqli_connect_error($con));
    //exit;
}
