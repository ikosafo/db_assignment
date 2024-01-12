<?php
include('../../../config.php');
include("../../../system_functions.php");

$username = $_SESSION['username'];
$theid = $_POST['i_index'];

// Assuming $conn is the SQL Server connection from your config.php

// Initialize the SQL query
$sql = "{CALL DeleteProduct(?)}";

// Prepare the statement
$stmt = sqlsrv_prepare($conn, $sql, array(&$theid));

if ($stmt === false) {
    // Handle prepare statement error
    die(print_r(sqlsrv_errors(), true));
}

// Execute the statement
$result = sqlsrv_execute($stmt);

if ($result === false) {
    // Handle execution error
    die(print_r(sqlsrv_errors(), true));
}

// Fetch the result
while (sqlsrv_next_result($stmt)) {
    // Empty loop to get to the result
}

// Check the result code
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
$resultCode = $row['ResultCode'];

echo $resultCode;
