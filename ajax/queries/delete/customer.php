<?php
include('../../../config.php');
include("../../../system_functions.php");

$username = $_SESSION['username'];
$theid = $_POST['i_index']; // Assuming $conn is the SQL Server connection from your config.php

// Execute the stored procedure
$deleteProcedure = "{CALL DeleteCustomer(?)}";
$deleteParams = array($theid);
$deleteStmt = sqlsrv_query($conn, $deleteProcedure, $deleteParams);

if ($deleteStmt === false) {
    // Handle execution error
    echo "Error executing stored procedure: </br>";
    die(print_r(sqlsrv_errors(), true));
}

// Check the result of the stored procedure
$row = sqlsrv_fetch_array($deleteStmt, SQLSRV_FETCH_ASSOC);

if ($row && $row['Result'] == 1) {
    echo "Record deleted successfully!";
} else {
    echo "Error deleting record.";
}

// Close the SQL Server connection
sqlsrv_close($conn);
