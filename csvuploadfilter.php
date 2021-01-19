<?php
session_start();

include "connection.php";

if ($_FILES['csvupload']['tmp_name'] !== "") {
	$file_data = fopen($_FILES['csvupload']['tmp_name'], 'r');
	fgetcsv($file_data);
	$csv_row = file($_FILES['csvupload']['tmp_name']);

	$name_data = array();
	$mobile_data = array();
	$whole_data = array();

	while ($row = fgetcsv($file_data)) {
		array_push($name_data, $row[0]);
		array_push($mobile_data, $row[1]);
		array_push($whole_data, array($row[0] => $row[1]));
	}

	$unique = array_unique($mobile_data);
	$total = count($whole_data);

	function test_data($data)
	{
		$data = stripcslashes($data);
		$data = htmlentities($data);
		$data = trim($data);
		return $data;
	}

	$new_data_name = array();
	$new_data_mobile = array();

	for ($i = 0; $i < $total; $i++) {
		if (!empty($unique[$i])) {
			array_push($new_data_name, test_data($name_data[$i]));
			array_push($new_data_mobile, test_data($unique[$i]));
		}
	}

	$sql = "SELECT name,mobile FROM csv";
	$result = mysqli_query($con, $sql);
	if (mysqli_num_rows($result) == 0) {
		$_SESSION['time'] = time();
		$_SESSION['error'] = "No records in Database to compare!";
		header("Location: index.php");
		exit();
	} else {
		$db_data_name = array();
		$db_data_mobile = array();

		while ($row = $result->fetch_assoc()) {
			array_push($db_data_name, $row["name"]);
			array_push($db_data_mobile, $row["mobile"]);
		}
	}

	$db_csv_diff = array_diff($new_data_mobile, $db_data_mobile);

	$new_diff_data = array();

	for ($i = 0; $i < $total; $i++) {
		if (!empty($db_csv_diff[$i])) {
			$new_diff_data[] = array(
				'Name' => $new_data_name[$i],
				'Mobile' => $new_data_mobile[$i],
			);
		}
	}
	//print_r($new_diff_data);

	header("Content-Type: text/csv; charset=utf-8");
	header("Content-Disposition: attachment; filename=filtered_csv.csv");
	$output = fopen("php://output", "w");
	fputcsv($output, array('Name', 'Mobile'));
	foreach ($new_diff_data as $row) {
		fputcsv($output, $row);
	}
	fclose($output);
} else {
	$_SESSION['error'] = "File is empty!";
	header("Location: index.php");
	exit;
}
