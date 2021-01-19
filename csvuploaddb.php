<?php
session_start();

include "connection.php";

if ($_FILES['csvuploaddb']['tmp_name'] !== "") {
    $file_data = fopen($_FILES['csvuploaddb']['tmp_name'], 'r');
    fgetcsv($file_data);
    $csv_row = file($_FILES['csvuploaddb']['tmp_name']);

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

    for ($i = 0; $i < $total; $i++) {
        if (!empty($unique[$i])) {
            $new_data[] = array(
                'Name' => $name_data[$i],
                'Mobile' => $unique[$i],
            );
        }
    }
    //print_r($new_data);
    function test_data($data)
    {
        $data = stripcslashes($data);
        $data = htmlentities($data);
        $data = trim($data);
        return $data;
    }

    foreach ($new_data as $row) {
        // echo $row["Name"];
        $query = "INSERT INTO csv (name, mobile) VALUES ('" . mysqli_real_escape_string($con, test_data($row["Name"])) . "','" . mysqli_real_escape_string($con, test_data($row["Mobile"])) . "');";
        $result = mysqli_query($con, $query);
    }
    if ($result == 0) {
        $_SESSION['time'] = time();
        $_SESSION['error'] = "Error " . mysqli_error($con);
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['time'] = time();
        $_SESSION['succ'] = "Data Inserted!";
        header("Location: index.php");
        exit();
    }
    mysqli_close($con);
} else {
    $_SESSION['error'] = "File is empty!";
    header("Location: index.php");
    exit;
}
