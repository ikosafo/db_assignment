<?php
include('../../../config.php');
include("../../../system_functions.php");

$username = $_SESSION['username'];
$theid = $_POST['i_index']; // Assuming $conn is the SQL Server connection from your config.php

// Delete employee
$sql = "DELETE FROM dbo.Customer WHERE customerNo = ?";
$params = array($theid);
$stmt = sqlsrv_prepare($conn, $sql, $params);

if ($stmt === false) {
    // Handle prepare statement error
    die(print_r(sqlsrv_errors(), true));
}

$result = sqlsrv_execute($stmt);

if ($result === false) {
    // Handle execution error
    die(print_r(sqlsrv_errors(), true));
}

echo 1;
