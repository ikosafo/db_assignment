<?php
include('../../../config.php');
include("../../../system_functions.php");

$username = $_SESSION['username'];
$user = $_POST['user']; // No need for escaping with prepared statements

try {

    foreach ($_POST['permission'] as $permission) {
        $checkQuery = "SELECT COUNT(*) AS permissionCount FROM dbo.userpermission WHERE userid = ? AND permission = ?";
        $checkStmt = sqlsrv_prepare($conn, $checkQuery, array(&$user, &$permission));
        sqlsrv_execute($checkStmt);
        $row = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC);
        $permissionCount = $row['permissionCount'];

        if ($permissionCount == 0) {
            $datetime = date('Y-m-d H:i:s'); // Get current datetime

            $insertQuery = "INSERT INTO dbo.userpermission (userid, permission, datetime) VALUES (?, ?, ?)";
            $insertStmt = sqlsrv_prepare($conn, $insertQuery, array(&$user, &$permission, &$datetime));
            sqlsrv_execute($insertStmt);

            echo 1; // Insertion successful
        } else {
            echo 2; // Permission already exists
        }
    }

    sqlsrv_close($conn);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
