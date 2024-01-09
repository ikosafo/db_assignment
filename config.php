<?php

date_default_timezone_set('UTC');
$datetime = date("Y-m-d H:i:s");
$serverName = "LAPTOP-KMJFH16K\\SQLEXPRESS"; // Replace with your SQL Server instance and port
$connectionInfo = array(
    "Database" => "companyOrders",
    "UID" => "",
    "PWD" => ""
);

$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn === false) {
    echo "Cannot connect. SQLSRV error: " . sqlsrv_errors()[0]['code'] . ": " . sqlsrv_errors()[0]['message'];
    exit();
} else {
    //echo "Connected successfully to SQL Server.";
    // Perform operations here with $conn
}
